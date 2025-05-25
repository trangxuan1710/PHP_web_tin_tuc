<?php

namespace App\Http\Controllers;

use App\Models\Managers;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
class ManagerController extends Controller
{

    function showLoginForm() {
        return view('managers.login');
    }
    function showManageNews() {
        return view('managers.manageNews');
    }
    function handleLogin(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $manager  = Managers::where('email', Request('email'))->first();
        log::info($manager);
        if(!$manager || password_verify(Request('password'), $manager->password)) {
            return back()->withErrors([
                'email' => 'Thông tin đăng nhập không hợp lệ.', // Hoặc thông báo cụ thể hơn
            ])->onlyInput('email');
        } else {
            return redirect()->route('manageNews');
        }
    }

}
