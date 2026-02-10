<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerQrExport implements FromCollection, WithHeadings
{
    protected $devices;

    public function __construct($devices)
    {
        $this->devices = $devices;
    }

    public function collection()
    {
return $this->devices->map(function ($device) {
    return [
        $device->inventory_number,
        route('devices.public', $device),
    ];
});
    }

    public function headings(): array
    {
        return [
            'Inventarnummer',
            'QR_TEXT',
        ];
    }
}