<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function schools()
    {
        return $this->hasMany(\App\Models\School::class);
    }

    public function user()
    {
        return $this->hasMany(\App\Models\User::class);
    }
}
