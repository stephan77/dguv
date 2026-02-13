@extends('layouts.app')

@section('content')
<div class="space-y-6" id="device-media-root" data-device-id="{{ $device->id }}" data-csrf="{{ csrf_token() }}">

    {{-- HEADER --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-start justify-between gap-6">
            <div>
                <h2 class="text-xl font-semibold flex items-center gap-3">
                    {{ $device->name }}
                    <span class="px-3 py-1 text-xs font-medium bg-slate-100 text-slate-700 rounded-lg">
                        {{ $device->inventory_number }}
                    </span>
                </h2>

                <p class="text-sm text-slate-600 mt-1">
                    {{ $device->manufacturer }} {{ $device->model }} · Seriennr. {{ $device->serial }}
                </p>

                <p class="text-sm text-slate-600 mt-1">
                    Kunde:
                    <span class="font-semibold text-slate-900">
                        {{ $device->customer->company }}
                    </span>
                </p>
            </div>

            <div class="flex gap-2 flex-wrap justify-end">
                <button type="button"
                        id="open-upload-modal"
                        class="px-4 py-2 text-sm rounded-xl border border-slate-300 hover:bg-slate-50">
                    Bilder/Videos hochladen
                </button>

                <a href="{{ route('devices.edit', $device) }}"
                   class="px-4 py-2 text-sm rounded-xl border border-slate-300 hover:bg-slate-50">
                    Bearbeiten
                </a>

                <a href="{{ route('devices.label', $device) }}"
                   class="px-4 py-2 text-sm rounded-xl bg-slate-900 text-white hover:bg-slate-800">
                    Etikett drucken
                </a>

                <form method="POST" action="{{ route('devices.destroy', $device) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 text-sm rounded-xl bg-red-600 text-white hover:bg-red-700">
                        Löschen
                    </button>
                </form>
            </div>
        </div>
    </div>


    {{-- INFO GRID --}}
    <div class="grid lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-semibold mb-4">Gerätedaten</h3>

            <div class="space-y-2 text-sm">
                <p><span class="font-medium">Typ:</span> {{ $device->type }}</p>
                <p><span class="font-medium">Standort:</span> {{ $device->location }}</p>
                <p>
                    <span class="font-medium">Nächste Prüfung:</span>
                    {{ optional($device->next_inspection)->format('d.m.Y') }}
                </p>
                <p><span class="font-medium">Notizen:</span> {{ $device->notes }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-semibold mb-2">Neue Prüfung</h3>
                <p class="text-sm text-slate-600">
                    Neue DGUV-Prüfung für dieses Gerät anlegen.
                </p>
            </div>

            <a href="{{ route('devices.inspections.create', $device) }}"
               class="mt-4 inline-flex justify-center px-4 py-2 text-sm rounded-xl bg-slate-900 text-white hover:bg-slate-800">
                Prüfung anlegen
            </a>
        </div>
    </div>


    {{-- INSPECTIONS --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold mb-4">Bisherige Prüfungen</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium text-slate-600">Datum</th>
                        <th class="text-left px-4 py-3 font-medium text-slate-600">Prüfer</th>
                        <th class="text-left px-4 py-3 font-medium text-slate-600">Norm</th>
                        <th class="text-left px-4 py-3 font-medium text-slate-600">Status</th>
                        <th class="text-left px-4 py-3 font-medium text-slate-600">Messwerte</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($device->inspections as $inspection)
                        <tr>
                            <td class="px-4 py-3">
                                {{ $inspection->inspection_date->format('d.m.Y') }}
                            </td>

                            <td class="px-4 py-3">{{ $inspection->inspector }}</td>
                            <td class="px-4 py-3">{{ $inspection->standard }}</td>

                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-lg
                                    {{ $inspection->passed ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $inspection->passed ? 'Bestanden' : 'Nicht bestanden' }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                @foreach ($inspection->measurements as $measurement)
                                    <div class="mb-3">
                                        <div class="font-semibold">
                                            {{ $measurement->test_type }}
                                        </div>

                                        <div class="{{ $measurement->rpe_result === 'nicht bestanden' ? 'text-red-600 font-medium' : 'text-slate-700' }}">
                                            RPE: {{ $measurement->rpe }} ({{ $measurement->rpe_result }})
                                        </div>

                                        <div class="{{ $measurement->riso_result === 'nicht bestanden' ? 'text-red-600 font-medium' : 'text-slate-700' }}">
                                            RISO: {{ $measurement->riso }} ({{ $measurement->riso_result }})
                                        </div>

                                        <div class="{{ $measurement->leakage_result === 'nicht bestanden' ? 'text-red-600 font-medium' : 'text-slate-700' }}">
                                            Leakage: {{ $measurement->leakage }} ({{ $measurement->leakage_result }})
                                        </div>
                                    </div>
                                @endforeach
                            </td>

                            <td class="px-4 py-3 flex gap-2">
                                <a href="{{ route('inspections.edit', $inspection) }}"
                                   class="px-3 py-1.5 text-xs rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                                    Bearbeiten
                                </a>

                                <form method="POST" action="{{ route('inspections.destroy', $inspection) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1.5 text-xs rounded-lg bg-red-600 text-white hover:bg-red-700">
                                        Löschen
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-slate-500">
                                Noch keine Prüfungen vorhanden.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6" id="media-section">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Medien</h3>
            <div class="text-xs text-slate-500">Bilder und Videos</div>
        </div>

        <div id="media-empty" class="text-sm text-slate-500 {{ $device->media->count() > 0 ? 'hidden' : '' }}">
            Noch keine Medien vorhanden.
        </div>

        <div id="media-slider" class="relative {{ $device->media->count() === 0 ? 'hidden' : '' }}">
            <button type="button" id="media-prev" class="absolute left-2 top-1/2 -translate-y-1/2 z-20 rounded-full bg-black/60 text-white w-9 h-9">‹</button>
            <button type="button" id="media-next" class="absolute right-2 top-1/2 -translate-y-1/2 z-20 rounded-full bg-black/60 text-white w-9 h-9">›</button>

            <div class="rounded-2xl overflow-hidden border border-slate-200 bg-slate-100">
                <div id="media-stage" class="aspect-video w-full flex items-center justify-center"></div>
            </div>
            <div id="media-meta" class="mt-3 text-sm text-slate-600"></div>
            <div class="mt-3 flex gap-2">
                <button id="set-primary" type="button" class="px-3 py-1.5 text-xs rounded-lg border border-slate-300 hover:bg-slate-50">Als Hauptbild setzen</button>
                <button id="delete-media" type="button" class="px-3 py-1.5 text-xs rounded-lg bg-red-600 text-white hover:bg-red-700">Löschen</button>
                <button id="open-fullscreen" type="button" class="px-3 py-1.5 text-xs rounded-lg bg-slate-900 text-white hover:bg-slate-800">Vollbild</button>
            </div>
        </div>
    </div>

    <div id="upload-modal" class="fixed inset-0 bg-black/40 hidden items-center justify-center p-4 z-50">
        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-semibold">Bilder/Videos hochladen</h4>
                <button id="close-upload-modal" class="text-slate-500 hover:text-slate-700" type="button">✕</button>
            </div>
            <div id="dropzone" class="border-2 border-dashed border-slate-300 rounded-xl p-8 text-center text-sm text-slate-600">
                Dateien hier ablegen oder
                <label class="font-medium text-slate-900 cursor-pointer underline">
                    auswählen
                    <input type="file" id="media-input" class="hidden" multiple accept=".jpg,.jpeg,.png,.webp,.mp4,.webm">
                </label>
            </div>
            <div id="upload-list" class="mt-4 space-y-2"></div>
        </div>
    </div>

    <div id="fullscreen-modal" class="fixed inset-0 bg-black/90 hidden items-center justify-center p-4 z-50">
        <button id="close-fullscreen" class="absolute top-4 right-4 text-white text-2xl">✕</button>
        <div id="fullscreen-content" class="max-w-6xl w-full max-h-full"></div>
    </div>
</div>

<script>
(() => {
    const root = document.getElementById('device-media-root');
    if (!root) return;

    const deviceId = root.dataset.deviceId;
    const csrf = root.dataset.csrf;
    const mediaState = { items: @json($device->media->values()), index: 0 };

    const modal = document.getElementById('upload-modal');
    const fullModal = document.getElementById('fullscreen-modal');
    const dropzone = document.getElementById('dropzone');
    const input = document.getElementById('media-input');
    const uploadList = document.getElementById('upload-list');
    const slider = document.getElementById('media-slider');
    const empty = document.getElementById('media-empty');
    const stage = document.getElementById('media-stage');
    const meta = document.getElementById('media-meta');

    const showUploadModal = () => { modal.classList.remove('hidden'); modal.classList.add('flex'); };
    const closeUploadModal = () => { modal.classList.add('hidden'); modal.classList.remove('flex'); uploadList.innerHTML = ''; };

    document.getElementById('open-upload-modal').addEventListener('click', showUploadModal);
    document.getElementById('close-upload-modal').addEventListener('click', closeUploadModal);

    dropzone.addEventListener('dragover', (event) => { event.preventDefault(); dropzone.classList.add('border-slate-600'); });
    dropzone.addEventListener('dragleave', () => dropzone.classList.remove('border-slate-600'));
    dropzone.addEventListener('drop', (event) => {
        event.preventDefault();
        dropzone.classList.remove('border-slate-600');
        handleFiles(Array.from(event.dataTransfer.files));
    });

    input.addEventListener('change', () => handleFiles(Array.from(input.files)));

    function handleFiles(files) {
        if (!files.length) return;

        files.forEach((file) => {
            const row = document.createElement('div');
            row.className = 'text-xs';
            row.innerHTML = `<div class="flex justify-between"><span>${file.name}</span><span class="progress-label">0%</span></div><div class="mt-1 h-2 bg-slate-200 rounded"><div class="progress h-2 bg-slate-800 rounded" style="width:0%"></div></div>`;
            uploadList.appendChild(row);

            const form = new FormData();
            form.append('files[]', file);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', `/devices/${deviceId}/media`);
            xhr.setRequestHeader('X-CSRF-TOKEN', csrf);
            xhr.responseType = 'json';

            xhr.upload.addEventListener('progress', (event) => {
                if (!event.lengthComputable) return;
                const percent = Math.round((event.loaded / event.total) * 100);
                row.querySelector('.progress').style.width = `${percent}%`;
                row.querySelector('.progress-label').textContent = `${percent}%`;
            });

            xhr.onload = () => {
                if (xhr.status >= 200 && xhr.status < 300) {
                    const created = xhr.response?.data ?? [];
                    mediaState.items = [...created, ...mediaState.items];
                    renderMedia();
                    row.querySelector('.progress-label').textContent = 'Fertig';
                } else {
                    row.querySelector('.progress-label').textContent = 'Fehlgeschlagen';
                }
            };
            xhr.send(form);
        });
    }

    function renderMedia() {
        if (!mediaState.items.length) {
            slider.classList.add('hidden');
            empty.classList.remove('hidden');
            return;
        }

        slider.classList.remove('hidden');
        empty.classList.add('hidden');
        if (mediaState.index > mediaState.items.length - 1) mediaState.index = mediaState.items.length - 1;
        if (mediaState.index < 0) mediaState.index = 0;

        const item = mediaState.items[mediaState.index];
        stage.innerHTML = '';

        if (item.file_type === 'video') {
            const video = document.createElement('video');
            video.src = item.file_url;
            video.controls = true;
            video.className = 'max-h-[480px] w-full';
            stage.appendChild(video);
            document.getElementById('set-primary').classList.add('hidden');
        } else {
            const image = document.createElement('img');
            image.src = item.file_url;
            image.className = 'max-h-[480px] object-contain';
            stage.appendChild(image);
            document.getElementById('set-primary').classList.remove('hidden');
        }

        meta.textContent = `Upload: ${new Date(item.uploaded_at).toLocaleString('de-DE')} ${item.is_primary ? '· Hauptbild' : ''}`;
    }

    document.getElementById('media-prev').addEventListener('click', () => { mediaState.index -= 1; renderMedia(); });
    document.getElementById('media-next').addEventListener('click', () => { mediaState.index += 1; renderMedia(); });

    document.getElementById('set-primary').addEventListener('click', async () => {
        const current = mediaState.items[mediaState.index];
        if (!current || current.file_type !== 'image') return;

        await fetch(`/devices/${deviceId}/media/${current.id}/primary`, {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
        });

        mediaState.items = mediaState.items.map((item) => ({ ...item, is_primary: item.id === current.id }));
        mediaState.items.sort((a, b) => Number(b.is_primary) - Number(a.is_primary));
        mediaState.index = mediaState.items.findIndex((item) => item.id === current.id);
        renderMedia();
    });

    document.getElementById('delete-media').addEventListener('click', async () => {
        const current = mediaState.items[mediaState.index];
        if (!current) return;

        await fetch(`/devices/${deviceId}/media/${current.id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
        });

        mediaState.items = mediaState.items.filter((item) => item.id !== current.id);
        renderMedia();
    });

    document.getElementById('open-fullscreen').addEventListener('click', () => {
        const current = mediaState.items[mediaState.index];
        if (!current) return;

        const content = document.getElementById('fullscreen-content');
        content.innerHTML = current.file_type === 'video'
            ? `<video src="${current.file_url}" controls autoplay class="w-full max-h-[90vh]"></video>`
            : `<img src="${current.file_url}" class="w-full max-h-[90vh] object-contain" />`;
        fullModal.classList.remove('hidden');
        fullModal.classList.add('flex');
    });

    document.getElementById('close-fullscreen').addEventListener('click', () => {
        fullModal.classList.add('hidden');
        fullModal.classList.remove('flex');
        document.getElementById('fullscreen-content').innerHTML = '';
    });

    renderMedia();
})();
</script>
@endsection
