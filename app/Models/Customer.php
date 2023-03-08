<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    // Relation to User
    public function User()
    {
        return $this->belongsTo(User::class, 'sales_agent');
    }

    // Relation to Brach
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    // Relation to Request
    public function requestTerminate()
    {
        return $this->hasOne(RequestTerminate::class, 'customer_id', 'id')->orderBy('request_date', 'desc');
    }

    // Relation to NOC Info
    public function noc()
    {
        return $this->hasOne(NOC::class, 'customer_id', 'id')->orderBy('activation_date', 'desc');
    }

    // Relation to Payment Info
    public function payment()
    {
        return $this->hasOne(Payment::class, 'customer_id', 'id')->orderBy('created_at', 'desc');
    }

    // Relation to Cancel Info
    public function cancel()
    {
        return $this->hasMany(Cancel::class, 'cu_id', 'id')->orderBy('cancel_date', 'desc');
    }

    // Relation to Sales Info
    public function sale()
    {
        return $this->hasOne(Sale::class, 'customer_id', 'id');
    }

    // Relation to Suspend
    public function suspend()
    {
        return $this->hasMany(Suspend::class, 'cu_id', 'id')->orderBy('suspend_date', 'desc');
    }

    // Relation to Reactivate
    public function reactivates()
    {
        return $this->hasMany(Reactivate::class, 'cu_id', 'id')->orderBy('reactivation_date', 'desc');
    }

    // Relation to Terminate
    public function terminate()
    {
        return $this->hasMany(Terminate::class, 'cu_id', 'id')->orderBy('termination_date', 'desc');
    }

    // Relation to Recontract
    public function recontracts()
    {
        return $this->hasMany(Recontract::class, 'cu_id', 'id')->orderBy('recontract_date', 'desc');
    }

    // Relation to Amend
    public function amend()
    {
        return $this->hasMany(Amend::class, 'cu_id', 'id')->orderBy('amend_date', 'desc');
    }

    // Relation to Cancel Amend
    public function cancelAmend()
    {
        return $this->hasMany(CancelAmend::class, 'cu_id', 'id')->orderBy('cancel_date', 'desc');
    }

    // Relation to noc attachments
    public function nocAttachment()
    {
        return $this->hasMany(NocAttachment::class, 'customer_id', 'id');
    }
}
