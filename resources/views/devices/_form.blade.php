<div class="grid grid-2">
    <div>
        <label for="name">Gerätename</label>
        <input id="name" name="name" value="{{ old('name', $device->name ?? '') }}" required>
    </div>
    <div>
        <label for="manufacturer">Hersteller</label>
        <input id="manufacturer" name="manufacturer" value="{{ old('manufacturer', $device->manufacturer ?? '') }}">
    </div>
    <div>
        <label for="model">Modell</label>
        <input id="model" name="model" value="{{ old('model', $device->model ?? '') }}">
    </div>
    <div>
        <label for="serial">Seriennummer</label>
        <input id="serial" name="serial" value="{{ old('serial', $device->serial ?? '') }}">
    </div>
    <div>
        <label for="type">Gerätetyp</label>
        <input id="type" name="type" value="{{ old('type', $device->type ?? '') }}">
    </div>
    <div>
        <label for="location">Standort</label>
        <input id="location" name="location" value="{{ old('location', $device->location ?? '') }}">
    </div>
    <div>
        <label for="inventory_number">Inventarnummer</label>
        <input id="inventory_number" name="inventory_number" value="{{ old('inventory_number', $device->inventory_number ?? '') }}">
    </div>
    <div>
        <label for="next_inspection">Nächste Prüfung</label>
        <input id="next_inspection" type="date" name="next_inspection" value="{{ old('next_inspection', optional($device->next_inspection ?? null)->format('Y-m-d')) }}">
    </div>
    <div>
        <label for="notes">Notizen</label>
        <textarea id="notes" name="notes" rows="3">{{ old('notes', $device->notes ?? '') }}</textarea>
    </div>
</div>
