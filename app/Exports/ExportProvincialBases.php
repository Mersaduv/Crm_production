<?php

namespace App\Exports;

use App\Models\Provincial;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProvincialBases implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = Provincial::latest('pr_customers.created_at');
        $customers = $customers
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($customer) {
                return [
                    "id" => $customer->customer_id,
                    "full-name" => $customer->full_name,
                    'package' => $customer->package ? $customer->package->name : 'NA',
                    'installation-date' => $customer->installation_date,
                    'province' => province($customer->province),
                    'branch' => $customer->branch->name . '-' . $customer->branch->address
                ];
            });

        return $customers;
    }
}
