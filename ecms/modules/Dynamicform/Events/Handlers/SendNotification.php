<?php

namespace Modules\Dynamicform\Events\Handlers;

use Modules\Notification\Services\Notification;

class SendNotification
{
    /**
     * @var Notification
     */
    private Notification $notification;


    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function handle($event)
    {
        $formresponse=$event->getEntity();
        $formresponse_negative = $formresponse->present()->negative_num();
        // validamos si hay respuestas negativas
        if($formresponse_negative>=1)
        {
            // a quien le voy a enviar la notificación (cuales)
            $users = $formresponse->company->users;
            //recorremos los usuarios
            foreach ($users as $user) {
                // Enviar la notificacion
                $this->notification->to($user->id)->push('Formulario con hallazgo',
                "Se ha registrado una respuesta al formulario ".$formresponse->form->name." con ". $formresponse_negative. " hallazgos negativos.",
                '<i class="mdi mdi-file-alert-outline"></i>',
                route('dynamicform.formresponses.show', [$formresponse->form_id, $formresponse->id]));
            }
        }
    }


}
