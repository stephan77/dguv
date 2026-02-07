<div class="grid grid-2">
    <div>
        <label for="company">Firma</label>
        <input id="company" name="company" value="{{ old('company', $customer->company ?? '') }}" required>
    </div>
    <div>
        <label for="name">Ansprechpartner</label>
        <input id="name" name="name" value="{{ old('name', $customer->name ?? '') }}">
    </div>
    <div>
        <label for="email">E-Mail</label>
        <input id="email" name="email" value="{{ old('email', $customer->email ?? '') }}">
    </div>
    <div>
        <label for="phone">Telefon</label>
        <input id="phone" name="phone" value="{{ old('phone', $customer->phone ?? '') }}">
    </div>
    <div>
        <label for="street">Straße</label>
        <input id="street" name="street" value="{{ old('street', $customer->street ?? '') }}">
    </div>
    <div>
        <label for="zip">PLZ</label>
        <input id="zip" name="zip" value="{{ old('zip', $customer->zip ?? '') }}">
    </div>
    <div>
        <label for="city">Ort</label>
        <input id="city" name="city" value="{{ old('city', $customer->city ?? '') }}">
    </div>
    <div>
        <label for="notes">Notizen</label>
        <textarea id="notes" name="notes" rows="3">{{ old('notes', $customer->notes ?? '') }}</textarea>
    </div>
</div>
