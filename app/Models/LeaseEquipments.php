<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaseEquipments extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'tameshk_update.leased_equipments';

    protected $primaryKey = 'le_id';
}
