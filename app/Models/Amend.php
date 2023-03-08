<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amend extends Model
{
    use HasFactory;

    protected $table = 'customer_amend_info';

    // Relation to Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cu_id', 'id');
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

    // Relation to resellers
    public function commission()
    {
        return $this->belongsTo(Commission::class, 'commission_id', 'id');
    }

    // Relation to Marketer
    public function marketer()
    {
        return $this->belongsTo(Marketer::class, 'marketer_id', 'id');
    }

    // Relation to Request
    public function cancelAmend()
    {
        return $this->hasOne(CancelAmend::class, 'amend_id', 'id');
    }
}
