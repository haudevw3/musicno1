<?php

namespace Modules\User\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\User\Request\FormForgetPassword;
use Modules\User\Request\FormRegister;
use Modules\User\Service\Contracts\ClientService;
use Modules\User\Service\Contracts\UserService;

class UserController extends Controller
{
    protected $userService;
    protected $clientService;

    /**
     * @param  \Modules\User\Service\Contracts\UserService    $userService
     * @param  \Modules\User\Service\Contracts\ClientService  $clientService
     * @return void
     */
    public function __construct(UserService $userService, ClientService $clientService)
    {
        $this->userService = $userService;
        $this->clientService = $clientService;
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

        $this->clientService->logout($user);

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
        $responseBag = $this->clientService->login($request->all());

        return response()->json(
            $responseBag->data(), $responseBag->status()
        );
    }

    public function registerApi(FormRegister $request)
    {
        $user = $this->userService->create($request->all(), true);

        return response()->json($user, 201);
    }

    public function forgetPasswordApi(FormForgetPassword $request)
    {
        $responseBag = $this->userService->forgetPassword($request->input('email'));

        return response()->json(
            $responseBag->data(), $responseBag->status()
        );
    }

    public function verifyAccountApi(Request $request)
    {
        $responseBag = $this->userService->verifyAccount($request->all());

        if ($responseBag->status() == 200) {
            $user = $this->userService->findOne(['id' => $request->input('id')]);

            $this->clientService->create(['user_id' => $user->id]);
            Auth::login($user);
        }

        return response()->json(
            $responseBag->data(), $responseBag->status()
        );
    }

    public function refreshTokenToSendMailApi(Request $request)
    {
        $responseBag = $this->userService->refreshTokenToSendMail($request->input('id'));

        return response()->json(
            $responseBag->messages(), $responseBag->status()
        );
    }
}
