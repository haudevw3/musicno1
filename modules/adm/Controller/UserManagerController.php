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
            ['id', 'fullname', 'username', 'tel', 'address', 'email', 'created_at'],
            [], ['created_at' => 'desc'], 15
        );
        $users = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'users' => $users,
            'pagination' => $pagination,
            'dialog' => config('adm.user.MESSAGE.DIALOG'),
        ];
        return view('adm.viewManagerUser', $data);
    }

    public function pageAddUser()
    {
        return view('adm.viewCrudUser');
    }

    public function createUser(FormCreateUser $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return back()->with('fail', config('adm.user.MESSAGE.CREATE_FAIL'))
                ->withInput()->withErrors();
        }
        $this->userService->create($request->all());
        return redirect()->route('adm-manager-user', ['page' => 1])
                ->with('success', config('adm.user.MESSAGE.CREATE_SUCCESS'));
    }

    public function pageEditUser(Request $request)
    {
        $id = $request->input('id');
        $user = $this->userService->findOne(['id' => $id]);
        if (! is_null($user)) {
            return view('adm.viewCrudUser', compact('user'));
        }
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
        $ids = $request->filterInput(
            $_POST, INPUT_POST, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY
        )['ids'];
        if ($this->userService->delete(['id' => $ids])) {
            return redirect()->route('adm-manager-user', ['page' => 1])
                    ->with('success', config('adm.user.MESSAGE.DELETE_SUCCESS'));
        }
        return back()->with('fail', config('adm.user.MESSAGE.DELETE_FAIL'));
    }
}