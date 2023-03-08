<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrNocAttachments extends Model
{
    use HasFactory;

    protected $table = 'pr_noc_attachments';

    // Relation to Sales
    public function provincial()
    {
        return $this->belongsTo(Provincial::class,'customer_id','id');
    }

}
