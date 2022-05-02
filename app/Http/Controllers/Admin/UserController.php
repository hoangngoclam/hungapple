<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use App\Services\UserService;


class UserController extends BaseController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index() {
        $pageName = "Quản Lý Người Dùng";
        $users = $this->userService->getAll();
        
        return view('admin.pages.user.index', ['users' => $users, 'data' => ['pageName' => $pageName]]);
    }

    public function delete(Request $request)
    {
        try {
            if ($request->isMethod('POST')) {
                $id = $request->id;
                $user = $this->userService->getById($id);
                if (!$user) {
                    throw new Exception('Người dùng không tồn tại');
                }
                
                $respose = $user->delete();
                if (!$respose) {
                    throw new Exception('Lưu dữ liệu thất bại');
                }
                return redirect()->back()
                    ->with('success', 'Xóa người dùng ' . $user->name . ' thành công!');
            } else {
                throw new Exception('Method không phù hợp');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('fail', 'Người dùng này đã đặt hàng! ');
        }
    }
}
