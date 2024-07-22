<?php

namespace Modules\Adm\Controller;

use Foundation\Http\Request;
use Modules\Adm\Request\FormCreateUser;
use Modules\Adm\Request\FormUpdateUser;
use Modules\User\Service\UserService;

class UserManagerController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function pageManagerUser()
    {
        $pagination = $this->userService->listUser(
            ['id', 'fullname', 'username', 'email', 'tel', 'created_at', 'updated_at'],[], ['created_at' => 'desc'], 15
        );
        $users = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'label' => 1,
            'title' => 'Bảng dữ liệu thành viên',
            'users' => $users,
            'pagination' => $pagination,
            'dialog' => config('adm.user.MESSAGE.DIALOG'),
        ];
        return view('adm.viewManagerUser', $data);
    }

    public function pageAddUser()
    {
        $data = [
            'label' => 2,
            'title' => 'Biểu mẫu tạo thành viên',
        ];
        return view('adm.viewCrudUser', $data);
    }

    public function createUser(FormCreateUser $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return back()->with('fail', config('adm.user.MESSAGE.CREATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $file = $request->file('image');
        if (! is_null($file)) {
            $fileName = $file->hash()->move('public/uploads/images');
            $data['image'] = asset("uploads/images/$fileName");
        }
        $this->userService->create($data);
        return redirect()->route('adm-manager-user', ['page' => 1])
                         ->with('success', config('adm.user.MESSAGE.CREATE_SUCCESS'));
    }

    public function pageEditUser(Request $request)
    {
        $id = $request->input('id');
        $user = $this->userService->findOne(['id' => $id]);
        $data = [
            'label' => 2,
            'title' => 'Cập nhật thành viên',
            'user' => $user,
        ];
        return view('adm.viewCrudUser', $data);
    }

    public function updateUser(FormUpdateUser $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return back()->with('fail', config('adm.user.MESSAGE.UPDATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $id = $data['id'];
        unset($data['id']);
        $file = $request->file('image');
        if (is_null($file)) {
            $data['image'] = $data['image_url'];
            unset($data['image_url']);
        } else {
            $fileName = $file->hash()->move('public/uploads/images');
            $data['image'] = asset("uploads/images/$fileName");
        }
        $this->userService->updateOne($id, $data);
        return redirect()->route('adm-manager-user', ['page' => 1])
                         ->with('success', config('adm.user.MESSAGE.UPDATE_SUCCESS'));
    }

    public function deleteUser(Request $request)
    {
        $id = $request->input('id');
        if ($this->userService->deleteOne($id)) {
            return back()->with('success', config('adm.user.MESSAGE.DELETE_SUCCESS'));
        }
        return back()->with('fail', config('adm.user.MESSAGE.DELETE_FAIL'));
    }

    public function deleteMultipleUser(Request $request)
    {
        $this->userService->deleteAll(['id' => $request->all()['ids']]);
        return redirect()->route('adm-manager-user', ['page' => 1])
                         ->with('success', config('adm.user.MESSAGE.DELETE_SUCCESS'));
    }
}