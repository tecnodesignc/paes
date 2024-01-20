<?php

namespace modules\Custom\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Controlt\Services\AuthService;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Custom\Http\Middleware\SendMessageRequest;
use Modules\Transport\Services\SendSMSCode;

class PublicController extends BasePublicController
{


    public function __construct(Application $app)
    {
        parent::__construct();

        $this->app = $app;
    }


    /**
     * @return View
     */
    public function send(SendMessageRequest $request): View
    {

        $phone= $request->input('phone');
        $message =$request->input('message');

        $sendCode = new SendSMSCode('+'.$phone, '000');
       dd($sendCode->sendCustomMessage($message));

    }



}
