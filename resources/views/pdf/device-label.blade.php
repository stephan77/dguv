<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        .label { border: 1px solid #111; padding: 6px; width: 240px; height: 120px; }
        .title { font-weight: bold; font-size: 12px; }
        .row { margin-bottom: 4px; }
        img { width: 70px; height: 70px; }
    </style>
</head>
<body>
    <div class="label">
        <div class="row title">{{ $device->inventory_number }}</div>
        <div class="row">{{ $device->name }}</div>
        <div class="row">Seriennummer: {{ $device->serial }}</div>
        <div class="row">Kunde: {{ $device->customer->company }}</div>
        <div class="row">
            <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
        </div>
    </div>
</body>
</html>
