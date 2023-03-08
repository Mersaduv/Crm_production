<?php

namespace App\Exports;

use App\Models\PrSuspend;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProvincialSuspends implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = PrSuspend::latest();
        $customers = $customers
            ->where('status', '=', 'suspend')
            ->whereNotNull('noc_confirmation')
            ->whereHas('provincial', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->get()
            ->map(function ($customer) {
                return [
                    "id" => $customer->customer_id,
                    "full-name" => $customer->full_name,
                    'package' => $customer->package ? $customer->package->name : 'NA',
                    'province' => province($customer->province),
                    'activation-date' => $customer->provincial->PrNocInfo->activation_date,
                    'suspend-date' => $customer->suspend_date,
                ];
            });

        return $customers;
    }
}
