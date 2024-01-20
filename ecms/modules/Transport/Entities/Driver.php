<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Sass\Entities\Company;
use Modules\User\Entities\Sentinel\User;

class Driver extends Model
{

    protected $table = 'transport__drivers';
    protected $fillable = ['driver_license','phone','user_id','address','company_id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'address' => 'array',
    ];
    /**
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return  $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function company():BelongsTo
    {
        return  $this->belongsTo(Company::class,);
    }
    /**
     * @return BelongsToMany
     */
    public function vehicles():BelongsToMany
    {
        return  $this->belongsToMany(Vehicles::class,'transport__driver_vehicle');
    }
    /**
     * Get all the driver's documents.
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    protected function address(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => json_decode($value),
        )->shouldCache();
    }

}
