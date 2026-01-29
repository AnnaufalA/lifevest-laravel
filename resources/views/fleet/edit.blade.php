@extends('layouts.app')

@section('content')
    <div class="form-container-wide">
        <h2 class="form-header">✈️ Edit Aircraft: {{ $aircraft->registration }}</h2>

        <form action="{{ route('fleet.update', $aircraft->id) }}" method="POST" class="form-card">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Airline</label>
                <select name="airline_id" required class="form-select">
                    @foreach($airlines as $airline)
                        <option value="{{ $airline->id }}" {{ old('airline_id', $aircraft->airline_id) == $airline->id ? 'selected' : '' }}>
                            {{ $airline->name }} ({{ $airline->code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Registration</label>
                <input type="text" value="{{ $aircraft->registration }}" disabled class="form-input"
                    style="background: var(--bg-tertiary); cursor: not-allowed;">
                <small style="color: var(--text-secondary); font-size: 0.75rem;">Registration cannot be changed</small>
            </div>

            <div class="form-group">
                <label class="form-label">Type (e.g. A330-300)</label>
                <input type="text" name="type" value="{{ old('type', $aircraft->type) }}" required class="form-input"
                    style="text-transform: uppercase;">
            </div>

            <div class="form-group">
                <label class="form-label">Layout Template</label>
                <input type="text" value="{{ $aircraft->layout }}" disabled class="form-input"
                    style="background: var(--bg-tertiary); cursor: not-allowed;">
                <small style="color: var(--text-secondary); font-size: 0.75rem;">Layout cannot be changed after
                    creation</small>
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" {{ $aircraft->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="prolong" {{ $aircraft->status == 'prolong' ? 'selected' : '' }}>Prolong</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Aircraft</button>
                <a href="{{ route('fleet.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection