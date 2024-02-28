<?php

namespace modules\Maintenance\Services;

use Illuminate\Support\Facades\Http;
use Modules\User\Contracts\Authentication;

class PluxeeConnection
{

    protected string $url = 'https://login.ejesatelital.com/api';

    protected array $params;

    public function __construct()
    {
    }


    private function header()
    {

        return [
            "Content-Type" => "multipart/form-data",
            'X-header' => 'value'
        ];
    }

    public function params(array $array = []): void
    {


        $default_params = [
            'lang' => 'en',
            'user_api_hash' => $this->getToken()
        ];

        $this->params = array_merge($default_params, $array);
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        $auth = app(Authentication::class);

        return $auth->user()->apigpswox_token->user_api_hash;
    }

    /**
     * @return string
     */
    public function getUrl(string $uri): string
    {

        return $this->url . $uri;
    }

    public function get($uri)
    {
        try {
            $response = Http::withHeaders($this->header())->get($this->getUrl($uri), $this->params);

            $statusCode = $response->status();
            $responseBody = json_decode($response->getBody());
            if ($statusCode == 401 || $statusCode == 400) throw new \Exception($responseBody->message);
            return $responseBody;
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function postAuth(array $input, string $uri)
    {
        $response = Http::asMultipart()->post($this->getUrl($uri), $input);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody());
        return $responseBody;

    }

    public function post(array $input, string $uri)
    {
        try {

            $response = Http::asMultipart()->post($this->getUrl($uri) . '?' . http_build_query($this->params(), '', '&'), $input);
            $statusCode = $response->status();
            if ($statusCode == 401 || $statusCode == 400) throw new \Exception($response->getBody()->message);
            $responseBody = json_decode($response->getBody());
            return $responseBody;
        } catch (\Exception $e) {
            return $e;
        }

    }

}
