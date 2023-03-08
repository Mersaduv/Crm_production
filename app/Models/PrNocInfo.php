<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrNocInfo extends Model
{
    use HasFactory;
    protected $table = 'pr_noc_info';  
    protected $guarded = [];

    // Relation to Customer
    public function provincial()
    {
        return $this->belongsTo(Provincial::class,'customer_id','id');
    }

    // Relation to user
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
