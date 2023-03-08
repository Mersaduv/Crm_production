<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permission');
    }

    /**
     * Get the premission section name.
     *
     * @param  string  $value
     * @return string
     */
    public function getSectionAttribute($value)
    {
        return Str::headline($value);
    }

    /**
     * Get the premission  name.
     *
     * @param  string  $value
     * @return string
     */
    public function getPermissionAttribute($value)
    {
        return Str::headline($value);
    }
}
