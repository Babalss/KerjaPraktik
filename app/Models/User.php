<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // gunakan Authenticatable agar bisa login
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'password_changed_at',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'password_changed_at' => 'datetime',
    ];


    // Relasi ke Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    // Relasi ke PasswordReset
    public function passwordResets()
    {
        return $this->hasMany(PasswordReset::class);
    }
}
