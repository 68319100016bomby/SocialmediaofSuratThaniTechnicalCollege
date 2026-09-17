<?php
namespace App\Http\Controllers;
use App\Models\User;use Illuminate\Http\Request;use Illuminate\Support\Facades\Auth;use Illuminate\Support\Facades\Hash;
class AuthController extends Controller{
 public function loginForm(){return view('auth.login');}
 public function login(Request $r){$data=$r->validate(['email'=>'required|email','password'=>'required']);if(Auth::attempt($data,$r->boolean('remember'))){$r->session()->regenerate();if(!Auth::user()->is_active){Auth::logout();return back()->withErrors(['email'=>'บัญชีนี้ถูกระงับการใช้งาน']);}return redirect()->intended(route('feed'));}return back()->withErrors(['email'=>'อีเมลหรือรหัสผ่านไม่ถูกต้อง'])->onlyInput('email');}
 public function registerForm(){return view('auth.register');}
 public function register(Request $r){$data=$r->validate(['name'=>'required|max:120','student_id'=>'required|max:30|unique:users','email'=>'required|email|unique:users','department'=>'required|max:120','role'=>'required|in:student,teacher,staff','password'=>'required|min:8|confirmed']);$user=User::create($data);Auth::login($user);return redirect()->route('feed')->with('success','สร้างบัญชีสำเร็จ ยินดีต้อนรับสู่ STC Connect');}
 public function logout(Request $r){Auth::logout();$r->session()->invalidate();$r->session()->regenerateToken();return redirect()->route('login');}
}
