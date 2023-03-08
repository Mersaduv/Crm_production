<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrPayment extends Model
{
    use HasFactory;
    protected $table = 'pr_payments';  
    protected $guarded = [];

    // Relation to Customer Info
    public function provincial()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    } 
}
