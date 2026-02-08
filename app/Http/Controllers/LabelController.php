<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Device;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LabelController extends Controller
{
public function show(Device $device)
{
    $device->load('customer');

    $qrSvg = QrCode::format('svg')
        ->size(120)
        ->margin(0)
        ->generate(route('devices.show', $device));

    $pdf = Pdf::loadView('pdf.device-label', [
        'device' => $device,
        'qrCode' => $qrSvg,   // KEIN base64 mehr!
    ])->setPaper([0, 0, 113.39, 198.43]);

    return $pdf->stream('etikett.pdf');
}
}
