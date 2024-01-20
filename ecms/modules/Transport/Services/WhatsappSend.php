<?php

namespace Modules\Transport\Services;
use Illuminate\Support\Facades\Http;

class WhatsappSend
{

    public function sendMessage($data)
    {
        try {

            $response = Http::withBody('{ "messaging_product": "whatsapp","recipient_type": "individual", "to": "'.$data["receiver"].'", "type": "template", "template": { "name": "'.$data["template"].'", "language": { "code": "es_MX" }, "components": [{"type": "body","parameters": [ { "type": "text", "text": "'.$data["message"].'"}]}]} }','application/json')
                ->withToken($data["token"])
                ->post('https://graph.facebook.com/'.$data["version"].'/'.$data["sender"].'/messages');
            $statusCode = $response->status();
            if ($statusCode == 401 || $statusCode == 400) throw new \Exception($response);
            $responseBody = json_decode($response->getBody());
            return $responseBody;
        } catch (\Exception $e) {
            \Log::error($e);
            return $e;
        }

    }

}
