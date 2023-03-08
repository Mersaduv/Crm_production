<?php

namespace App\Exports;

use App\Models\PrAmend;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProvincialAmendments implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = PrAmend::latest();
        $customers = $customers
            ->whereHas('provincial', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->where('pr_amend_info.cancel_status', '=', '0')
            ->whereNotNull('noc_confirmation')
            ->get()
            ->map(function ($customer) {
                return [
                    "id" => $customer->customer_id,
                    "full-name" => $customer->full_name,
                    'package' => $customer->package ? $customer->package->name : 'NA',
                    'province' => province($customer->province),
                    'activation-date' => $customer->provincial->PrNocInfo->activation_date,
                    'amendment-date' => $customer->amend_date
                ];
            });

        return $customers;
    }
}
