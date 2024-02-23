<?php

namespace Modules\Dynamicform\Presenters;

use Laracasts\Presenter\Presenter;


class FormResponsePresenter extends Presenter
{

    public function __construct($entity)
    {
        parent::__construct($entity);
    }

   public function negative_num(){
        $count=0;
        $answers=$this->entity->data->answers;
        foreach ($answers as $item){
            $type = intval($item->type);
            if (isset($item->type) && $type===5){
                if ($item->value == 0){
                    $count++;
                }
            }
        }
        return $count;
   }

}
