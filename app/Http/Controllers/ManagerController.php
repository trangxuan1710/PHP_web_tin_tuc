<?php

namespace App\Http\Controllers;

use App\Models\Managers;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ManagerController extends Controller
{
    function showLoginForm() {
        return view('managers.login');
    }
    function changePasswordForm() {
        return view('managers.changePassword');
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
    function handleChangePassword(Request $request) {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu mới phải có ít nhất :min ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);
        $managerId = $request->session()->get('logged_in_manager_id');
        $manager = Managers::find($managerId);
        log::info($manager);
        log::info($request->current_password);
        if (password_verify(Request('current_password'), $manager->password)) {
            throw ValidationException::withMessages([
                'current_password' => __('Mật khẩu hiện tại không chính xác.'),
            ]);
        }
        $manager->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'Mật khẩu đã được thay đổi thành công!');
    }
    function handleLogout(Request $request) {
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->route('managerLogin');
    }

}
