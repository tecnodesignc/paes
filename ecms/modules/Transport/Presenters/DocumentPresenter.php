<?php

namespace Modules\Transport\Presenters;

use Carbon\Carbon;
use Laracasts\Presenter\Presenter;

class DocumentPresenter extends Presenter
{

    public function __construct($entity)
    {
        parent::__construct($entity);
    }

    public function classAlert():string
    {
        $expiration_date= new Carbon($this->entity->expiration_date);
        $now= Carbon::now();
        if ($expiration_date->diffInDays($now)<=15 && $expiration_date->diffInDays($now)>0){
            return 'warning';
        }elseif ($expiration_date->diffInDays($now)<0){
            return 'danger';
        }else{
            return 'success';
        }
    }
    public function statusAlert():string
    {
        $expiration_date= new Carbon($this->entity->expiration_date);
        $now= Carbon::now();
        if ($expiration_date->diffInDays($now)<=15 && $expiration_date->diffInDays($now)>0){
            return 'Vencimiento Cercano ';
        }elseif ($expiration_date->diffInDays($now)<0){
            return 'Vencido';
        }else{
            return 'Alerta Activa';
        }
    }

}
