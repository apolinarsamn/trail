@extends('layouts.admin')

@section('title', 'Membership Levels | TRAIL')

@push('styles')
    .levels-page { max-width: 1450px; }

    .levels-header {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 30px;
    }

    .levels-header h1 {
        margin: 8px 0;
    }

    .levels-header p {
        margin: 0;
        color: var(--muted);
    }

    .primary-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 13px 18px;
        color: #fff;
        background: var(--forest);
        border-radius: 999px;
        font-size: .82rem;
        font-weight: 800;
        text-decoration: none;
    }

    .levels-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
    }

    .level-card {
        display: flex;
        min-height: 315px;
        flex-direction: column;
        padding: 28px;
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 20px;
    }

    .level-card.inactive {
        opacity: .68;
    }

    .level-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
    }

    .level-card h2 {
        margin: 6px 0 0;
        color: var(--forest);
        font-family: "Playfair Display", serif;
        font-size: 2rem;
    }

    .eyebrow {
        margin: 0;
        color: var(--moss);
        font-size: .67rem;
        font-weight: 800;
        letter-spacing: .11em;
        text-transform: uppercase;
    }

    .status-badge {
        display: inline-flex;
        padding: 7px 10px;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 800;
    }

    .status-active {
        color: #176b39;
        background: #e0f2e4;
    }

    .status-inactive {
        color: #875b10;
        background: #fff3d6;
    }

    .level-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin: 26px 0 20px;
        padding: 20px 0;
        border-top: 1px solid var(--line);
        border-bottom: 1px solid var(--line);
    }

    .level-details span {
        display: block;
        margin-bottom: 5px;
        color: var(--muted);
        font-size: .67rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .level-details strong {
        color: var(--ink);
        font-size: .95rem;
    }

    .benefits {
        margin: 0;
        color: var(--muted);
        font-size: .83rem;
        line-height: 1.6;
    }

    .card-actions {
        display: flex;
        gap: 12px;
        margin-top: auto;
        padding-top: 24px;
    }

    .edit-button,
    .deactivate-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: .78rem;
        font-weight: 800;
        text-decoration: none;
        cursor: pointer;
    }

    .edit-button {
        color: var(--forest);
        border: 1px solid var(--forest);
        background: transparent;
    }

    .deactivate-button {
        color: #b42318;
        border: 1px solid #efaaa5;
        background: transparent;
    }

    .success-message {
        padding: 15px 18px;
        margin-bottom: 22px;
        color: #176b39;
        background: #e7f4e8;
        border: 1px solid #b6ddbb;
        border-radius: 12px;
        font-weight: 600;
    }

    .empty-state {
        padding: 70px 24px;
        text-align: center;
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 20px;
    }

    .empty-state h2 {
        margin-bottom: 8px;
        color: var(--forest);
        font-family: "Playfair Display", serif;
    }

    .empty-state p {
        margin-bottom: 20px;
        color: var(--muted);
    }

    @media (max-width: 850px) {
        .levels-header { align-items: stretch; flex-direction: column; }
        .levels-grid { grid-template-columns: 1fr; }
    }
@endpush

@section('content')
    <section class="levels-page">
        <div class="levels-header">
            <div>
                <p class="eyebrow">Membership Setup</p>
                <h1>Membership Levels</h1>
                <p>Manage membership tiers, annual fees, validity periods, and member benefits.</p>
            </div>

            <a href="{{ route('admin.levels.create') }}" class="primary-button">
                + Add membership level
            </a>
        </div>

        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        @forelse ($levels as $level)
            @if ($loop->first)
                <div class="levels-grid">
            @endif

            <article class="level-card {{ $level->is_active ? '' : 'inactive' }}">
                <div class="level-card-top">
                    <div>
                        <p class="eyebrow">Membership Level</p>
                        <h2>{{ $level->name }}</h2>
                    </div>

                    <span class="status-badge {{ $level->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $level->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <div class="level-details">
                    <div>
                        <span>Annual Fee</span>
                        <strong>₱{{ number_format($level->fee, 2) }}</strong>
                    </div>

                    <div>
                        <span>Validity</span>
                        <strong>{{ $level->validity_months }} month{{ $level->validity_months != 1 ? 's' : '' }}</strong>
                    </div>
                </div>

                <p class="benefits">
                    {{ $level->benefits ?: 'No benefits description has been added yet.' }}
                </p>

                <div class="card-actions">
                    <a href="{{ route('admin.levels.edit', $level) }}" class="edit-button">
                        Edit level
                    </a>

                    @if ($level->is_active)
                        <form
                            action="{{ route('admin.levels.destroy', $level) }}"
                            method="POST"
                            onsubmit="return confirm('Deactivate this membership level?');"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="deactivate-button">
                                Deactivate
                            </button>
                        </form>
                    @endif
                </div>
            </article>

            @if ($loop->last)
                </div>
            @endif
        @empty
            <div class="empty-state">
                <h2>No membership levels yet</h2>
                <p>Add Basic, Silver, Gold, and Platinum to complete the TRAIL membership offerings.</p>

                <a href="{{ route('admin.levels.create') }}" class="primary-button">
                    + Add first level
                </a>
            </div>
        @endforelse
    </section>
@endsection