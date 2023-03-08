<?php

namespace App\Exports;

use App\Models\PrRecontract;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProvincialRecontracts implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = PrRecontract::latest();
        $customers = $customers
            ->whereHas('provincial', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->whereNotNull('noc_confirmation')
            ->where('status', '=', 'confirm')
            ->get()
            ->map(function ($customer) {
                return [
                    "id" => $customer->customer_id,
                    "full-name" => $customer->full_name,
                    'package' => $customer->package ? $customer->package->name : 'NA',
                    'province' =>  province($customer->province),
                    'termination-date' => $customer->terminate->terminate_date,
                    'reacontract-date' => $customer->recontract_date,
                ];
            });

        return $customers;
    }
}
