<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function store( Request $request ) {
        
        $validator = Validator::make( $request->all(), [
        'name'=> 'required',
        'email' => 'required|email',
        'password'=> 'required',
        'gender' => 'required',
        'image' => 'required',
        ],
        [
        'name.required'=> 'Please Enter Your Name',
        'email.required' => 'Please Enter Your Email',
        'password.required' => 'Please Enter Your Password',
        'gender.required' => 'Please Select Your Gender',
        'image.required'=> 'Please Upload Your Image',
        ] );
        if ( $validator->fails() ) {
            return response()->json( [ 'errors' => $validator->errors() ] );
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt( $request->password );
        $user->gender = $request->gender;
        $imageName = time().'.'.$request->image->extension();
        $user->image = $imageName;
        $request->image->move(public_path('images'), $imageName);
        $user->save();

        
        return response()->json( [ 'success' => 'User registered successfully!' ] );
    }

    public function show( ) {
        $users = User::all();

        return view('users-listing', compact('users') );
    }

    public function search( Request $request ) {
        $users = DB::table('users')
        ->where(function($query) use ($request) {
            $query->where('name','like','%'. $request->search .'%')
                ->orWhere('email','like','%'. $request->search .'%');
        })
        ->whereDate('created_at', $request->date)
        ->get();
        $results = "Matching results for " .$request->search . " and " .$request->date;
        return view('users-listing', compact('users', 'results') );
    }
    public function ajax_show(Request $request ) {
        $data = User::where(function($query) use ($request) {
            $query->where('name', 'like', '%'. $request->search .'%')
                  ->orWhere('email', 'like', '%'. $request->search .'%');
        })
        ->when($request->date, function($query, $date) {
            $query->whereDate('created_at', $date);
        })
        ->when($request->gender, function($query, $gender) {
            $query->where('gender', $gender);
        })
        ->orderBy('id', 'DESC')
        ->get();

        return response()->json($data);
    }
    
    public function ajax_search( Request $request ) {
        $users = User::where('name','like','%'. $request->search .'%')->orWhere('email','like','%'. $request->search .'%')->orWhere('created_at','like','%'. $request->search .  '%')->get();
        return response()->json($users);
    }

    public function edit ($id) {
        $user = User::findOrFail($id);
        return view('users-edit', compact('user'));
    }

    public function update (Request $request, $id) {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->save();
        return redirect()->route('users.ajax-show');

    }

    public function export(Request $request)
    {   
        // dd($request->all());
        $file = Excel::raw(new UserExport($request), 'Xlsx');
        $response =  array(
            'name' => "users.xlsx",
            'file' => "data:application/vnd.ms-excel;base64,".base64_encode($file)
        );

        return response()->json($response);
    }

    public function import(Request $request) 
    {   
        Excel::import(new UsersImport, request()->file('file'));
        
        return redirect()->route('users.ajax-show');
    }
}   
