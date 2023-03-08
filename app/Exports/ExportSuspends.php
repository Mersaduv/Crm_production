<?php

namespace App\Exports;

use App\Models\Suspend;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportSuspends implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = Suspend::latest();
        $customers = $customers
            ->where('status', '=', 'suspend')
            ->whereNotNull('noc_confirmation')
            ->whereNull('reactivation_date')
            ->whereHas('customer', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->get()
            ->map(function ($customer) {
                return [
                    "id" => $customer->customer_id,
                    "full-name" => $customer->full_name,
                    'package' => $customer->package ? $customer->package->name : 'NA',
                    'activation-date' => $customer->customer->noc->activation_date,
                    'suspend-date' =>
                    $customer->suspend_date,
                    'suspend-by' =>  $customer->user->name
                ];
            });

        return $customers;
    }
}
