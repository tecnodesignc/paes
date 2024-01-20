<?php

namespace Modules\Custom\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\Sass\Repositories\CompanyRepository;
use Modules\User\Contracts\Authentication;
use Modules\User\Events\UserHasBegunResetProcess;
use Modules\User\Http\Controllers\Admin\BaseUserModuleController;
use Modules\User\Http\Requests\CreateUserRequest;
use Modules\User\Http\Requests\UpdateUserRequest;
use Modules\User\Permissions\PermissionManager;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Repositories\UserRepository;

class UserController extends BaseUserModuleController
{
    /**
     * @var UserRepository
     */
    private UserRepository $user;
    /**
     * @var RoleRepository
     */
    private RoleRepository $role;
    /**
     * @var Authentication
     */
    private Authentication $auth;

    private NotificationRepository $notification;

    private CompanyRepository $company;

    /**
     * @param PermissionManager $permissions
     * @param UserRepository $user
     * @param RoleRepository $role
     * @param Authentication $auth
     * @param NotificationRepository $notification
     * @param CompanyRepository $company
     */
    public function __construct(
        PermissionManager      $permissions,
        UserRepository         $user,
        RoleRepository         $role,
        Authentication         $auth,
        NotificationRepository $notification,
        CompanyRepository $company
    )
    {
        parent::__construct();

        $this->permissions =    $permissions;
        $this->user =           $user;
        $this->role =           $role;
        $this->auth =           $auth;
        $this->notification =   $notification;
        $this->company = $company;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $users = $this->user->all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $roles = $this->role->all();
        $companies=$this->company->all();
        return view('users.create', compact('roles','companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $data = $this->mergeRequestWithPermissions($request);

        $this->user->createWithRoles($data, $request->roles, true);

        return redirect()->route('user.user.index')
            ->withSuccess(trans('user::messages.user created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        if (!$user = $this->user->find($id)) {
            return redirect()->route('user.user.index')
                ->withError(trans('user::messages.user not found'));
        }
        $companies=$this->company->all();
        $roles = $this->role->all();
        $currentUser = $this->auth->user();
        return view('users.edit', compact('user', 'roles', 'currentUser','companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param UpdateUserRequest $request
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        $data = $this->mergeRequestWithPermissions($request);

        $this->user->updateAndSyncRoles($id, $data, $request->roles);

        return redirect()->route('user.user.index')
            ->withSuccess(trans('user::messages.user updated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->user->delete($id);

        return redirect()->route('user.user.index')
            ->withSuccess(trans('user::messages.user deleted'));
    }

    public function sendResetPassword($user, Authentication $auth)
    {
        $user = $this->user->find($user);
        $code = $auth->createReminderCode($user);

        event(new UserHasBegunResetProcess($user, $code));

        return redirect()->route('user.user.edit', $user->id)
            ->withSuccess(trans('user::auth.reset password email was sent'));
    }
}
