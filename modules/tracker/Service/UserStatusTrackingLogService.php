<?php

namespace Modules\Tracker\Service;

use Core\Http\ResponseBag;
use Core\Service\BaseService;
use Illuminate\Support\Facades\Request;
use Modules\Tracker\Repository\Contracts\UserStatusTrackingLogRepository;
use Modules\Tracker\Service\Contracts\UserStatusTrackingLogService as UserStatusTrackingLogServiceContract;

class UserStatusTrackingLogService extends BaseService implements UserStatusTrackingLogServiceContract
{
    protected $baseRepo;

    public function __construct(UserStatusTrackingLogRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

    /**
     * @param  array  $data
     * @return \Core\Http\ResponseBag
     */
    public function create(array $data)
    {
        $attributes = [
            'ip' => Request::ip(),
            'user_id' => isset_if($data['user_id']),
            'status' => 1,
            'created_time' => time(),
            'created_at' => date_at(),
            'updated_at' => date_at(),
        ];

        $this->baseRepo->create($attributes);

        return ResponseBag::create(['success' => true], 201);
    }

    /**
     * @param  string   $id
     * @param  array    $data
     * @return \Core\Http\ResponseBag
     */
    public function updateOne(string $id, array $data)
    {
        $responseBag = ResponseBag::create();

        $userTrackingLog = $this->baseRepo->findOne($id);

        if (is_null($userTrackingLog)) {
            $responseBag->errors = config('tracker.label.NOT_FOUND_USER_TRACKING_LOG');
        }
        
        else {
            $this->baseRepo->updateOne($id, [
                'status' => isset_if($data['status'], 1, 0),
                'updated_at' => date_at(),
                'updated_time' => time(),
            ]);

            $responseBag->status(200)->data([
                'success' => config('tracker.label.UPDATE_SUCCESS')
            ]);
        }

        return $responseBag;
    }

    /**
     * @param  string  $id
     * @return \Core\Http\ResponseBag
     */
    public function deleteOne(string $id)
    {
        $responseBag = ResponseBag::create();

        $userTrackingLog = $this->baseRepo->findOne($id);

        if (is_null($userTrackingLog)) {
            $responseBag->errors = config('tracker.label.NOT_FOUND_USER_TRACKING_LOG');
        }
        
        else {
            $this->baseRepo->deleteOne($id);

            $responseBag->status(200)->data([
                'success' => config('tracker.label.DELETE_SUCCESS')
            ]);
        }

        return $responseBag;
    }
}