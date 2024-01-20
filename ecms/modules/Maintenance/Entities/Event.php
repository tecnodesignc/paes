<?php

namespace Modules\Maintenance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;
use Modules\Maintenance\Presenters\EventPresenter;
use Modules\Sass\Entities\Company;

class Event extends Model
{
    use PresentableTrait;

    protected $table = 'maintenance__events';
    protected $fillable = ['type', 'description', 'alert', 'alert_active', 'status', 'limits', 'form_verify', 'eventable_id', 'eventable_type', 'company_id'];

    protected $casts = [
        'form_verify' => 'array'
    ];


    protected string $presenter = EventPresenter::class;

    /**
     * Get the parent eventable model.
     */
    public function eventable()
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function company():BelongsTo
    {
        return  $this->belongsTo(Company::class,);
    }

}
