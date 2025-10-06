<?php

namespace Netizens\RB\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserHasRole extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'user_has_roles';

    protected $fillable = [
        'user_id',
        'role_id',
        'role_name',
    ];

    protected static function newFactory()
    {
        return \Netizens\RB\Database\Factories\UserHasRoleFactory::new();
    }
}
