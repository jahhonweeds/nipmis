<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'municipality_id',
    ];

    public function municipality()
    {
        return $this->belongsTo(\App\Models\Municipality::class);
    }
}