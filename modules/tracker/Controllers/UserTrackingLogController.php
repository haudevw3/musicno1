<?php

namespace Modules\Tracker\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Tracker\Service\Contracts\UserStatusTrackingLogService;

class UserTrackingLogController extends Controller
{
    protected $userStatusTrackingLogService;

    /**
     * @param  \Modules\Tracker\Service\Contracts\UserStatusTrackingLogService  $userStatusTrackingLogService
     * @return void
     */
    public function __construct(UserStatusTrackingLogService $userStatusTrackingLogService)
    {
        $this->userStatusTrackingLogService = $userStatusTrackingLogService;
    }

    public function createUserTrackingLogApi(Request $request)
    {
        $responseBag = $this->userStatusTrackingLogService->create($request->all());

        return response()->json(
            $responseBag->data(), $responseBag->status()
        );
    }
}
