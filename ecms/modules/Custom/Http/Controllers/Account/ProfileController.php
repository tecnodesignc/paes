<?php

namespace Modules\Custom\Http\Controllers\Account;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\User\Contracts\Authentication;
use Modules\User\Http\Requests\UpdateProfileRequest;
use Modules\User\Repositories\UserRepository;
use Modules\User\Repositories\UserTokenRepository;

class ProfileController extends AdminBaseController
{
    /**
     * @var UserRepository
     */
    private UserRepository $user;

    /**
     * @var Authentication
     */
    private Authentication $auth;

    /**
     * @var UserTokenRepository
     */
    private UserTokenRepository $userToken;

    /**
     * @var NotificationRepository
     */
    private NotificationRepository $notification;

    public function __construct(UserRepository $user, Authentication $auth, UserTokenRepository $userToken,  NotificationRepository $notification)
    {
        parent::__construct();
        $this->user = $user;
        $this->auth = $auth;
        $this->userToken = $userToken;
        $this->notification =   $notification;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Application|Factory|View
     */
    public function edit(): View|Factory|Application
    {
        $user=$this->auth->user();
        $tokens = $this->userToken->allForUser($user->id);
        $notifications = $this->notification->latestForUser($user->id);
        return view('modules.user.public.account.profile.show',compact('user', 'tokens', 'notifications'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param  UpdateProfileRequest $request
     *
     * @return Response
     */
    public function update(Request $request)
    {
        $user = $this->auth->user();

        $this->user->update($user, $request->all());

        return redirect()->back()
            ->withSuccess(trans('user::messages.profile updated'));
    }
}
