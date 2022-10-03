<?php
namespace App\Http\Controllers;
session_start();
use Illuminate\Http\Request;
class FrontendController extends Controller{
    public function index(){
        if(!session()->has('users')){
            return redirect()->route('login');
        }
        return view('frontend.index');
    }

    public function login(){
        return view('frontend.login');
    }
    public function postLogin(Request $request){
        
        return ;
    }
}