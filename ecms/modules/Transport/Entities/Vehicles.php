<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Maintenance\Entities\Event;
use Modules\Maintenance\Entities\Fueltank;
use Modules\Maintenance\Entities\Tire;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Sass\Entities\Company;

class Vehicles extends Model
{
    use  MediaRelation;

    protected $table = 'transport__vehicles';
    protected $fillable = ['brand', 'plate', 'model', 'class',  'capacity', 'millage', 'device_id', 'device', 'company_id', 'type', 'reference', 'property_card', 'displacement', 'color', 'box_type', 'transmission_type', 'shielding', 'doors', 'serial_number', 'chassis_number', 'engine_number', 'accessories', 'axles','fixed_asset_num','transfers','cda_route_municipality','fines'
    ];

    protected $casts = [
        'device' => 'array',
        'axles' => 'array'
    ];

    /**
     * Get all the vehicle's documents.
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    /**
     * Get all the vehicle's events.
     */
    public function events()
    {
        return $this->morphMany(Event::class, 'eventable');
    }

    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }


    public function drivers(): belongsToMany
    {
        return $this->belongsToMany(Driver::class, 'transport__driver_vehicle');
    }

    public function fuelTanks(): HasMany
    {
        return $this->hasMany(Fueltank::class);
    }

    public function tires(): HasMany
    {
        return $this->hasMany(Tire::class);
    }
    protected function device(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => json_decode($value),
        )->shouldCache();
    }


    /* protected function axles(): Attribute
     {
         return Attribute::make(
             get: fn(string $value) => json_decode($value),
         )->shouldCache();
     }*/
    /**
     * @return mixed
     */
    public function getMainImageAttribute(): mixed
    {
        $thumbnail = $this->files()->where('zone', 'mainimage')->first();
        if (!$thumbnail) {
            $image = [
                'mimeType' => 'image/jpeg',
                'path' => null
            ];
        } else {
            $image = [
                'mimeType' => $thumbnail->mimetype,
                'path' => $thumbnail->path_string
            ];
        }
        return json_decode(json_encode($image));

    }

}
