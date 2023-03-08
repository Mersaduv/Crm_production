<?php

namespace App\Exports;

use App\Models\PrTerminate;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProvincialTerminated implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = PrTerminate::latest();
        $customers = $customers
            ->where('status', '=', 'terminate')
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
                    'termination-date' => $customer->terminate_date,
                ];
            });

        return $customers;
    }
}
