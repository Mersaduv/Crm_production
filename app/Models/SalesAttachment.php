<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesAttachment extends Model
{
    use HasFactory;
    protected $table = 'sales_attachement';

    // Relation to Sales
    public function Sale()
    {
        return $this->belongsTo(Sale::class,'sales_id', 'id');
    }
}
