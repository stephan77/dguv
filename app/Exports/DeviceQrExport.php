<?php

namespace App\Exports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DeviceQrExport implements FromCollection, WithHeadings, WithDrawings
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
                '', // Platzhalter für QR
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Inventarnummer',
            'QR Code',
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $row = 2;

        foreach ($this->devices as $device) {

            $path = storage_path('app/public/qrcodes/'.$device->id.'.png');

            if (!file_exists($path)) {
                file_put_contents(
                    $path,
                    QrCode::format('png')
                        ->size(150)
                        ->generate(route('devices.show', $device))
                );
            }

            $drawing = new Drawing();
            $drawing->setName('QR');
            $drawing->setPath($path);
            $drawing->setHeight(80);
            $drawing->setCoordinates('B'.$row);

            $drawings[] = $drawing;
            $row++;
        }

        return $drawings;
    }
}