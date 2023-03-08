<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleEquipments extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'tameshk_update.equipment_sales';

    protected $primaryKey = 'sa_id';
}
