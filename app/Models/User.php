<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    protected $appends = ['status_name'];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->slug = Str::uuid()->toString();
        });
    }

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

    public function revokeRole()
    {
        $this->roles()->detach();
    }

    public function getUserRolesAttribute()
    {
        return $this->roles->map->name->flatten()->unique()->flatten();
    }
    
    public function unit()
    {
        return $this->belongsTo(Unit::class,'unitid','unitid');
    }

    protected function statusName(): Attribute
    {
       
        return Attribute::make(
            get:function () {
                    if($this->status==1)
                        return "ปกติ";
                    else if($this->status==2)
                        return "ยกเลิก";
                    else
                        return "status is invalid";
        });      

    }

    protected function roleName(): Attribute
    {
        return Attribute::make(
            get:function(){

            });
    }

    public static function loadData($fileName){
        //ใช้ครั้งแรกเมื่อติดตั้งระบบ เพื่อเพิ่ม user admin IT
        //  Log::info('loadData');
            $users = loadCSV($fileName);
            $profile = array();
            $profile['user_id_in'] = 0;
            $profile['user_name_in'] ='admin server';
            foreach($users as $user){
                Logger($user['sap_id']);
                Logger($user['unit_id']);
                $user = User::create([
                    'sap_id'=>$user['sap_id'],
                    'unitid' => $user['unit_id'],
                    'name' => $user['name'],
                    'status' => '1',
                    'profile'=> $profile
                ]);
    
               $user->assignRole('admin_it');
            }

        }
}
