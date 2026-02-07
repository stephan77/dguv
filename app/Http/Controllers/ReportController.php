<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    public function customer(Customer $customer): Response
    {
        $customer->load(['devices.inspections.measurements']);

        $pdf = Pdf::loadView('pdf.customer-report', [
            'customer' => $customer,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('bericht-' . $customer->id . '.pdf');
    }
}
