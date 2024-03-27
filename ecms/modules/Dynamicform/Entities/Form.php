<?php

namespace Modules\Dynamicform\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Sass\Entities\Company;

class Form extends Model
{

    protected $table = 'dynamicform__forms';
    protected $fillable = ['name','caption','icon','color','options','active', 'company_create'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
    ];

    /**
     * @return hasMany
     */
    public function fields():hasMany
    {
        return  $this->hasMany(Field::class);
    }
    public function companies():belongsToMany
    {
        return $this->belongsToMany(Company::class,'dynamicform__form_company');
    }

}
