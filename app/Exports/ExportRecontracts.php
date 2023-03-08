<?php

namespace App\Exports;

use App\Models\Recontract;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportRecontracts implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = Recontract::latest();
        $customers = $customers
            ->whereHas('customer', function ($query) {
                $query->whereNull('deleted_at');
            })->whereNotNull('noc_confirmation')
            ->where('status', '=', 'confirm')
            ->get()
            ->map(function ($customer) {
                return [
                    "id" => $customer->customer_id,
                    "full-name" => $customer->full_name,
                    'package' => $customer->package ? $customer->package->name : 'NA',
                    'termination-date' => $customer->terminate->termination_date,
                    'reacontract-date' =>
                    $customer->recontract_date,
                    'recontract-by' =>  $customer->user->name
                ];
            });

        return $customers;
    }
}
