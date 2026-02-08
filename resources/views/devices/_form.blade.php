<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div>
        <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Gerätename</label>
        <input id="name" name="name"
               value="{{ old('name', $device->name ?? '') }}"
               required
               class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-slate-900 focus:border-slate-900">
    </div>

    <div>
        <label for="manufacturer" class="block text-sm font-medium text-slate-700 mb-1">Hersteller</label>
        <input id="manufacturer" name="manufacturer"
               value="{{ old('manufacturer', $device->manufacturer ?? '') }}"
               class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-slate-900 focus:border-slate-900">
    </div>

    <div>
        <label for="model" class="block text-sm font-medium text-slate-700 mb-1">Modell</label>
        <input id="model" name="model"
               value="{{ old('model', $device->model ?? '') }}"
               class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-slate-900 focus:border-slate-900">
    </div>

    <div>
        <label for="serial" class="block text-sm font-medium text-slate-700 mb-1">Seriennummer</label>
        <input id="serial" name="serial"
               value="{{ old('serial', $device->serial ?? '') }}"
               class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-slate-900 focus:border-slate-900">
    </div>

    <div>
        <label for="type" class="block text-sm font-medium text-slate-700 mb-1">Gerätetyp</label>
        <input id="type" name="type"
               value="{{ old('type', $device->type ?? '') }}"
               class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-slate-900 focus:border-slate-900">
    </div>

    <div>
        <label for="location" class="block text-sm font-medium text-slate-700 mb-1">Standort</label>
        <input id="location" name="location"
               value="{{ old('location', $device->location ?? '') }}"
               class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-slate-900 focus:border-slate-900">
    </div>

    <div>
        <label for="inventory_number" class="block text-sm font-medium text-slate-700 mb-1">Inventarnummer</label>
        <input id="inventory_number" name="inventory_number"
               value="{{ old('inventory_number', $device->inventory_number ?? '') }}"
               class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-slate-900 focus:border-slate-900">
    </div>

    <div>
        <label for="next_inspection" class="block text-sm font-medium text-slate-700 mb-1">Nächste Prüfung</label>
        <input id="next_inspection" type="date" name="next_inspection"
               value="{{ old('next_inspection', optional($device->next_inspection ?? null)->format('Y-m-d')) }}"
               class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-slate-900 focus:border-slate-900">
    </div>

    <div class="md:col-span-2">
        <label for="notes" class="block text-sm font-medium text-slate-700 mb-1">Notizen</label>
        <textarea id="notes" name="notes" rows="3"
                  class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-slate-900 focus:border-slate-900">{{ old('notes', $device->notes ?? '') }}</textarea>
    </div>

</div>