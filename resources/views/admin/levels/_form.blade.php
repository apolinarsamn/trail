@push('styles')
    .level-form-card {
        max-width: 900px;
        padding: 32px;
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 20px;
    }

    .level-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .level-form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .level-form-group.full-width {
        grid-column: 1 / -1;
    }

    .level-form-group label {
        font-size: .82rem;
        font-weight: 800;
    }

    .level-form-group input,
    .level-form-group textarea {
        width: 100%;
        padding: 13px;
        border: 1px solid var(--line);
        border-radius: 10px;
        outline: none;
    }

    .level-form-group textarea {
        min-height: 130px;
        resize: vertical;
    }

    .level-form-group input:focus,
    .level-form-group textarea:focus {
        border-color: var(--forest);
        box-shadow: 0 0 0 3px rgba(22, 58, 43, .12);
    }

    .form-help {
        margin: 0;
        color: var(--muted);
        font-size: .78rem;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 28px;
        padding-top: 22px;
        border-top: 1px solid var(--line);
    }

    .back-button,
    .save-button {
        padding: 12px 17px;
        border-radius: 999px;
        font-size: .82rem;
        font-weight: 800;
        text-decoration: none;
        cursor: pointer;
    }

    .back-button {
        color: var(--forest);
        background: transparent;
        border: 1px solid var(--forest);
    }

    .save-button {
        color: white;
        background: var(--forest);
        border: 1px solid var(--forest);
    }

    .validation-box {
        padding: 15px;
        margin-bottom: 22px;
        color: #842029;
        background: #fff3f3;
        border: 1px solid #f1b9b7;
        border-radius: 12px;
    }
@endpush

@if ($errors->any())
    <div class="validation-box">
        <strong>Please review the highlighted information.</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="level-form-card">
    <form action="{{ $action }}" method="POST">
        @csrf

        @if ($method !== 'POST')
            @method($method)
        @endif

        <div class="level-form-grid">
            <div class="level-form-group">
                <label for="name">Level name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $level->name) }}"
                    placeholder="e.g. Gold"
                    required
                >
                <p class="form-help">Use Basic, Silver, Gold, or Platinum.</p>
            </div>

            <div class="level-form-group">
                <label for="fee">Annual fee (₱)</label>
                <input
                    type="number"
                    id="fee"
                    name="fee"
                    value="{{ old('fee', $level->fee) }}"
                    min="0"
                    step="0.01"
                    placeholder="e.g. 1500.00"
                    required
                >
            </div>

            <div class="level-form-group">
                <label for="validity_months">Validity period (months)</label>
                <input
                    type="number"
                    id="validity_months"
                    name="validity_months"
                    value="{{ old('validity_months', $level->validity_months ?? 12) }}"
                    min="1"
                    max="120"
                    required
                >
                <p class="form-help">Most TRAIL memberships are valid for 12 months.</p>
            </div>

            <div class="level-form-group">
                <label for="is_active">Public availability</label>

                <label style="display: flex; align-items: center; gap: 10px; padding-top: 11px;">
                    <input
                        type="checkbox"
                        id="is_active"
                        name="is_active"
                        value="1"
                        style="width: 17px; height: 17px; accent-color: var(--forest);"
                        @checked(old('is_active', $level->is_active ?? true))
                    >
                    Make this level available to applicants
                </label>
            </div>

            <div class="level-form-group full-width">
                <label for="benefits">Benefits</label>
                <textarea
                    id="benefits"
                    name="benefits"
                    placeholder="e.g. Member-rate outdoor activities, priority event registration, TRAIL community access"
                >{{ old('benefits', $level->benefits) }}</textarea>
                <p class="form-help">Describe the benefits included with this level.</p>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.levels.index') }}" class="back-button">
                Cancel
            </a>

            <button type="submit" class="save-button">
                {{ $submitLabel }} →
            </button>
        </div>
    </form>
</div>