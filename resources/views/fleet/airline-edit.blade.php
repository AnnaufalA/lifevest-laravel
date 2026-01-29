@extends('layouts.app')

@section('content')
    <div class="form-container-wide">
        <h2 class="form-header">🏢 Edit Airline: {{ $airline->name }}</h2>

        <form action="{{ route('airlines.update', $airline->id) }}" method="POST" class="form-card">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Airline Name</label>
                <input type="text" name="name" value="{{ old('name', $airline->name) }}" required
                    placeholder="e.g. Garuda Indonesia" class="form-input"
                    style="{{ $errors->has('name') ? 'border-color: #ef4444;' : '' }}">
                @error('name')
                    <span
                        style="color: #ef4444; font-size: 0.875rem; display: block; margin-top: 0.25rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Airline Code (IATA)</label>
                <input type="text" name="code" value="{{ old('code', $airline->code) }}" placeholder="e.g. GA"
                    maxlength="10" class="form-input" style="text-transform: uppercase;">
                <small style="color: var(--text-secondary); font-size: 0.75rem;">Optional - e.g. GA for Garuda, QG for
                    Citilink</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Airline</button>
                <a href="{{ route('fleet.index', ['tab' => 'airlines']) }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection