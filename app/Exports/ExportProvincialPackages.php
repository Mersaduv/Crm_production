<?php

namespace App\Exports;

use App\Models\Provincial;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProvincialPackages implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = Provincial::latest('pr_customers.created_at');
        $customers = $customers
            ->where(function ($query) {
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
                    'package' =>   $customer->package ? $customer->package->name : 'NA',
                    'province' => province($customer->province),
                    'installation-date' => $customer->installation_date,
                    'status' => prStatus($customer->customer_id)['status'],
                    'date' => prStatus($customer->customer_id)['date'],
                ];
            });

        return $customers;
    }
}
