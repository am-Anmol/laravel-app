<?php

namespace App\Http\Controllers;

use App\Models\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    
    public function store($id)
    {
        $user = User::findOrFail($id);
        $request = UserRequest::create([
            "owner"=> $user->name,
            "mapped_owner" => Auth::user()->name,
        ]);

        return redirect()->route("request.show");
    }

    public function show()
    {
        $requests = UserRequest::where(function($query) {
            $query->where("owner", Auth::user()->name)
                ->orWhere("mapped_owner", Auth::user()->name);
        })
        ->get();

        return view('requests', compact('requests'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRequest $userRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserRequest $userRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRequest $userRequest)
    {
        //
    }

    public function approve($id)
    {
        $request = UserRequest::findOrFail($id);
        $request->is_approved = true;
        $request->save();

        return redirect()->route('request.show');
    }
}
