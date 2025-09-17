<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_seen' => 'datetime', // optional jika pakai last_seen untuk status
        ];
    }

    // Relasi ke role (jika masih pakai role_id manual)
    public function roleRelasi()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Relasi ke berita
    public function news()
    {
        return $this->hasMany(News::class, 'user_id');
    }

    public function isOnline()
    {
        if (!$this->last_seen)
            return false;
        return $this->last_seen->diffInMinutes(Carbon::now()) < 5;
    }
}
