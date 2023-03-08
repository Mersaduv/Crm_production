<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestTerminate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'requests';
    protected $dates = ['deleted_at'];

    // Relation to Customer Info
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relation to User Info
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
