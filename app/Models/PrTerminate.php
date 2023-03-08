<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrTerminate extends Model
{
    use HasFactory;
    protected $table = 'pr_terminate_info';

    // Relation to Customer
    public function provincial()
    {
        return $this->belongsTo(Provincial::class, 'pr_cu_id', 'id');
    }

    public function recontract()
    {
        return $this->hasOne(PrRecontract::class, 'terminate_id', 'id');
    }

    // Relation to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relation to Commission
    public function commission()
    {
        return $this->belongsTo(Commission::class, 'commission_id', 'id');
    }

    // Relation to Marketer
    public function marketer()
    {
        return $this->belongsTo(Marketer::class, 'marketer_id', 'id');
    }

    // Relation to Package
    public function Package()
    {
        return $this->belongsTo(Package::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
