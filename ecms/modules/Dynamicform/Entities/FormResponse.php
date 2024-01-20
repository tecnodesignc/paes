<?php

namespace Modules\Dynamicform\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;
use Laracasts\Presenter\PresentableTrait;
use Modules\Dynamicform\Presenters\FormResponsePresenter;
use Modules\Sass\Entities\Company;
use Modules\User\Entities\Sentinel\User;

class FormResponse extends Model
{
    use PresentableTrait;

    protected $table = 'dynamicform__formresponses';
    protected $fillable = ['form_id', 'user_id', 'company_id','data'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    protected string $presenter = FormResponsePresenter::class;

    /**
     * @return BelongsTo
     */
    public function form():BelongsTo
    {
        return  $this->belongsTo(Form::class);
    }
    /**
     * @return BelongsTo
     */
    public function company():BelongsTo
    {
        return  $this->belongsTo(Company::class);
    }
    /**
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return  $this->belongsTo(User::class);
    }

    protected function data(): Attribute
    {
        return Attribute::make(
            get: fn($value)=>json_decode($value),
        );
    }

}
