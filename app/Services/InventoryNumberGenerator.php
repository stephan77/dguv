<?php

namespace App\Services;

use App\Models\Device;

class InventoryNumberGenerator
{
    public function generate(): string
    {
        // Höchste vorhandene Inventarnummer holen
        $last = Device::orderByDesc('id')->first();

        if (!$last || !$last->inventory_number) {
            return 'INV-000001';
        }

        // Nummer extrahieren
        if (preg_match('/INV-(\d+)/', $last->inventory_number, $matches)) {
            $next = (int)$matches[1] + 1;
        } else {
            $next = 1;
        }

        return 'INV-' . str_pad($next, 6, '0', STR_PAD_LEFT);
    }
}