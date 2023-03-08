<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrTerminateRequest extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pr_requests';
    protected $dates = ['deleted_at'];

    // Relation to Customer Info
    public function customer()
    {
        return $this->belongsTo(Provincial::class, 'customer_id');
    }

    // Relation to User Info
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
