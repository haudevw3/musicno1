<?php

namespace Modules\User\Controller;

use Foundation\Http\Request;
use Modules\User\Request\FormRegister;
use Modules\User\Request\FormUpdateUser;
use Modules\User\Service\UserService;

class UserManageController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function pageManageUser()
    {
        $pagination = $this->userService->pagination(['id', 'fullname', 'username', 'email', 'tel', 'created_at', 'updated_at']);
        $users = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'users' => $users,
            'pagination' => $pagination,
        ];
        return view('user.viewManageUser', $data);
    }

    public function pageAddUser()
    {
        $data = [
            'title' => 'Tạo tài khoản',
        ];
        return view('user.viewFormManageUser', $data);
    }

    public function createUser(FormRegister $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return response()->json($validated, 500);
        }
        $this->userService->create($request->all());
        return response()->json($validated, 201);
    }

    public function pageEditUser(Request $request)
    {
        $id = $request->input('id');
        $user = $this->userService->findOne(['id' => $id]);
        $data = [
            'title' => 'Cập nhật tài khoản',
            'user' => $user,
        ];
        return view('user.viewFormManageUser', $data);
    }

    public function updateUser(FormUpdateUser $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return response()->json($validated, 500);
        }
        $data = $request->all();
        $id = $data['id'];
        unset($data['id']);
        $this->userService->updateOne($id, $data);
        return response()->json($validated);
    }

    public function deleteUser(Request $request)
    {
        $id = $request->input('id');
        $this->userService->deleteOne($id);
        return response()->json();
    }

    public function deleteMultipleUser(Request $request)
    {
        $userIds = $request->input('user_ids');
        $userIds = is_array($userIds) ? $userIds : [$userIds];
        foreach ($userIds as $id) {
            $this->userService->deleteOne($id);
        }
        return response()->json();
    }
}