<?php

namespace App\Exports;

use App\Models\Reactivate;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportReactivates implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = Reactivate::latest();
        $customers = $customers
            ->whereHas('customer', function ($query) {
                $query->whereNull('deleted_at');
            })->where('status', '=', 'confirm')
            ->whereNotNull("noc_confirmation")
            ->get()
            ->map(function ($customer) {
                return [
                    "id" => $customer->customer_id,
                    "full-name" => $customer->full_name,
                    'package' => $customer->package ? $customer->package->name : 'NA',
                    'suspend-date' =>
                    $customer->suspend->suspend_date,
                    're-activated-date' =>
                    $customer->reactivation_date,
                    're-activated-by' =>  $customer->user->name
                ];
            });

        return $customers;
    }
}
