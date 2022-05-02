<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends BaseController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        parent::__construct();
    }

    public function login()
    {
        return view('client.pages.login');
    }

    public function postLogin(Request $request)
    {
        $validator = $request->validateWithBag(
            'signin',
            [
                'email' => 'bail|required|email',
                'password' => 'bail|required',
            ],
            [
                'email.required' => 'Nhập email',
                'email.email' => 'Email không đúng định dạng',
                'password.required' => 'Nhập mật khẩu',
            ]
        );

        $email = $request->email;
        $password = $request->password;
        if($email != null && $password != null){
            $result = $this->userService->signIn($email, $password);
            if ($result == true) {
                return redirect('/checkout');
            }
        }
        return back()->with(['email' => $email, 'password' => $password])->withErrors(['orther' => 'Email hoặc mật khẩu không đúng'], 'signin');
    }

    public function register()
    {
        return view('client.pages.register');
    }

    public function postRegister(Request $request)
    {

        $validator = $request->validateWithBag(
            'signup',
            [
                'email' => 'bail|required|email|min:6|max:50',
                'password' => 'bail|required|min:6|max:20',
                'confirmPassword' => 'required',
            ],
            [
                'email.required' => 'Nhập email',
                'email.email' => 'Email không đúng định dạng',
                'email.min' => 'Nhập email lớn hơn 6 ký tự',
                'email.max' => 'Nhập email nhỏ hơn 50 ký tự',
                'password.required' => 'Nhập mật khẩu',
                'password.min' => 'Nhập mật khẩu lớn hơn 6 ký tự',
                'password.max' => 'Nhập mật khẩu nhỏ hơn 50 ký tự',
                'confirmPassword.required' => 'Nhập xác nhận mật khẩu',
            ]
        );
        $email = $request->email;
        $password = $request->password;
        $confirmPassword = $request->confirmPassword;
        if($email != null && $password != null && $confirmPassword != null){
            $result = $this->userService->signUp($email, $password, $confirmPassword);
            // 1- email đã tồn tại
            // 2 - mật khẩu không khớp
            // 3 - Tạo tài khoản không thành công
            // 4 - Tạo tài khoản thành công
            if ($result == 1) {
                return back()->with(['password' => $password, 'confirmPassword' => $confirmPassword])->withErrors(['email' => 'Email đã tồn tại'], 'signup');
            } else if ($result == 2) {
                return back()->with(['email' => $email, 'password' => $password])->withErrors(['confirmPassword' => 'Mật khẩu không trùng khớp'], 'signup');
            } else if ($result == 3) {
                return back()->withErrors(['orther' => 'Lỗi. Hãy thử lại'], 'signup');
            } else if ($result == 4) {
                $result = $this->userService->signIn($email, $password);
                if ($result == true) {
                    return redirect('/checkout');
                }
                return redirect('/login');
            }
        }
        return back()->with(['email' => $email, 'password' => $password])->withErrors(['orther' => 'Lỗi. Hãy thử lại'], 'signup');
    }

    public function signOut()
    {
        $result = $this->userService->signOut();
        if ($result) {
            return  redirect('/login');
        }
        return redirect('/');
    }

}
