<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory;
    use SoftDeletes; 
    protected $guarded = [];
    protected $table = 'branches';  
    protected $dates = ['deleted_at'];

    public function customers()
    {
        return $this->hasOne(Customer::class, 'branch_id', 'id');
    }

    public function suspend()
    {
        return $this->hasOne(Suspend::class, 'branch_id', 'id');
    }

    public function prsuspend()
    {
        return $this->hasOne(PrSuspend::class, 'branch_id', 'id');
    }

    public function terminate()
    {
        return $this->hasOne(Terminate::class, 'branch_id', 'id');
    }

    public function PrTerminate()
    {
        return $this->hasOne(PrTerminate::class, 'branch_id', 'id');
    }

    public function reactivate()
    {
        return $this->hasOne(Reactivate::class, 'branch_id', 'id');
    }

    public function PrReactivate()
    {
        return $this->hasOne(PrReactivate::class, 'branch_id','id');
    }

    public function recontract()
    {
        return $this->hasOne(Recontract::class, 'branch_id', 'id');
    }

    public function PrRecontract()
    {
        return $this->hasOne(PrRecontract::class, 'branch_id', 'id');
    }

    public function provincials()
    {
        return $this->hasOne(Provincial::class, 'branch_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class,'province_id','id');
    }
}
