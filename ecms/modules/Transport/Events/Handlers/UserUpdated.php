<?php

namespace Modules\Transport\Events\Handlers;

use Modules\User\Permissions\PermissionManager;
use Modules\User\Repositories\UserRepository;

class UserUpdated
{
    /**
     * @var UserRepository
     */
    private UserRepository $user;
    /**
     * @var PermissionManager
     */
    protected PermissionManager $permissions;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }


    public function handle($event)
    {

        $data = $event->getSubmissionData();

        $user_id= $event->getEntity()->user_id;

        $data = $this->mergeRequestWithPermissions($data);

        return $this->user->updateAndSyncRoles($user_id, $data,$data['roles']);
    }

    /**
     * @param  $data
     * @return array
     */
    protected function mergeRequestWithPermissions($data)
    {

        return array_merge($data, ['permissions' => []]);
    }

}
