<?php

namespace Modules\Dynamicform\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Field extends Model
{
    protected $table = 'dynamicform__fields';
    protected $fillable = ['label','name','type','required','order','selectable','form_id','company_id', 'finding'];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'selectable' => 'array',
    ];

    /**
     * @return BelongsTo
     */
    public function form():BelongsTo
    {
        return  $this->belongsTo(Form::class);
    }

}
