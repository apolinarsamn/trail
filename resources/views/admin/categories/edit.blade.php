@extends('layouts.admin')

@section('title', 'Edit Membership Plan | TRAIL')

@push('styles')
    .plan-form-page { max-width: 920px; }

    .plan-form-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 30px;
    }

    .plan-form-card {
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 22px;
        padding: 36px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group.full-width { grid-column: 1 / -1; }

    .form-group label {
        color: var(--ink);
        font-size: .82rem;
        font-weight: 700;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 13px 14px;
        color: var(--ink);
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 10px;
        outline: none;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: var(--forest);
        box-shadow: 0 0 0 3px rgba(22, 58, 43, .12);
    }

    .field-help {
        margin: 0;
        color: var(--muted);
        font-size: .78rem;
    }

    .status-option {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 8px;
        color: var(--ink);
    }

    .status-option input {
        width: 17px;
        height: 17px;
        accent-color: var(--forest);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 30px;
        padding-top: 24px;
        border-top: 1px solid var(--line);
    }

    .cancel-button,
    .save-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 18px;
        border-radius: 999px;
        font-size: .85rem;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .cancel-button {
        color: var(--forest);
        border: 1px solid var(--forest);
        background: transparent;
    }

    .save-button {
        color: #fff;
        border: 1px solid var(--forest);
        background: var(--forest);
    }

    .validation-box {
        margin-bottom: 24px;
        padding: 16px 18px;
        color: #842029;
        background: #fff3f3;
        border: 1px solid #f1b9b7;
        border-radius: 12px;
    }

    .validation-box ul {
        margin: 8px 0 0;
        padding-left: 20px;
    }
@endpush

@section('content')
    <section class="plan-form-page">
        <div class="plan-form-header">
            <div>
                <p class="eyebrow">Membership Setup</p>
                <h1>Edit membership plan</h1>
                <p>Update the category, tier, annual fee, or public availability of this TRAIL membership plan.</p>
            </div>

            <a href="{{ route('admin.categories.index') }}" class="cancel-button">
                ← Back to plans
            </a>
        </div>

        <div class="plan-form-card">
            @if ($errors->any())
                <div class="validation-box">
                    <strong>Please review the highlighted information.</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Membership category</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $category->name) }}"
                            required
                        >
                        <p class="field-help">The type of member this plan is intended for.</p>
                    </div>

                    <div class="form-group">
                        <label for="level">Membership level</label>
                        <select id="level" name="level" required>
                            @foreach (['Basic', 'Silver', 'Gold', 'Platinum'] as $level)
                                <option
                                    value="{{ $level }}"
                                    @selected(old('level', $category->level) === $level)
                                >
                                    {{ $level }}
                                </option>
                            @endforeach
                        </select>
                        <p class="field-help">This determines the membership tier.</p>
                    </div>

                    <div class="form-group full-width">
                        <label for="fee">Annual membership fee (₱)</label>
                        <input
                            type="number"
                            id="fee"
                            name="fee"
                            value="{{ old('fee', $category->fee) }}"
                            min="0"
                            step="0.01"
                            required
                        >
                        <p class="field-help">Enter 0 for a free membership plan.</p>
                    </div>

                    <div class="form-group full-width">
                        <label>Public availability</label>

                        <label class="status-option" for="is_active">
                            <input
                                type="checkbox"
                                id="is_active"
                                name="is_active"
                                value="1"
                                @checked(old('is_active', $category->is_active))
                            >
                            Make this membership plan available to new TRAIL applicants
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.categories.index') }}" class="cancel-button">
                        Cancel
                    </a>

                    <button type="submit" class="save-button">
                        Save changes →
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection