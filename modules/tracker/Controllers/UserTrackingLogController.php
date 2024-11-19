<?php

namespace Modules\Tracker\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Tracker\Service\Contracts\UserTrackingLogService;

class UserTrackingLogController extends Controller
{
    protected $userTrackingLogService;

    /**
     * @param  \Modules\Tracker\Service\Contracts\UserTrackingLogService  $userTrackingLogService
     * @return void
     */
    public function __construct(UserTrackingLogService $userTrackingLogService)
    {
        $this->userTrackingLogService = $userTrackingLogService;
    }

    public function createUserTrackingLogApi(Request $request)
    {
        $responseBag = $this->userTrackingLogService->create($request->all());

        return response()->json(
            $responseBag->data(), $responseBag->status()
        );
    }
}
