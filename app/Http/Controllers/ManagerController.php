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

            $request->session()->put('logged_in_manager_id', $manager->id);
            // 5. Tạo lại session để ngăn chặn session fixation attacks (khuyến nghị)
            $request->session()->regenerate();
            return redirect()->route('manageNews');
        }
    }

}
