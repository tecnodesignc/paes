<?php

namespace Modules\Core\Http\Controllers\Api;

use Modules\Core\Http\Controllers\BasePublicController;
use Modules\User\Entities\Sentinel\User;
use Modules\Iprofile\Entities\Role;
use Illuminate\Support\Arr;

class PermissionsApiController extends BasePublicController
{
    //Get settings by relatedId and entityName
    public function index($params = [])
    {
        $params = (object)$params;//Conver params
        if (!$params || !$params->relatedId || !$params->entityName) return [];//Validate params
        $permissions = [];//Defualt response

        //Request
        if (!is_array($params->relatedId)) $params->relatedId = [$params->relatedId];

        //Get user permissons
        if ($params->entityName == 'user')
            $permissionsData = User::whereIn('id', $params->relatedId)->get()->pluck('permissions')->toArray();

        //Get role permissons
        if ($params->entityName == 'role')
            $permissionsData = Role::whereIn('id', $params->relatedId)->get()->pluck('permissions')->toArray();

        //Merge all permissions
        foreach ($permissionsData as $group) {
            foreach ($group as $name => $value) {
                if (!isset($permissions[$name])) $permissions[$name] = $value;
                else if (!$permissions[$name]) $permissions[$name] = $value;
            }
        }

        //Response
        return $permissions;
    }

    //Return all settings assigned to user
    public function getAll($params = [])
    {
        $params = (object)$params;//Conver params
        $permissions = [];//Default response

        if (!isset($params->user->id) || !$params->user->id) return [];//Validate userID params

        $user = $params->user;
        if (!isset($params->role->id) || !$params->role->id) $role = $user->roles()->first();//Validate roleId
        $role = $params->role;
        //Get settings per entity
        $userPermissions = $user->permissions??[];
        $rolePermissions = $role->permissions??[];

        //Merge all settings with priority
        $permissions = array_merge($rolePermissions, $userPermissions);

        //Response
        return $permissions;
    }
}
