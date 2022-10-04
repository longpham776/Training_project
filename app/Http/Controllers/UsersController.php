<?php
namespace App\Http\Controllers;
session_start();
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller{

    public function index(){
        if(!Cookie::get('user') || !session()->has('users')){
            return redirect()->route('login');
        }
        $users = DB::table('users')->select('id','name','email','group_role','is_active')->where('is_delete',0)->paginate(2);
        return view('frontend.index',compact('users'));
    }

    public function login(){
        if(session()->has('users')) return redirect()->route('home');
        return view('frontend.login');
    }

    public function postLogin(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ],[
            'email.required'=>'The :attribute is not empty',
            'password.required'=>'The :attribute is not empty'
        ]);

        $users = DB::table('users')->where('email',$request->email)->where('is_delete',0)->get();

        if($users[0]->is_active == 0){
            return redirect()->route('login')->with('fail_login','Your account is banned');
        }else if($users->isEmpty()) 
            return redirect()->route('login')->with('fail_login','Wrong email!');
        else if(!Hash::check($request->password,$users[0]->password))
            return redirect()->route('login')->with('fail_login','Wrong Password!');
        else if($request->has('remember')) {
            if(!Cookie::get('user')){
                $remem_token = Hash::make($users[0]->password).$request->_token;
                DB::table('users')
                ->where('email',$users[0]->email)
                ->update(['remember_token' => $remem_token]);
                $users[0]->remember_token = $remem_token;
                Cookie::queue('user',$users);
            }else if(Cookie::get('user')){
                $user_cookie = json_decode(Cookie::get('user'));
                if($users[0]->remember_token != $user_cookie[0]->remember_token){
                    $remem_token = Hash::make($users[0]->password).$request->_token;
                    $user_cookie[0]->remember_token = $remem_token;
                }
            }
        }
        session()->put('users',$users) ;
        return redirect()->route('home');
    }

    public function logout(){
        session()->forget('users');
        return redirect()->route('login');
    }

    public function delete($id){
        DB::table('users')
        ->where('id',$id)
        ->update(['is_active' => 0,'is_delete' => 1]);
        return redirect()->route('home')->with('success','You delete acount successful!');
    }

    public function deact($id){
        $user = DB::table('users')->where('id',$id)->get();
        if($user[0]->is_active == 0){
            return redirect()->route('home')->with('fail','This account is already deactive.');
        }else if(session('users')[0]->id == $id){
            return redirect()->route('login');
        }
        DB::table('users')->where('id',$id)->update(['is_active'=>0]);
        return redirect()->route('home')->with('success','You deactive account successful!');
    }
}