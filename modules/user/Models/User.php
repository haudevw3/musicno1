<?php

namespace Modules\User\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model;
use Modules\User\Constant;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, Notifiable;

    /**
     * Assign different a connection if any.
     *
     * @var string
     */
    protected $connection = 'musicno1';

    /**
     * The collection name in Mongo DB.
     *
     * @var string
     */
    protected $collection = 'users';

    /**
     * The attribute will disabled.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Assign fields to save in the database.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        '_id',
        'id',
        'ip',
        'name',
        'username',
        'email',
        'roles',
        'password',
        'image',
        'remember_token',
        'count', // Number of email send attempts
        'token',
        'token_expires_at',
        'verified', // verified account
        'created_at',
        'updated_at',
    ];

    /**
     * Define default values for the model's attributes.
     *
     * @var array<string|int, string|null>
     */
    protected $attributes = [
        'id' => '',
        'ip' => '',
        'name' => '',
        'username' => '',
        'email' => '',
        'roles' => [],
        'password' => '',
        'image' => '',
        'remember_token' => '',
        'count' => 0,
        'token' => '',
        'token_expires_at' => '',
        'verified' => 0,
        'created_at' => '',
        'updated_at' => '',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return in_array(Constant::ADMIN_ROLE, $this->roles);
    }

    /**
     * @return bool
     */
    public function isMember()
    {
        return in_array(Constant::MEMBER_ROLE, $this->roles);
    }
}
