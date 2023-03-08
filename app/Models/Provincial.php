<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provincial extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'pr_customers';
    protected $guarded = [];

    // Relation to Package
    public function Package()
    {
        return $this->belongsTo(Package::class);
    }

    // Relation to Brach
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    // Relation to Brach
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation to Payment Info
    public function pr_payment()
    {
        return $this->hasOne(PrPayment::class, 'customer_id', 'id')->orderBy('created_at', 'desc');
    }

    // Relation to attachments
    public function PrAttachments()
    {
        return $this->hasMany(PrAttachments::class, 'customer_id', 'id');
    }

    // Relation to noc attachments
    public function PrNocAttachments()
    {
        return $this->hasMany(PrNocAttachments::class, 'customer_id', 'id');
    }

    // Relation to pr noc Info
    public function PrNocInfo()
    {
        return $this->hasOne(PrNocInfo::class, 'customer_id', 'id')->orderBy('activation_date', 'desc');
    }

    // Relation to Terminate
    public function terminate()
    {
        return $this->hasMany(PrTerminate::class, 'pr_cu_id', 'id')->orderBy('terminate_date', 'desc');
    }

    // Relation to PrRecontract
    public function recontract()
    {
        return $this->hasMany(PrRecontract::class, 'pr_cu_id', 'id')->orderBy('recontract_date', 'desc');
    }

    // Relation to Suspend
    public function suspend()
    {
        return $this->hasMany(PrSuspend::class, 'pr_cu_id', 'id')->orderBy('suspend_date', 'desc');
    }

    // Relation to PrReactivate
    public function reactivate()
    {
        return $this->hasMany(PrReactivate::class, 'pr_cu_id', 'id')->orderBy('reactive_date', 'desc');
    }

    // Relation to Amend
    public function amend()
    {
        return $this->hasMany(PrAmend::class, 'pr_cu_id', 'id')->orderBy('amend_date', 'desc');
    }

    // Relation to Cancel Amend
    public function cancelAmend()
    {
        return $this->hasMany(PrCancelAmend::class, 'pr_cu_id', 'id')->orderBy('cancel_date', 'desc');
    }

    // Relation to Cancel Info
    public function prCancel()
    {
        return $this->hasMany(PrCancel::class, 'pr_cu_id', 'id')->orderBy('cancel_date', 'desc');
    }

    // Relation to Request
    public function request()
    {
        return $this->hasOne(PrTerminateRequest::class, 'customer_id', 'id')->orderBy('request_date', 'desc');
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
