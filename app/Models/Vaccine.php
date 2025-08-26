<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    protected $fillable = [
        'name',
        'description',
        'doses',
        'batch_number',
        'manufacturer',
        'expiry_date',
    ];
}
