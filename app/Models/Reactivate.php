<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reactivate extends Model
{
    use HasFactory;

    protected $table = 'customers_reactivate_info';

    // Relation to Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cu_id', 'id');
    }

    // Relation to suspend
    public function suspend()
    {
        return $this->belongsTo(Suspend::class, 'suspend_id', 'id');
    }

    // Relation to Brach
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    // Relation to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relation to Package
    public function Package()
    {
        return $this->belongsTo(Package::class);
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
}
