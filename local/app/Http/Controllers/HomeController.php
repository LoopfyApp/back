<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Auth;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
{
    public function home()
    {
        if (Auth::check()) {
            return redirect('/admin/home');
        }
        return view('index');
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('login')
                        ->withErrors($validator)
                        ->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password ])) {
           
            if(Auth::user()->type !=1 ){
                return redirect('/admin/home');
            }
            else{
                Auth::logout(); 
                return redirect('login')->withErrors('Erro de credenciais');
            }
           
        } else {
            return redirect('login')->withErrors('Erro de credenciais');
        }
    }

    public function logout(Request $request){
        Auth::logout(); 
        return redirect('login');

    }
}
