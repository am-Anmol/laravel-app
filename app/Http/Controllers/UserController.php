<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator;

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
        // dd($imageName);
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
        ->get();

        return response()->json($data);
    }
    
    public function ajax_search( Request $request ) {
        $users = User::where('name','like','%'. $request->search .'%')->orWhere('email','like','%'. $request->search .'%')->orWhere('created_at','like','%'. $request->search .  '%')->get();
        return response()->json($users);
    }
}   
