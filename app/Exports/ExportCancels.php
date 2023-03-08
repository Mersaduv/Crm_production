<?php

namespace App\Exports;

use App\Models\Cancel;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportCancels implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = Cancel::latest();
        $customers = $customers
            ->whereNull('rollback_date')
            ->whereNotNull('noc_confirmation')
            ->whereHas('customer', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->get()
            ->map(function ($customer) {
                return [
                    "id" => $customer->customer_id,
                    "full-name" => $customer->full_name,
                    'package' => $customer->package ? $customer->package->name : 'NA',
                    'installation-date' => $customer->customer->sale->installation_date,
                    'cancel-date' =>
                    $customer->cancel_date,
                    'cancel-by' =>  $customer->user->name
                ];
            });

        return $customers;
    }
}
