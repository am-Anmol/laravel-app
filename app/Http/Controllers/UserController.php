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
        ],
        [
        'name.required'=> 'Please Enter Name',
        'email.required' => 'Please Enter Email',
        'password.required' => 'Please Enter Your Password'
        ] );
        if ( $validator->fails() ) {
            return response()->json( [ 'errors' => $validator->errors() ] );
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt( $request->password );
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
        // dd( $request->all() );
        $data = DB::table('users')
        ->where(function($query) use ($request) {
            $query->where('name','like','%'. $request->search .'%')
                ->orWhere('email','like','%'. $request->search .'%');
        });
        if($request->date){
           $data =$data->whereDate('created_at', $request->date);
        }
        $data= $data->get();

        return response()->json($data);
    }
    public function ajax_search( Request $request ) {
        $users = User::where('name','like','%'. $request->search .'%')->orWhere('email','like','%'. $request->search .'%')->orWhere('created_at','like','%'. $request->search .  '%')->get();
        return response()->json($users);
    }
}   
