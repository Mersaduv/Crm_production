<?php

namespace App\Exports;

use App\Models\Provincial;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProvincialActives implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = Provincial::latest('pr_customers.created_at');
        $customers = $customers
            ->where('active_status', '=', '1')
            ->whereNull('deleted_at')
            ->whereHas('PrNocInfo')
            ->get()
            ->map(function ($customer) {
                return [
                    "id" => $customer->customer_id,
                    "full-name" =>  $customer->full_name,
                    'package' => $customer->package ? $customer->package->name : 'NA',
                    'province' => province($customer->province),
                    'installation-date' => $customer->installation_date,
                    'activation-date' => $customer->PrNocInfo ? $customer->PrNocInfo->activation_date : 'NA'
                ];
            });

        return $customers;
    }
}
