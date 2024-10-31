<?php

namespace Modules\User\Models;

use Core\Constant;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model;

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
        'count_send_mail',
        'time_send_mail',
        'token_send_mail',
        'active',
        'created_time',
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
        'count_send_mail' => 0,
        'time_send_mail' => 0,
        'token_send_mail' => '',
        'active' => 0,
        'created_time' => 0,
        'created_at' => '',
        'updated_at' => '',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
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
