<?php

namespace Modules\Apigpswox\Services;


use Modules\Apigpswox\Repositories\TokenRepository;
use Modules\User\Repositories\UserRepository;

class AuthService extends Connection
{

    /**
     * @var UserRepository
     */
    private UserRepository $user;

    private TokenRepository $token;

    public function __construct(UserRepository $user, TokenRepository $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function auth($credentials)
    {

        $auth = $this->postAuth($credentials, '/login');
        $user = $auth;
        if ($auth->status) {
            $user = $this->user->getItem($credentials['email'], json_decode(json_encode(['filter' => ['field' => 'email']])));
            if (empty($user)) {
                $user = $this->user->create($credentials, true);
            }
            if (!isset($user->apigpswox_token->user_api_hash)||$user->apigpswox_token->user_api_hash !==$auth->user_api_hash)
                $this->token->create(['user_id'=>$user->id,'user_api_hash'=>$auth->user_api_hash]);
        }
        return $user;

    }
    public function setToken($credentials)
    {
        $auth = $this->postAuth($credentials, '/login');
        return $auth;

    }

}
