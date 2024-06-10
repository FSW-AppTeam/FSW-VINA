<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property int $role_id
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $solis_id
 * @property string|null $allowed_attributes
 * @property Role $role
 */
class User extends Authenticatable
{
    protected $table = 'users';

    protected $casts = [
        'role_id' => 'int',
        'email_verified_at' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'role_id',
        'email',
        'email_verified_at',
        'solis_id',
        'allowed_attributes',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role_id === Role::ADMINISTRATOR;
    }
}
