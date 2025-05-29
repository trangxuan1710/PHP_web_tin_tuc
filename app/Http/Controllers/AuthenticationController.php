<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{

    public function showRegistrationForm()
    {
        return view('auth.user-signup');
    }
    /**
     * Xử lý yêu cầu đăng ký người dùng mới.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'fullName' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:clients'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ], [
                'fullName.required' => 'Tên người dùng là bắt buộc.',
                'email.required' => 'Email là bắt buộc.',
                'email.email' => 'Email không đúng định dạng.',
                'email.unique' => 'Email này đã được sử dụng.',
                'password.required' => 'Mật khẩu là bắt buộc.',
                'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
                'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            ]);

            $client = Clients::create([
                'fullName' => $request->fullName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['success' => true, 'message' => 'Đăng ký thành công!'], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors(),
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Đăng ký lỗi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi hệ thống. Vui lòng thử lại sau.'
            ], 500);
        }
    }

    public function showLoginForm()
    {
        return view('auth.user-login');
    }

    /**
     * Xử lý yêu cầu đăng nhập.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        Log::info('Login request data:', $request->all());
        try {
            $client = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ], [
                'email.required' => 'Email là bắt buộc.',
                'email.email' => 'Email không đúng định dạng.',
                'password.required' => 'Mật khẩu là bắt buộc.',
            ]);

            if (Auth::attempt($client, $request->boolean('remember'))) {
                $request->session()->regenerate();
                return response()->json(['success' => true, 'message' => 'Đăng nhập thành công!'], 200);
            }

            Log::info(Auth::check());

            return response()->json([
                'success' => false,
                'message' => 'Thông tin đăng nhập không hợp lệ.'
            ], 401);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors(),
                'message' => 'Dữ liệu không hợp lệ.'
            ], 422);
        } catch (\Exception $e) {
            Log::error('Đăng nhập lỗi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi hệ thống. Vui lòng thử lại sau.'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
