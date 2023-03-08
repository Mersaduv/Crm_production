<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = [ 'deleted_at' ];
    protected $fillable = [
        'name',
        'price',
        'duration',
        'category_id'
    ];

    // Relation to category
    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relation to Terminates
    public function terminates()
    {
        return $this->hasMany(Terminate::class);
    }

    // Relation to Terminates
    public function recontracts()
    {
        return $this->hasMany(Recontract::class);
    }

    // Relation to Suspends
    public function suspends()
    {
        return $this->hasMany(Suspend::class);
    }

    // Relation to reactivates
    public function reactivates()
    {
        return $this->hasMany(Reactivate::class);
    }

    // Relation to prreactivate
    public function prreactivate()
    {
        return $this->hasMany(PrReactivate::class);
    }

    // Relation to Sales
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // Relation to Sales
    public function amends()
    {
        return $this->hasMany(Amend::class);
    }

    // Relation to Sales
    public function cancelAmends()
    {
        return $this->hasMany(CancelAmend::class);
    }

    // Relation to Provincal customers
    public function provincials()
    {
        return $this->hasMany(Provincial::class);
    }

    public function prSuspends()
    {
        return $this->hasMany(PrSuspend::class);
    }

    public function prTerminates()
    {
        return $this->hasMany(PrTerminate::class);
    }

    public function prAmends()
    {
        return $this->hasMany(PrAmend::class);
    }

    public function prCancelAmends()
    {
        return $this->hasMany(PrCancelAmend::class);
    }

    // Relation to Cancel
    public function cancels()
    {
        return $this->hasMany(Cancel::class);
    }

    public function prCancels()
    {
        return $this->hasMany(PrCancel::class);
    }

    public function PrRecontract()
    {
        return $this->hasMany(PrRecontract::class);
    }
}
