<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laracasts\Presenter\PresentableTrait;
use Modules\Maintenance\Entities\Event;
use Modules\Transport\Presenters\DocumentPresenter;

class Document extends Model
{
    use PresentableTrait;
    protected $table = 'transport__documents';
    protected $fillable = ['name','extension','route','expiration_date','amount','alert','documentable_id','documentable_type'];

    protected string $presenter = DocumentPresenter::class;

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }



}
