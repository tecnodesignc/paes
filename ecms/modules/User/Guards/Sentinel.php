<?php

namespace Modules\User\Guards;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel as SentinelFacade;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard as LaravelGuard;
use Modules\User\Entities\UserInterface;

class Sentinel implements LaravelGuard
{
    /**
     * Determine if the current user is authenticated.
     * @return bool
     */
    public function check(): bool
    {
        if (SentinelFacade::check()) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the current user is a guest.
     * @return bool
     */
    public function guest(): bool
    {
        return SentinelFacade::guest();
    }

    /**
     * Get the currently authenticated user.
     * @return Authenticatable|null
     */
    public function user(): ?Authenticatable
    {
        return SentinelFacade::getUser();
    }

    /**
     * Get the ID for the currently authenticated user.
     * @return int|null
     */
    public function id(): ?int
    {
        if ($user = SentinelFacade::check()) {
            return $user->id;
        }

        return null;
    }

    /**
     * Validate a user's credentials.
     * @param  array $credentials
     * @return bool
     */
    public function validate(array $credentials = []): bool
    {
        return SentinelFacade::validForCreation($credentials);
    }

    /**
     * Set the current user.
     * @param Authenticatable $user
     * @return bool
     */
    public function setUser(Authenticatable $user): bool
    {
        return SentinelFacade::login($user);
    }

    /**
     * Alias to set the current user.
     * @param Authenticatable $user
     * @return bool
     */
    public function login(Authenticatable $user): bool
    {
        return $this->setUser($user);
    }

    /**
     * @param array $credentials
     * @param bool $remember
     * @return  bool|UserInterface
     */
    public function attempt(array $credentials, bool $remember = false):  bool|UserInterface
    {
        return SentinelFacade::authenticate($credentials, $remember);
    }

    /**
     * @return bool
     */
    public function logout(): bool
    {
        return SentinelFacade::logout();
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function loginUsingId($userId): bool
    {
        $user = app(\Modules\User\Repositories\UserRepository::class)->find($userId);

        return $this->login($user);
    }

    public function hasUser(): bool
    {
        return SentinelFacade::hasUser();
    }
}
