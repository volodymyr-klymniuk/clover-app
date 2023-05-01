<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    public const TABLE_NAME = 'user';

    /**
     * @var string[] The attributes that are mass assignable.
     */
    protected $fillable = [ 'name', 'email', ];

    /**
     * @var string[] The attributes excluded from the model's JSON form.
     */
    protected $hidden = [ 'password', ];

    /**
     * @var string The table associated with the model.
     */
    protected $table = self::TABLE_NAME;
}
