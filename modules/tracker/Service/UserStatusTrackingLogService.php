<?php

namespace Modules\Tracker\Service;

use Core\Http\Response;
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
     * @return \Core\Http\Response
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

        return Response::create()->setStatus(201)->setData(['success' => true]);
    }

    /**
     * @param  string   $id
     * @param  array    $data
     * @return \Core\Http\Response
     */
    public function updateOne(string $id, array $data)
    {
        $response = Response::create();

        $userTrackingLog = $this->baseRepo->findOne($id);

        if (is_null($userTrackingLog)) {
            $response->errors = config('tracker.label.NOT_FOUND_USER_TRACKING_LOG');
        }
        
        else {
            $this->baseRepo->updateOne($id, [
                'status' => isset_if($data['status'], 1, 0),
                'updated_at' => date_at(),
                'updated_time' => time(),
            ]);

            $response->setStatus(200)->setData([
                'success' => config('tracker.label.UPDATE_SUCCESS')
            ]);
        }

        return $response;
    }

    /**
     * @param  string  $id
     * @return \Core\Http\Response
     */
    public function deleteOne(string $id)
    {
        $response = Response::create();

        $userTrackingLog = $this->baseRepo->findOne($id);

        if (is_null($userTrackingLog)) {
            $response->errors = config('tracker.label.NOT_FOUND_USER_TRACKING_LOG');
        }
        
        else {
            $this->baseRepo->deleteOne($id);

            $response->setStatus(200)->setData([
                'success' => config('tracker.label.DELETE_SUCCESS')
            ]);
        }

        return $response;
    }
}