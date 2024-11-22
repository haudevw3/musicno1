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
        return view('user::viewFormUser');
    }

    public function pageEditUser($id)
    {
        $user = $this->userService->findOne(
            $id, ['name', 'username', 'email', 'roles']
        );

        if (is_null($user)) {
            return redirect()->route('adm-manage-user');
        }

        return view('user::viewFormUser', compact('user'));
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
        $response = $this->userService->updateOne(
            $request->input('id'), $request->all()
        );

        return $response->withJson();
    }

    public function deleteUserApi(Request $request)
    {
        $response = $this->userService->deleteOne(
            $request->input('id')
        );

        return $response->withJson();
    }

    public function deleteManyUserApi(Request $request)
    {
        $response = $this->userService->deleteMany(
            $request->input('user_ids')
        );

        return $response->withJson();
    }
}
