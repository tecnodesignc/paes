<?php

namespace Modules\Transport\Services;

class SendSMSCode
{

    public $phone;

    public $code;

    public function __construct($phone, $code)
    {
        $this->phone = $phone;
        $this->code = $code;
    }

    public function sendMessage()
    {
        try {
            $sms = \AWS::createClient('sns');
            $message='Bienvenino al Sistema de Control de Pasajeros de Eje Satelital Su codigo de Verificación es: '.$this->code;
            $sms->publish([
                'Message' => $message,
                'PhoneNumber' => $this->phone,
                'MessageAttributes' => [
                    'AWS.SNS.SMS.SMSType'  => [
                        'DataType'    => 'String',
                        'StringValue' => 'Transactional',
                    ]
                ],
            ]);
        }catch (AwsException $e){
            \Log::error($e->getMessage());
        }

    }
    public function sendCustomMessage($message)
    {
        try {
            $sms = \AWS::createClient('sns');
          $result=$sms->publish([
                'Message' => html_entity_decode($message),
                'PhoneNumber' => $this->phone,
            ]);
            dd($result);
            return 'message Send to: '. $this->phone;
        }catch (AwsException $e){
            \Log::error($e->getMessage());
        }

    }
}
