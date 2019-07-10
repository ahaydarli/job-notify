<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    const ADMIN_ROLE = 'ADMIN_USER';
    const BASIC_ROLE = 'BASIC_USER';
    const IS_COMPANY = 1;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid',
        'name',
        'email',
        'password',
        'activation_code',
        'persist_code',
        'reset_password_code',
        'permissions',
        'gender',
        'date_of_birth',
        'education',
        'experience',
        'is_activated',
        'activated_at',
        'last_login',
        'created_at',
        'updated_at',
        'username',
        'surname',
        'deleted_at',
        'last_seen',
        'is_guest',
        'is_superuser',
        'phone',
        'is_company',
        'tax_id',
        'role',
        'facebook',
        'linkedin',
        'twitter',
        'instagram',
        'salary_min',
        'profileImage',
        'user_agreement',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function category()
    {
        return $this->belongsToMany(Category::class, 'user_category')->withPivot('user_id', 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsToMany(Category::class, 'user_sub_category')->withPivot('user_id', 'category_id');
    }

    public function country()
    {
        return $this->belongsToMany(Country::class, 'user_country')->withPivot('user_id', 'country_id');
    }

    public function city()
    {
        return $this->belongsToMany(City::class, 'user_city')->withPivot('user_id', 'city_id');
    }
}
