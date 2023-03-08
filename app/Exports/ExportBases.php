<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportBases implements FromCollection
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
                    'province' => 'Herat',
                    'branch' => $customer->branch->name . '-' . $customer->branch->address
                ];
            });

        return $customers;
    }
}
