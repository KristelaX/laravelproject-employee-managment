<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Departments;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = User::find(auth()->id());

        if($user->isAdmin()){

            return view('profile.admin_profile',['user'=>$user]);
        }else{
            return view('profile.user_profile',['user'=>$user] );
        }
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'min:6',
            'foto' => 'image',
            'adresa' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);
        $user = User::find($id);
        if ($request->hasFile('foto') && !ctype_space($request->input('password'))) {

            //dd(1);
            $image = $request->file('foto')->getClientOriginalName();
            $filename = pathinfo($image, PATHINFO_FILENAME);
            $extension = $request->file('foto')->getClientOriginalExtension();
            $filetostore = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('foto')->storeAs('public/images', $filetostore);

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->last_name = $request->input('last_name');
            $user->picture = $filetostore;
            $user->adresa = $request->input('adresa');
            $user->id = $id;
        }
        else if ($request->hasFile('foto') && ctype_space($request->input('password')))
        {  // dd(2);
            $image = $request->file('foto')->getClientOriginalName();
            $filename = pathinfo($image, PATHINFO_FILENAME);
            $extension = $request->file('foto')->getClientOriginalExtension();

            $filetostore = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('foto')->storeAs('public/images', $filetostore);

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->last_name = $request->input('last_name');
            $user->adresa = $request->input('adresa');
            $user->id = $id;
        }
        else if ( !$request->hasFile('foto') && !ctype_space($request->input('password')))
        {
            //print_r('1'.$request->input('password').'    2'.$request->input('hidd_pas'));
            //dd(3);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->last_name = $request->input('last_name');
            $user->adresa = $request->input('adresa');
            $user->id = $id;
        }
        else
        {
            //dd(4);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->last_name = $request->input('last_name');
            $user->adresa = $request->input('adresa');
            $user->id = $id;
        }
        $user->save();
        return redirect()->route('profile.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
