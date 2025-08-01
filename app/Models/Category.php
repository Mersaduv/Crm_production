<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{   
    use SoftDeletes;
    use HasFactory;

    protected $dates = [ 'deleted_at' ];
    
     protected $fillable = [
        'name'
    ];

    // Relation to packages
    public function packages()
    {
        return $this->hasMany(Package::class);
    }

}
