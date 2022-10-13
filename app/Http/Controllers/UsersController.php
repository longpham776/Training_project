<?php
namespace App\Http\Controllers;
session_start();

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller{

    public function index(Request $request){
        if(!Cookie::get('user') || !session()->has('users')){
            return redirect()->route('login');
        }
        $users = DB::table('users')->select('id','name','email','group_role','is_active')->where('is_delete',0)->orderByDesc('id');
        if(!empty($request->nameSearch)){
            $users->where('name','like','%'.$request->nameSearch.'%');
        }else if(!empty($request->emailSearch)){
            $users->where('email','like','%'.$request->emailSearch.'%');
        }else if(!empty($request->groupSearch)){
            $users->where('group_role',$request->groupSearch)->where('is_active',$request->activeSearch);
        }
        $users = $users->paginate(5); 
        $request->flash();
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
        if(session('users')[0]->id == $id){
            return redirect()->route('login');
        }
        DB::table('users')
        ->where('id',$id)
        ->update(['is_active' => 0,'is_delete' => 1]);
        return redirect()->route('home')->with('success','You delete acount successful!');
    }

    public function deact($id){
        $user = DB::table('users')->where('id',$id)->first();
        if($user->is_active == 0){
            return redirect()->route('home')->with('fail','This account is already deactive.');
        }else if(session('users')[0]->id == $id){
            return redirect()->route('login');
        }
        DB::table('users')->where('id',$id)->update(['is_active'=>0]);
        return redirect()->route('home')->with('success','You deactive account successful!');
    }

    public function addUser(Request $request){
        $request->validate([
            'name' => 'required|string|min:5',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:5|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-.]).+$/u'
        ],[
            'name.required' => 'Họ và tên không được để trống.',
            'name.min' => 'Họ và tên tối thiểu 5 ký tự trở lên.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'password.required' => 'Password không được để trống.',
            'password.min' => 'Password tối thiểu 5 ký tự trở lên.',
            'password.numbers' => 'Password tối thiểu phải có 1 số.',
            'password.regex' => 'Password tối thiểu có 1 ký tự in hoa [A-Z], 1 ký tự thường [a-z], 1 ký tự số [0-9], 1 ký tự đặc biệt [#?!@$%^&*-.]. Ex: Abc@123',
            'password.confirmed' => 'Password xác nhận không trùng khớp.',

        ]);
        if(!$request->active)   $request->active = 0;
        else $request->active = 1;
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => $request->active,
            'group_role' => $request->group
        ]);
        return redirect()->route('home')->with('success','Thêm users thành công!');
    }

    public function getUser(Request $request){
        $user = User::where('id',$request->id)->first();
        return response()->json([
            'status' => true,
            'user' => $user
        ]);
    }

    public function editUser(Request $request){
        if(session('users')[0]->email == $request->email)   
            return redirect()->route('home')->with('fail','Không thể edit trên tài khoản đăng nhập.');
        $request->validate([
            'name' => 'required|string|min:5',
            'email' => 'sometimes|required|string|email|unique:users,email,'.$request->userId,
            'password' => 'nullable|string|confirmed|min:5|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-.]).+$/u'
        ],[
            'name.required' => 'Họ và tên không được để trống.',
            'name.min' => 'Họ và tên tối thiểu 5 ký tự trở lên.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã có người sử dụng.',
            'password.required' => 'Password không được để trống.',
            'password.min' => 'Password tối thiểu 5 ký tự trở lên.',
            'password.numbers' => 'Password tối thiểu phải có 1 số.',
            'password.regex' => 'Password tối thiểu có 1 ký tự in hoa [A-Z], 1 ký tự thường [a-z], 1 ký tự số [0-9], 1 ký tự đặc biệt [#?!@$%^&*-.]. Ex: Abc@123',
            'password.confirmed' => 'Password xác nhận không trùng khớp.',
        ]);
        if(!$request->active)   $request->active = 0;
        else    $request->active = 1;
        if(!$request->password){
            User::where('id',$request->userId)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'group_role' => $request->group,
                'is_active' => $request->active
            ]);
        }else if($request->password){
            User::where('id',$request->userId)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'group_role' => $request->group,
                'is_active' => $request->active
            ]);
        }
        return redirect()->route('home')->with('success','Edit thành công.');
    }
}