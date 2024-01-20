<?php

namespace Modules\Transport\Events\Handlers;

use Modules\User\Permissions\PermissionManager;
use Modules\User\Repositories\UserRepository;

class UserCreated
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

        $data = $this->mergeRequestWithPermissions($data);

        return $this->user->createWithRoles($data, $data['roles'], $data['is_activated']);
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
