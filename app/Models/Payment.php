<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $guarded = [];

    // Relation to Customer Info
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
