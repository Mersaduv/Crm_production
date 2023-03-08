<?php

namespace App\Exports;

use App\Models\PrCancel;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProvincialCancels implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = PrCancel::latest();
        $customers = $customers
            ->whereNull('rollback_date')
            ->whereNotNull('pr_cancel_info.noc_confirmation')
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
                    'installation-date' => $customer->provincial->installation_date,
                    'cancel-date' => $customer->cancel_date
                ];
            });

        return $customers;
    }
}
