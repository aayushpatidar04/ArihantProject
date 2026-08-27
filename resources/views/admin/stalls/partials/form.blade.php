@csrf

@if(isset($stall))
    @method('PUT')
@endif

<div class="form-grid">
    <div class="form-group">
        <label for="name">
            Stall Name <span>*</span>
        </label>

        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $stall->name ?? '') }}"
            placeholder="Enter stall name"
            required
        >

        @error('name')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="location">Location / Zone</label>

        <input
            type="text"
            id="location"
            name="location"
            value="{{ old('location', $stall->location ?? '') }}"
            placeholder="Example: Hall A, Zone 2"
        >

        @error('location')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group form-group-full">
        <label for="description">Stall Description</label>

        <textarea
            id="description"
            name="description"
            rows="5"
            placeholder="Enter information about this stall..."
        >{{ old('description', $stall->description ?? '') }}</textarea>

        @error('description')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group form-group-full">
        <label class="toggle-row">
            <input
                type="checkbox"
                name="is_active"
                value="1"
                @checked(old('is_active', $stall->is_active ?? true))
            >

            <span class="toggle-text">
                <strong>Active Stall</strong>
                <small>
                    Only active stalls can be accessed through their QR code.
                </small>
            </span>
        </label>
    </div>
</div>

<div class="form-actions">
    <a href="{{ route('admin.stalls.index') }}" class="btn btn-ghost">
        Cancel
    </a>

    <button type="submit" class="btn btn-primary">
        {{ isset($stall) ? 'Update Stall' : 'Create Stall' }}
    </button>
</div>