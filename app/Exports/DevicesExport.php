<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DevicesExport implements FromCollection, WithHeadings
{
    protected $devices;

    public function __construct(Collection $devices)
    {
        $this->devices = $devices;
    }

    public function collection()
    {
        return $this->devices->map(function ($device) {
            return [
                'Inventar'      => $device->inventory_number,
                'Gerätename'    => $device->name,
                'Hersteller'    => $device->manufacturer,
                'Modell'        => $device->model,
                'Seriennummer'  => $device->serial,
                'Typ'           => $device->type,
                'Standort'      => $device->location,
                'Kunde'         => $device->customer->company ?? '',
                'Nächste Prüfung' => optional($device->next_inspection)->format('d.m.Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Inventar',
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