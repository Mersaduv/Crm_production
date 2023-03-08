<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'provinces';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function branches()
    {
        return $this->hasMany(Branch::class, 'province_id', 'id');
    }
}
