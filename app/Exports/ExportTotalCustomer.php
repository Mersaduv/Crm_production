<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportTotalCustomer implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Customer::all()
            ->whereNull('deleted_at')
            ->sortByDesc('created_at')
            ->map(function ($customer) {
                return [
                    "id" => $customer->customer_id,
                    "full-name" => $customer->full_name,
                    'package' => $customer->sale->package ? $customer->sale->package->name : 'NA',
                    'installation-date' => $customer->sale->installation_date,
                    'status' => status($customer->customer_id)['status'],
                    'date' => status($customer->customer_id)['date']
                ];
            });
    }

    public function exportActiveCustomer()
    {
        return Customer::all()
            ->whereNull('deleted_at')
            ->where('active_status', '=', '1')
            ->whereHas('noc')
            ->sortByDesc('customer_id')
            ->map(function ($customer) {
                return [
                    "id" => $customer->customer_id,
                    "full-name" => $customer->full_name,
                    'package' => $customer->sale->package ? $customer->sale->package->name : 'NA',
                    'installation-date' => $customer->sale->installation_date,
                    'activation-date' => status($customer->customer_id)['date']
                ];
            });
    }
}
