<?php

namespace Modules\User\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Tracker\Service\Contracts\UserStatusTrackingLogService;
use Modules\User\Request\FormForgetPassword;
use Modules\User\Request\FormRegister;
use Modules\User\Service\Contracts\LoginService;
use Modules\User\Service\Contracts\UserService;

class UserController extends Controller
{
    protected $userService;
    protected $loginService;
    protected $userStatusTrackingLogService;

    /**
     * @param  \Modules\User\Service\Contracts\UserService                      $userService
     * @param  \Modules\User\Service\Contracts\LoginService                     $loginService
     * @param  \Modules\Tracker\Service\Contracts\UserStatusTrackingLogService  $userStatusTrackingLogService
     * @return void
     */
    public function __construct(UserService $userService, LoginService $loginService, UserStatusTrackingLogService $userStatusTrackingLogService)
    {
        $this->userService = $userService;
        $this->loginService = $loginService;
        $this->userStatusTrackingLogService = $userStatusTrackingLogService;
    }

    public function loginPage(Request $request)
    {
        return view('user::viewLogin');
    }

    public function registerPage()
    {
        return view('user::viewRegister');
    }

    public function logout()
    {
        $user = Auth::user();

        $this->loginService->logout($user);

        return redirect('/');
    }

    public function pageVerifyAccount(Request $request)
    {
        $data = ['id' => $request->route('id')];

        return view('user::viewVerifyAccount', $data);
    }

    public function pageForgetPassword()
    {
        return view('user::viewForgetPassword');
    }

    public function changePassword()
    {
        
    }

    public function loginApi(Request $request)
    {
        $response = $this->loginService->withAccount($request->all());

        if ($response->status() === 200) {
            $this->userStatusTrackingLogService->create(
                $response->data('user_id')
            );
        }

        return $response->withJson($excepts = ['user_id']);
    }

    public function registerApi(FormRegister $request)
    {
        $user = $this->userService->create(
            $request->all(), true
        );

        return response()->json(['id' => $user->id], 201);
    }

    public function verifyAccountApi(Request $request)
    {
        $response = $this->userService->verifyAccount($request->all());

        return $response->withJson();
    }

    public function forgetPasswordApi(FormForgetPassword $request)
    {
        $response = $this->userService->forgetPassword($request->input('email'));

        return $response->withJson();
    }


    public function refreshTokenToSendMailApi(Request $request)
    {
        $response = $this->userService->refreshTokenToSendMail($request->input('id'));

        return $response->withJson();
    }
}
