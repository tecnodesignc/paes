<?php

namespace Modules\Maintenance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Sass\Entities\Company;
use Modules\Transport\Entities\Vehicles;

class Fueltank extends Model
{
    protected $table = 'maintenance__fueltanks';
    protected $fillable = ['fuel_date','quantity','type','value','vehicle_id','company_id'];

    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    /**
     * @return BelongsTo
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicles::class);
    }


}
