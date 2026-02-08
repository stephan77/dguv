<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="utf-8">

<style>
@page {
    size: 40mm 70mm;
    margin: 0;
}

html, body {
    width: 40mm;
    height: 70mm;
    margin: 0;
    padding: 0;
    overflow: hidden;
    font-family: DejaVu Sans, sans-serif;
}

.label {
    position: absolute;
    top: 0;
    left: 0;
    width: 40mm;
    height: 70mm;
    padding: 3mm;
    box-sizing: border-box;
}

/* Kopf */
.inv {
    font-size: 10px;
    font-weight: bold;
    margin-bottom: 2mm;
}

/* Textblock */
.text {
    font-size: 8px;
    width: 26mm;
    line-height: 1.1;
}

/* QR oben rechts */
.qr {
    position: absolute;
    top: 3mm;
    right: 3mm;
}

/* SVG direkt skalieren */
.qr svg {
    width: 12mm;
    height: 12mm;
}
.dguv {
    position: absolute;
    bottom: 46.5mm;   /* Abstand vom unteren Rand – feinjustieren */
    left: 43%;
    transform: translateX(-50%);
    text-align: center;
    font-size: 8px;
    line-height: 1.1;
    width: 30mm;
}

.dguv strong {
    font-size: 11px;
    letter-spacing: 0.3px;
}
.next-check {
    position: absolute;
    bottom: 40.5mm;   /* Höhe über dem Stempel anpassen */
    left: 43%;
    transform: translateX(-50%);
    width: 30mm;
    text-align: center;
    font-size: 8px;
    font-weight: bold;
    border: 1px solid #000;
    padding: 1mm 0;
}

/* Schwarzer Pfeil darunter */
.arrow {
    position: absolute;
    bottom: 38.5mm;
    left: 12%;
    transform: translateX(-50%);

    width: 0;
    height: 0;

    border-left: 15mm solid transparent;
    border-right: 15mm solid transparent;
    border-top: 2mm solid #000;
}
/* Stempelbereich unten */
.stamp {
    position: absolute;
    bottom: 8mm;
    left: 43%;
    transform: translateX(-50%);
    width: 30mm;
    height: 30mm;
    border: 1px dashed #777;
    border-radius: 50%;
    text-align: center;
    line-height: 30mm;
    font-size: 9px;
}
</style>
</head>
<body>

<div class="label">

    <div class="inv">
        {{ $device->inventory_number }}
    </div>

    <div class="text">
        {{ $device->name }}<br>
        Seriennr: {{ $device->serial }}<br>
        {{ $device->customer->company }}
    </div>

    <div class="qr">
        {!! $qrCode !!}
    </div>
<div class="dguv">
    <strong>Prüfung</strong><br>
    gemäß DGUV Vorschrift
</div>
<div class="next-check">
    nächste Prüfung
    
</div>
<div class="arrow"></div>
    <div class="stamp">
        
    </div>

</div>

</body>
</html>