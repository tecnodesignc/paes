<?php

namespace modules\Sass\Http\Controllers;

use http\Env\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Sass\Repositories\CompanyRepository;
use Modules\User\Exceptions\InvalidOrExpiredResetCode;
use Modules\User\Exceptions\UserNotFoundException;
use Modules\User\Http\Requests\RegisterRequest;
use Modules\User\Http\Requests\ResetCompleteRequest;
use Modules\User\Http\Requests\ResetRequest;
use Modules\User\Repositories\UserRepository;
use Modules\User\Services\UserResetter;

class AuthController extends BasePublicController
{
    use DispatchesJobs;

    /**
     * @var UserRepository
     */
    private $user;

    protected CompanyRepository $company;

    public function __construct(UserRepository $user,CompanyRepository $company)
    {
        parent::__construct();
        $this->user = $user;
        $this->company=$company;

    }

    public function getRegister($token_company)
    {
        return view('modules.sass.drivers.register');
    }

    public function postRegister(RegisterRequest $request)
    {
        $data=$request->all();
        $company= $this->company->findByAttributes(['token'=>$data['token']]);

        $data['company_id']=$company->id;
        $data['password']=$request->input('password');
        $data['roles']=[4];
        $data['is_activated']=0;
        $this->driver->create($data);

        return redirect()->route('saas.register')
            ->withSuccess(trans('user::messages.account created check email for activation'));
    }

    public function getLogout()
    {
        $this->auth->logout();

        return redirect()->route('login');
    }

    public function getActivate($userId, $code)
    {
        if ($this->auth->activate($userId, $code)) {
            return redirect()->route('login')
                ->withSuccess(trans('user::messages.account activated you can now login'));
        }

        return redirect()->route('register')
            ->withError(trans('user::messages.there was an error with the activation'));
    }

    public function getReset()
    {
        return view('user::public.reset.begin');
    }

    public function postReset(ResetRequest $request)
    {
        try {
            app(UserResetter::class)->startReset($request->all());
        } catch (UserNotFoundException $e) {
            return redirect()->back()->withInput()
                ->withError(trans('user::messages.no user found'));
        }

        return redirect()->route('reset')
            ->withSuccess(trans('user::messages.check email to reset password'));
    }

    public function getResetComplete()
    {
        return view('user::public.reset.complete');
    }

    public function postResetComplete($userId, $code, ResetCompleteRequest $request)
    {
        try {
            app(UserResetter::class)->finishReset(
                array_merge($request->all(), ['userId' => $userId, 'code' => $code])
            );
        } catch (UserNotFoundException $e) {
            return redirect()->back()->withInput()
                ->withError(trans('user::messages.user no longer exists'));
        } catch (InvalidOrExpiredResetCode $e) {
            return redirect()->back()->withInput()
                ->withError(trans('user::messages.invalid reset code'));
        }

        return redirect()->route('login')
            ->withSuccess(trans('user::messages.password reset'));
    }
}
