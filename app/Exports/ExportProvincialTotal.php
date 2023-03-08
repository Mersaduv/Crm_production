<?php

namespace App\Exports;

use App\Models\Provincial;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProvincialTotal implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return
            Provincial::all()
            ->whereNull('deleted_at')
            ->sortByDesc('created_at')
            ->map(function ($customer) {
                return [
                    "id" => $customer->customer_id,
                    "full-name" => $customer->full_name,
                    'package' =>  $customer->package ? $customer->package->name : 'NA',
                    'province' => province($customer->province),
                    'installation-date' =>  $customer->installation_date,
                    'status' => prStatus($customer->customer_id)['status'],
                    'date' => prStatus($customer->customer_id)['date']
                ];
            });
    }
}
