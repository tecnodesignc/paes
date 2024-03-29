<?php

namespace Modules\User\Events;

use Cartalyst\Sentinel\Roles\RoleInterface;

class RoleWasCreated
{
    /**
     * @var RoleInterface
     */
    public RoleInterface $role;

    public function __construct(RoleInterface $role)
    {
        $this->role = $role;
    }
}
