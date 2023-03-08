<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $table = 'customers_sales_info';

    protected $guarded = ['null'];

    // Relation to Package
    public function Package()
    {
        return $this->belongsTo(Package::class);
    }

    // Relation to Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    // Relation to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relation to sales attachments
    public function salesAttachment()
    {
        return $this->hasMany(SalesAttachment::class, 'sales_id', 'id');
    }


    // Relation to sales Commission
    public function commission()
    {
        return $this->belongsTo(Commission::class, 'commission_id', 'id');
    }

    // Relation to sales Marketer
    public function marketer()
    {
        return $this->belongsTo(Marketer::class, 'marketer_id', 'id');
    }
}
