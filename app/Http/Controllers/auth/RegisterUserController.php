<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;

class RegisterUserController extends Controller
{
    //
    public function create(){

        return view('auth.register');
    }

    // *functin  request and insert data to db
    public function store(Request $request){

        Validator::validate($request->all(),[
            'name'=>['required','max:255'],
            'phone'=>['required','max:12'],
            'age'=>['required','max:12'],
            'email'   =>['required','email','min:8','max:255','unique:users'],
            'password'=>['required','confirmed'],
            'password_confirmation'=>['required','same:password']
        ],
        [

            'name.required'=>'This field requried',
            'phone.required'=>'This field requried',
            'age.required'=>'This field requried',
            'password.min'=>'Password less 8 character',
            'password_confirmation'=>'password dont match',
            'email'=>'email not validate'
        ]
        );

        
        // when user who registers themselves are all customers.
       
        $user=new User();
        $user->username=$request->name;
        $user->phone=$request->phone;
        $user->age=$request->age;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->role='customer';  //user who registers themselves are all customers.
        if($user->save()){
            return redirect()->route('home');
        }
        return back();
        

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);




    }
}
