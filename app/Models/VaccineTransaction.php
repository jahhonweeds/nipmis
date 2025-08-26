<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VaccineTransaction extends Model
{

    protected $fillable = [
        'vaccine_id',
        'municipality_id',
        'date_expiry',
        'quantity',
        'batch_number',
    ];

    public function vaccine()
    {
        return $this->belongsTo(\App\Models\Vaccine::class);
    }
    public function municipality()
    {
        return $this->belongsTo(\App\Models\Municipality::class);
    }

    public function getNameAttribute()
    {
        return $this->vaccine->name ?? 'Unknown Vaccine';
    }
}
