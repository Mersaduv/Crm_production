<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NocAttachment extends Model
{
    use HasFactory;

    protected $table = 'noc_attachement';

    // Relation to Sales
    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
}
