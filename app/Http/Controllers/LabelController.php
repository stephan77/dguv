<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Device;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LabelController extends Controller
{
    public function show(Device $device): Response
    {
        $device->load('customer');

        $qrPng = QrCode::format('png')
            ->size(140)
            ->margin(1)
            ->generate(route('devices.show', $device));

        $qrBase64 = base64_encode($qrPng);

        $pdf = Pdf::loadView('pdf.device-label', [
            'device' => $device,
            'qrCode' => $qrBase64,
        ])->setPaper([0, 0, 283.46, 141.73]);

        return $pdf->download('etikett-' . $device->inventory_number . '.pdf');
    }
}
