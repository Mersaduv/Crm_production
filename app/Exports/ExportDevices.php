<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportDevices implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = Customer::latest('customers.created_at');
        $customers = $customers
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($customer) {
                return [
                    "id" => $customer->customer_id,
                    "full-name" => $customer->full_name,
                    'package' => $customer->sale->package ? $customer->sale->package->name : 'NA',
                    'installation-date' => $customer->sale->installation_date,
                    'receiver-type' =>
                    $customer->sale->receiver_type ? $customer->sale->receiver_type : 'NA',
                    'router-type' =>   $customer->sale->router_type ? $customer->sale->router_type : 'NA'
                ];
            });

        return $customers;
    }
}
