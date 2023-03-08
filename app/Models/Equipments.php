<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipments extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'tameshk_update.equipments';

    protected $primaryKey = 'eq_id';
}
