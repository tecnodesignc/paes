<?php

namespace Modules\Sass\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Support\Facades\Crypt;
use Laracasts\Presenter\PresentableTrait;
use Modules\Dynamicform\Entities\FormResponse;
use Modules\Sass\Presenters\CompanyPresenter;
use Modules\Transport\Entities\Driver;
use Modules\Transport\Entities\Vehicles;
use Modules\User\Entities\Sentinel\User;


class Company extends Model
{

    use PresentableTrait;

    protected $table = 'sass__companies';
    protected $fillable = ['logo','name','nit','address','email','identification','phone','website','type','token','settings'];



    protected $presenter = CompanyPresenter::class;


    public function drivers():hasMany {
        return $this->hasMany(Driver::class);
    }
    public function forms():hasMany {
        return $this->hasMany(FormResponse::class);
    }
    public function vehicles():hasMany {
        return $this->hasMany(Vehicles::class);
    }

    public function users():belongsToMany
    {
    return $this->belongsToMany(User::class,'sass__user_company');
    }

    protected function settings(): Attribute
    {
       return Attribute::make(
            get: fn($value)=>json_decode(Crypt::decryptString($value)),
            set: fn($value)=>  Crypt::encryptString(json_encode($value)),
        );
    }


}
