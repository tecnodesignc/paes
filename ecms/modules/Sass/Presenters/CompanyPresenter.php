<?php

namespace modules\Sass\Presenters;

use Laracasts\Presenter\Presenter;

class CompanyPresenter extends Presenter
{
    /**
     * Return the gravatar link for the users email
     * @param  int $size
     * @return string
     */
    public function gravatar($size = 90)
    {

        if (!isset($this->entity->logo) || empty($this->entity->logo)) {
            $email = md5($this->entity->email);
            $image="https://www.gravatar.com/avatar/$email?s=$size";
        } else {
            $image=$this->entity->logo;
        }
        return $image;
    }
}
