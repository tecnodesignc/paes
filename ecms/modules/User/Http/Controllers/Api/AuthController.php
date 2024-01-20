<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\User\Contracts\Authentication;
use Modules\User\Events\UserLoggedIn;
use Modules\User\Exceptions\InvalidOrExpiredResetCode;
use Modules\User\Exceptions\UserNotFoundException;
use Modules\User\Http\Requests\LoginRequest;
use Modules\User\Http\Requests\RegisterRequest;
use Modules\User\Http\Requests\ResetCompleteRequest;
use Modules\User\Http\Requests\ResetRequest;
use Modules\User\Services\UserRegistration;
use Modules\User\Services\UserResetter;
use Modules\User\Transformers\UserLoginTransformer;
use Modules\Notification\Services\Notification;

class AuthController extends Controller
{
    use DispatchesJobs;

    protected $auth;
    protected Notification $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
        $this->auth = app(Authentication::class);
    }

    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $remember = (bool)$request->get('remember_me', false);

        $error = $this->auth->login($credentials, $remember);
        if ($error) throw new \Exception($error, 400);

        $user = $this->auth->user();
        event(new UserLoggedIn($user));

        $this->notification->to($user->id)->push('Nuevo Inicio de Sesión', 'El sistema a detectado que se a iniciado sesión en su cuenta en una nueva dirección IP ', 'info', 'account');

        return new UserLoginTransformer($user->load('roles'));
    }


    public function register(RegisterRequest $request)
    {
        app(UserRegistration::class)->register($request->all());

        return response()->json([
            'message' => trans('user::messages.account created check email for activation'),
        ]);

    }

    public function logout()
    {
        $this->auth->logout();

        return response()->json([
            'message' => trans('user::messages.account.logout'),
        ]);
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
