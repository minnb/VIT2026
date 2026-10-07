<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /** Toan quyen khu quan tri. */
    const ROLE_ADMIN = 'admin';

    /** Chi duoc dang nhap, khong vao khu quan tri. */
    const ROLE_EDITOR = 'editor';

    /**
     * Tai khoan co quyen vao khu quan tri hay khong.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        if (! array_key_exists('role', $this->getAttributes())) {
            return true;
        }

        return $this->role === self::ROLE_ADMIN || (int) $this->role === 1;
    }
}