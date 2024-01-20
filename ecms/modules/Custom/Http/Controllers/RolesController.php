<?php

namespace Modules\Custom\Http\Controllers;

use Cartalyst\Sentinel\Roles\RoleInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\User\Http\Controllers\Admin\BaseUserModuleController;
use Modules\User\Http\Requests\CreateRoleRequest;
use Modules\User\Http\Requests\UpdateRoleRequest;
use Modules\User\Permissions\PermissionManager;
use Modules\User\Repositories\RoleRepository;

class RolesController extends BaseUserModuleController
{
    /**
     * @var RoleRepository
     */
    private RoleRepository $role;

    public function __construct(PermissionManager $permissions, RoleRepository $role)
    {
        parent::__construct();

        $this->permissions = $permissions;
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $roles = $this->role->all();
        return view('modules.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Factory|View|Application
    {
        return view('modules.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateRoleRequest $request
     * @return mixed
     */
    public function store(CreateRoleRequest $request): mixed
    {

        $data = $this->mergeRequestWithPermissions($request);

        $this->role->create($data);

        return redirect()->route('user.role.index')
            ->withSuccess(trans('user::messages.role created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(RoleInterface $role): Factory|View|Application
    {
        /*
        if (!$role = $this->role->find($id)) {
            return redirect()->route('user.role.index')
                ->withError(trans('user::messages.role not found'));
        }*/

        return view('modules.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     * @param RoleInterface $role
     * @param UpdateRoleRequest $request
     * @return mixed
     */
    public function update(RoleInterface $role, UpdateRoleRequest $request): mixed
    {
        $data = $this->mergeRequestWithPermissions($request);

        $this->role->update($role->id, $data);

        return redirect()->route('user.role.index')
            ->withSuccess(trans('user::messages.role updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->role->delete($id);

        return redirect()->route('user.role.index')
            ->withSuccess(trans('user::messages.role deleted'));
    }


    /**
     * @param Request $request
     * @return array
     */
    protected function mergeRequestWithPermissions($request)
    {
        $permissions = $this->permissions->clean($request->permissions);

        return array_merge($request->all(), ['permissions' => $permissions]);
    }
}
