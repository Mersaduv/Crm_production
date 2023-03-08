<?php

namespace App\Exports;

use App\Models\PrReactivate;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProvincialReactivates implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = PrReactivate::latest();
        $customers = $customers
            ->whereHas('provincial', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->whereNotNull('noc_confirmation')
            ->get()
            ->map(function ($customer) {
                return [
                    "id" => $customer->customer_id,
                    "full-name" => $customer->full_name,
                    'package' => $customer->package ? $customer->package->name : 'NA',
                    'province' => province($customer->province),
                    'suspend-date' =>  $customer->suspend->suspend_date,
                    're-activated-date' => $customer->reactive_date,
                ];
            });

        return $customers;
    }
}
