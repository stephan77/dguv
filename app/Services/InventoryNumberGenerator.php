<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Device;

class InventoryNumberGenerator
{
    public function generate(): string
    {
        $latest = Device::query()
            ->whereNotNull('inventory_number')
            ->orderByDesc('inventory_number')
            ->value('inventory_number');

        if (!$latest) {
            return 'INV-000001';
        }

        $number = (int) preg_replace('/[^0-9]/', '', $latest);
        $nextNumber = $number + 1;

        return sprintf('INV-%06d', $nextNumber);
    }
}
