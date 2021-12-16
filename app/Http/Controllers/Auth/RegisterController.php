<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'foto' => 'required|image',
            'adresa' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */


    protected function create(array $data)
    {
        $user = User::where('email',$data['email'])->first();
        if($user){
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->last_name = $data['last_name'];
            $user->picture = $data['picture'];
            $user->adresa = $data['adresa'];
            $user->save();
            return $user;
        }else {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'last_name' => $data['last_name'],
                'picture' => $data['picture'],
                'adresa' => $data['adresa'],
            ]);
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user=new User();

        $image=$request->file('foto')->getClientOriginalName();
        $filename= pathinfo($image,PATHINFO_FILENAME);
        $extension= $request->file('foto')->getClientOriginalExtension();
        $filetostore=$filename.'_'.time().'.'.$extension;
        $path= $request->file('foto')->storeAs('public/images', $filetostore);

        $user->name=$request->name;
         $user->last_name=$request->last_name;
          $user->email=$request->email;
           $user->password=Hash::make($request->password);
          $user->picture=$filetostore;
           $user->adresa=$request->adresa;

        $user->save();

        return $this->registered($request, $user)
            ?: redirect('/login');
    }
}
