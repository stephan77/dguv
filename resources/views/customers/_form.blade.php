<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1" for="company">
            Firma
        </label>
        <input
            id="company"
            name="company"
            required
            value="{{ old('company', $customer->company ?? '') }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:border-slate-500 focus:ring focus:ring-slate-200"
        >
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1" for="name">
            Ansprechpartner
        </label>
        <input
            id="name"
            name="name"
            value="{{ old('name', $customer->name ?? '') }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:border-slate-500 focus:ring focus:ring-slate-200"
        >
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1" for="email">
            E-Mail
        </label>
        <input
            id="email"
            name="email"
            value="{{ old('email', $customer->email ?? '') }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:border-slate-500 focus:ring focus:ring-slate-200"
        >
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1" for="phone">
            Telefon
        </label>
        <input
            id="phone"
            name="phone"
            value="{{ old('phone', $customer->phone ?? '') }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:border-slate-500 focus:ring focus:ring-slate-200"
        >
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1" for="street">
            Straße
        </label>
        <input
            id="street"
            name="street"
            value="{{ old('street', $customer->street ?? '') }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:border-slate-500 focus:ring focus:ring-slate-200"
        >
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1" for="zip">
            PLZ
        </label>
        <input
            id="zip"
            name="zip"
            value="{{ old('zip', $customer->zip ?? '') }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:border-slate-500 focus:ring focus:ring-slate-200"
        >
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-slate-700 mb-1" for="city">
            Ort
        </label>
        <input
            id="city"
            name="city"
            value="{{ old('city', $customer->city ?? '') }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:border-slate-500 focus:ring focus:ring-slate-200"
        >
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-slate-700 mb-1" for="notes">
            Notizen
        </label>
        <textarea
            id="notes"
            name="notes"
            rows="4"
            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:border-slate-500 focus:ring focus:ring-slate-200"
        >{{ old('notes', $customer->notes ?? '') }}</textarea>
    </div>

</div>