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
            if (isset($item->type) && isset($item->finding)){
                if ($item->finding){
                    $count++;
                }
            }
        }
        return $count;
   }

}
