<?php

namespace App\Exports;

use App\Models\PrCancelAmend;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProvincialCancelAmendments implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = PrCancelAmend::latest();
        $customers = $customers
            ->whereHas('provincial', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->whereNotNull('pr_amend_cancel.noc_confirmation')
            ->get()
            ->map(function ($customer) {
                return [
                    "id" => $customer->customer_id,
                    "full-name" => $customer->full_name,
                    'package' => $customer->package ? $customer->package->name : 'NA',
                    'province' => province($customer->province),
                    'amendment-date' => $customer->amend->amend_date,
                    'cancel-date' => $customer->cancel_date,
                ];
            });

        return $customers;
    }
}
