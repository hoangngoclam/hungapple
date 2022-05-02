<?php

namespace App\Services;

use App\Models\User;
use App\Models\Admin;
use Session;

class UserService
{
    protected $user;
    protected $admin;
    public function __construct(User $user, Admin $admin)
    {
        $this->user = $user;
        $this->admin = $admin;
    }

    //Handle home
    public function getAll(){
        return $this->user::all();
    }

    // public function getListProductByCategoryId($categoryId, $take, $nameSort){
    //     return $this->productRepository->getListProductByCategoryId($categoryId, $take,$nameSort);
    // }

    //Handle listProduct
    public function getListUser($take, $nameSort){
        return $this->user::orderBy($nameSort, 'desc')->take($take)->get();
    }

    public function getById($id){
        return $this->user::find($id);
    }
    // 1- email đã tồn tại
    // 2 - mật khẩu không khớp
    // 3 - Tạo tài khoản không thành công
    // 4 - Tạo tài khoản thành công
    public function signUp($email, $password, $confirm_password){
        if($this->checkEmail($email)==true){
            return 1;
        }
        if($password == $confirm_password){
            $result = $this->create($email, $password);
            if($result == true){
                return 4;
            }
            return 3;
        }
        return 2;
    }

    public function signIn($email, $password){
        $result = $this->compare($email, $password);
        if($result !== null){
            $user = array('id' => $result->id, 'email' => $result->email , 'name' => $result->userName);
            Session::put('user', $user);
            Session::save();
            return true;
        }
        return false;
    }

    public function signOut(){
        $user = null;
        $user = Session::get('user');
        if($user){
            Session::put('user', null);
            Session::save();
            return true;
        }
        return false;
    }

    public function signInAdmin($email, $id, $password){
        $result = $this->compareEmailIdPasswordAdmin($email, $id, $password);
        if($result !== null){
            $admin = array('id' => $result->id, 'email' => $result->email , 'name' => $result->name);

            Session::put('admin', $admin);
            Session::save();
            return true;
        }
        return false;
    }

    public function signOutAdmin(){
        $user = null;
        $user = Session::get('admin');
        if($user){
            Session::put('admin', null);
            Session::save();
            return true;
        }
        return false;
    }

    public function create($email, $password){
        if($email !==null && $password!==null){
            $this->user->email = $email;
            $this->user->password = md5($password);
            $this->user->save();
            return true;
        }
        
        return false;
    }

    public function checkEmail($email){
        if($email !==null){
            $result = $this->user::where('email', $email)->first();
            if($result)
                return true;
        }

        return false;
    }


    public function compare($email, $password){
        if ($email !==null && $password!==null) {
            $result = $this->user::where('email', $email)->where('password', md5($password))->first();

            return $result;
        }

        return null;
    }

    public function compareEmailIdPasswordAdmin($email, $id, $password) {
        if ($email !==null && $password!==null && $id != null) {
            $result =  $this->admin::where('email', $email)->where('password', md5($password))->where('idCompany', $id)->first();

            return $result;
        }

        return null;
    }
}
