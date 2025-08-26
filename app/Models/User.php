<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'lastname',
        'firstname',
        'middlename',
        'suffix',
        'position',
        'email',
        'password',
        'municipality_id',
        'position'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->firstname)
            ->explode(' ')
            ->take(1)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->lastname}, {$this->firstname} " . ($this->middlename ? "{$this->middlename} " : '') . ($this->suffix ? "{$this->suffix}" : '');
    }
    public function isAdmin(): bool
    {
        return $this->position === 'Admin';
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }
}
