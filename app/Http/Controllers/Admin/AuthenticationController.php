<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;

class AuthenticationController extends Controller
{
    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function getSignIn() {
        return view('admin.authentication.login');
    }


    public function postSignIn(Request $request)
    {
        $validator = $request->validateWithBag(
            'signin',
            [
                'email' => 'bail|required|email|min:7',
                'password' => 'bail|required|min:7',
                'id' => 'bail|required|min:7',
            ],
            [
                'email.required' => 'Nhập email',
                'email.email' => 'Email không đúng định dạng',
                'password.required' => 'Nhập mật khẩu',
            ]
        );

        $email = $request->email;
        $password = $request->password;
        $id = $request->id;
        if($email != null && $password != null && $id != null){
            $result = $this->userService->signInAdmin($email, $id, $password);
            if ($result == true) {
                return redirect('/admin/product');
            }
        }
        return back();
    }

    public function signOut()
    {
        $result = $this->userService->signOutAdmin();
        if ($result) {
            return  view('admin.authentication.login');
        }
        return redirect('/admin/product');
    }
    

}
