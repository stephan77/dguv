<?php

namespace App\Exports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DevicesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Device::with('customer')->get()->map(function ($device) {
            return [
                $device->inventory_number,
                $device->name,
                $device->manufacturer,
                $device->model,
                $device->serial,
                $device->type,
                $device->location,
                $device->customer->company ?? '',
                optional($device->next_inspection)->format('d.m.Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Inventarnummer',
            'Gerätename',
            'Hersteller',
            'Modell',
            'Seriennummer',
            'Typ',
            'Standort',
            'Kunde',
            'Nächste Prüfung',
        ];
    }
}