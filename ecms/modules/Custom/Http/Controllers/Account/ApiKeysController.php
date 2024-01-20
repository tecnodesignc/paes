<?php

namespace Modules\Custom\Http\Controllers\Account;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\User\Contracts\Authentication;
use Modules\User\Entities\UserToken;
use Modules\User\Repositories\UserTokenRepository;

class ApiKeysController extends AdminBaseController
{
    /**
     * @var Authentication
     */
    private $auth;
    /**
     * @var UserTokenRepository
     */
    private $userToken;

    public function __construct(Authentication $auth, UserTokenRepository $userToken)
    {
        parent::__construct();

        $this->auth = $auth;
        $this->userToken = $userToken;
    }

    public function index()
    {
        return view('module.user.account.api-keys.index');
    }

    public function create()
    {
        $this->userToken->generateFor($this->auth->id());

        return redirect()->route('account.api.index')
            ->withSuccess(trans('user::users.token generated'));
    }

    public function destroy(UserToken $userToken)
    {
        if ($this->userToken->allForUser($this->auth->id())->count() === 1) {
            return redirect()->route('account.api.index')
                ->withFail(trans('user::users.last token can not be deleted'));
        }

        $this->userToken->destroy($userToken);

        return redirect()->route('account.api.index')
            ->withSuccess(trans('user::users.token deleted'));
    }
}
