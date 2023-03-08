<?php

namespace App\Exports;

use App\Models\CancelAmend;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportCancelAmendments implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = CancelAmend::latest();
        $customers = $customers
            ->whereHas('customer', function ($query) {
                $query->whereNull('deleted_at');
            })->whereNotNull('noc_confirmation')
            ->get()
            ->map(function ($customer) {
                return [
                    "id" => $customer->customer_id,
                    "full-name" => $customer->full_name,
                    'package' => $customer->package ? $customer->package->name : 'NA',
                    'amendment-date' =>
                    $customer->amend->amend_date,
                    'cancel-date' =>
                    $customer->cancel_date,
                    'cancel-by' =>  $customer->user->name
                ];
            });

        return $customers;
    }
}
