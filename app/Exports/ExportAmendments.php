<?php

namespace App\Exports;

use App\Models\Amend;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportAmendments implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = Amend::latest();
        $customers = $customers
            ->whereHas('customer', function ($query) {
                $query->whereNull('deleted_at');
            })->where('cancel_status', '=', '0')
            ->whereNotNull('noc_confirmation')
            ->get()
            ->map(function ($customer) {
                return [
                    "id" => $customer->customer_id,
                    "full-name" => $customer->full_name,
                    'package' => $customer->package ? $customer->package->name : 'NA',
                    'activation-date' => $customer->customer->noc->activation_date,
                    'amendment-date' =>
                    $customer->amend_date,
                    'amendment-by' =>  $customer->user->name
                ];
            });

        return $customers;
    }
}
