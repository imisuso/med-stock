<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sap_id',
        'unitid',
        'name',
        'status',
        'profile'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'line_verified_at' => 'datetime',
        'profile' => 'array',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function assignRole($role)
    {
        if(is_string($role)){
            $role = Role::whereName($role)->firstOrCreate(['name'=>$role]);
        }

        $this->roles()->syncWithoutDetaching($role); // เช็คซ้ำให้  sync โดยไม่ตัดของเดิมออก
    }
    
    public function getAbilitiesAttribute()
    {
        return $this->roles->map->abilities->flatten()->pluck('name')->unique()->flatten();
    }
    
    public function unit()
    {
        return $this->belongsTo(Unit::class,'unitid','unitid');
    }
}
