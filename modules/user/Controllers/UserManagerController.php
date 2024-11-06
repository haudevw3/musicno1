<?php

namespace Modules\User\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\User\Request\FormRegister;
use Modules\User\Request\FormUpdateUser;
use Modules\User\Service\Contracts\UserService;

class UserManagerController extends Controller
{
    protected $userService;

    /**
     * @param  \Modules\User\Service\Contracts\UserService  $userService
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function pageAddUser()
    {
        return view('user::viewAddUser');
    }

    public function pageEditUser($id)
    {
        $user = $this->userService->findOne(
            ['_id' => $id], ['name', 'username', 'email', 'roles']
        );

        if (is_null($user)) {
            return redirect()->route('adm-manage-user');
        }

        return view('user::viewAddUser', compact('user'));
    }

    public function createUserApi(FormRegister $request)
    {
        $this->userService->create($request->all());

        return response()->json(
            ['success' => config('user.label.CREATE_SUCCESS')], 201
        );
    }

    public function updateUserApi(FormUpdateUser $request)
    {
        $updated = $this->userService->updateOne(
            $request->input('id'), $request->all()
        );

        if ($updated) {
            return response()->json(
                ['success' => config('user.label.UPDATE_SUCCESS')]
            );
        }

        return response()->json(
            ['errors' => config('user.label.UPDATE_FAILED')]
        );
    }

    public function deleteUserApi(Request $request)
    {
        $deleted = $this->userService->deleteOne(
            $request->input('id')
        );

        if ($deleted) {
            return response()->json(
                ['success' => config('user.label.DELETE_SUCCESS')]
            );
        }

        return response()->json(
            ['errors' => config('user.label.DELETE_FAILED')], 500
        );
    }
}
