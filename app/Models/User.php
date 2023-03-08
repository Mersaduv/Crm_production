<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permission')
            ->withPivot('branch_id');
    }

    // Relation to Request
    public function requestTerminate()
    {
        return $this->hasOne(RequestTerminate::class, 'customer_id', 'id');
    }

    // Relation to NOC
    public function noc()
    {
        return $this->hasOne(NOC::class, 'user_id', 'id');
    }

    // Relation to NOC
    public function PrNocInfo()
    {
        return $this->hasOne(PrNocInfo::class, 'user_id', 'id');
    }

    // Relation to Sale
    public function sale()
    {
        return $this->hasOne(Sale::class, 'user_id', 'id');
    }

    // Relation to customers
    public function provincial()
    {
        return $this->hasOne(Provincial::class, 'user_id', 'id');
    }

    // Relation to Suspend
    public function suspend()
    {
        return $this->hasOne(Suspend::class, 'user_id', 'id');
    }

    // Relation to Suspend
    public function prsuspend()
    {
        return $this->hasOne(PrSuspend::class, 'user_id', 'id');
    }

    // Relation to reactivate
    public function reactivate()
    {
        return $this->hasOne(Reactivate::class, 'user_id', 'id');
    }

    // Relation to reactivate
    public function PrReactivate()
    {
        return $this->hasOne(PrReactivate::class, 'user_id', 'id');
    }

    // Relation to Terminate
    public function terminate()
    {
        return $this->hasOne(Terminate::class, 'user_id', 'id');
    }

    public function PrRecontract()
    {
        return $this->hasOne(PrRecontract::class, 'user_id', 'id');
    }

    // Relation to Recontract
    public function recontract()
    {
        return $this->hasOne(Recontract::class, 'user_id', 'id');
    }

    // Relation to Amend
    public function amend()
    {
        return $this->hasOne(Amend::class, 'user_id', 'id');
    }

    // Relation to Cancel Amend
    public function cancelAmend()
    {
        return $this->hasOne(CancelAmend::class, 'user_id', 'id');
    }

    // Relation to Amend
    public function prAmend()
    {
        return $this->hasOne(PrAmend::class, 'user_id', 'id');
    }

    // Relation to Cancel Amend
    public function prCancelAmend()
    {
        return $this->hasOne(PrCancelAmend::class, 'user_id', 'id');
    }

    // Relation to Amend
    public function cancel()
    {
        return $this->hasOne(Cancel::class, 'user_id', 'id');
    }

    // Relation to Commission
    public function commission()
    {
        return $this->hasOne(Commission::class, 'user_id', 'id');
    }

    // Relation to Marketer
    public function marketer()
    {
        return $this->hasOne(Marketer::class, 'user_id', 'id');
    }
}
