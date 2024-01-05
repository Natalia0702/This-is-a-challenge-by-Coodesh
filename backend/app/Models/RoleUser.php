<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUser extends Pivot
{
    protected $table = 'role_user';

    protected $fillable = [
        'user_id',
        'role_id',
    ];

    // ManyToMany with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ManyToMany with Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
