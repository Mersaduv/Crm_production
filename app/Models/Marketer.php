<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marketer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'marketers';

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'phone',
        'user_id'
    ];

    // Relation to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relation to customers
    public function provincials()
    {
        return $this->hasMany(Provincial::class, 'marketer_id', 'id')->orderBy('created_at', 'desc');
    }

    // Relation to sales
    public function sales()
    {
        return $this->hasMany(Sale::class, 'marketer_id', 'id')->orderBy('created_at', 'desc');
    }

    // Relation to cancels
    public function cancels()
    {
        return $this->hasMany(Cancel::class, 'marketer_id', 'id')->orderBy('created_at', 'desc');
    }

    // Relation to suspends
    public function suspends()
    {
        return $this->hasMany(Suspend::class, 'marketer_id', 'id')->orderBy('created_at', 'desc');
    }

    // Relation to reactivates
    public function reactivates()
    {
        return $this->hasMany(Reactivate::class, 'marketer_id', 'id')->orderBy('created_at', 'desc');
    }

    // Relation to PrReactivate
    public function prreactivate()
    {
        return $this->hasMany(PrReactivate::class, 'marketer_id', 'id')->orderBy('created_at', 'desc');
    }

    // Relation to terminates
    public function terminates()
    {
        return $this->hasMany(Terminate::class, 'marketer_id', 'id')->orderBy('created_at', 'desc');
    }

    // Relation to recontracts
    public function recontracts()
    {
        return $this->hasMany(Recontract::class, 'marketer_id', 'id')->orderBy('created_at', 'desc');
    }

    // Relation to amends
    public function amends()
    {
        return $this->hasMany(Amend::class, 'marketer_id', 'id')->orderBy('created_at', 'desc');
    }

    // Relation to cancel amends
    public function cancelAmends()
    {
        return $this->hasMany(CancelAmend::class, 'marketer_id', 'id')->orderBy('created_at', 'desc');
    }

    public function prSuspends()
    {
        return $this->hasMany(PrSuspend::class, 'marketer_id', 'id')->orderBy('created_at', 'desc');
    }

    public function prTerminates()
    {
        return $this->hasMany(PrTerminate::class, 'marketer_id', 'id')->orderBy('created_at', 'desc');
    }

    public function prAmends()
    {
        return $this->hasMany(PrAmend::class, 'marketer_id', 'id')->orderBy('created_at', 'desc');
    }

    public function prCancelAmends()
    {
        return $this->hasMany(PrCancelAmend::class, 'marketer_id', 'id')->orderBy('created_at', 'desc');
    }

    public function prCancels()
    {
        return $this->hasMany(PrCancel::class, 'marketer_id', 'id')->orderBy('created_at', 'desc');
    }

    public function PrRecontract()
    {
        return $this->hasMany(PrRecontract::class, 'marketer_id', 'id')->orderBy('created_at', 'desc');
    }
}
