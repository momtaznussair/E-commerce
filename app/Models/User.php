<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Traits\Scopes\IsTrashed;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Scopes\ActiveScope;
use App\Traits\Scopes\CountryScope;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Authenticatable implements CanResetPasswordContract
{
    use HasApiTokens, HasFactory, Notifiable, IsTrashed, ActiveScope, 
    SoftDeletes, CountryScope, SoftCascadeTrait, CanResetPassword;

    public static  function filters() {
        return ['isActive', 'isTrashed', 'Search', 'country'];
    }

    /**
   * Users' gender
   * 
   * @var array
   */
   public const Genders = [
    0     => 'Male',
    1    => 'Female'
 ];
   
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'avatar',
        'password',
        'active',
        'gender',
        'phone',
        'dob',
        'city_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The relations that should be soft deleted when this gets soft deleted.
     *
     * @var array
     */
    protected $softCascade = [];

    public function City() {
       return $this->belongsTo(City::class);
    }
    
    protected $appends = ['name'];
    
    public function getAvatarPathAttribute() {
        return !is_null($this->avatar) ? asset('storage/' . $this->avatar) : asset('storage/users/default.jpg');
    }

    public function getGenderTypeAttribute() {
        return Self::Genders[$this->gender];
    }

    public function getNameAttribute() {
        return Str::ucfirst($this->first_name) . ' ' . Str::ucfirst($this->last_name);
    }
}
