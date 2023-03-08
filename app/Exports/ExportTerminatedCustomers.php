<?php

namespace App\Exports;

use App\Models\Terminate;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportTerminatedCustomers implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = Terminate::latest();
        $customers = $customers
            ->where('status', '=', 'terminate')
            ->whereNotNull('noc_confirmation')
            ->whereNull('recontract_date')
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
                    'termination-date' =>
                    $customer->termination_date,
                    'terminated-by' =>  $customer->user->name
                ];
            });

        return $customers;
    }
}
