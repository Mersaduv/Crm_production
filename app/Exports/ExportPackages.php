<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportPackages implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = Customer::latest('customers.created_at');
        $customers = $customers
            ->whereHas('sale', function ($query) {
                $query->where('active_status', '=', '1')
                    ->orWhere('cancel_status', '=', '1')
                    ->orWhere('suspend_status', '=', '1')
                    ->orWhere('terminate_status', '=', '1');
            })
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($customer) {
                return [
                    "id" => $customer->customer_id,
                    "full-name" => $customer->full_name,
                    'package' =>  $customer->sale->package ? $customer->sale->package->name : 'NA',
                    'installation-date' =>
                    $customer->sale->installation_date,
                    'status' => status($customer->customer_id)
                ];
            });

        return $customers;
    }
}
