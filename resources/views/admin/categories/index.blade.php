@extends('layouts.admin')

@section('title', 'Categories & Plans | TRAIL Admin')

@push('styles')
    .plans-header {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 34px;
    }

    .eyebrow {
        margin: 0 0 9px;
        color: var(--moss);
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.13em;
        text-transform: uppercase;
    }

    .plans-header h1 {
        margin: 0;
        color: var(--forest);
        font-family: "Playfair Display", serif;
        font-size: clamp(2.3rem, 4vw, 3.8rem);
        font-weight: 500;
        letter-spacing: -0.06em;
    }

    .plans-header p:last-child {
        max-width: 590px;
        margin: 12px 0 0;
        color: var(--muted);
        font-size: 0.92rem;
        line-height: 1.6;
    }

    .primary-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 0 18px;
        border-radius: 999px;
        background: var(--forest);
        color: white;
        font-size: 0.82rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .primary-button:hover {
        background: var(--forest-dark);
        color: white;
    }

    .alert-success {
        margin-bottom: 22px;
        padding: 14px 16px;
        border: 1px solid #b8d8bc;
        border-radius: 10px;
        background: #edf8ee;
        color: #235e35;
        font-size: 0.84rem;
        font-weight: 600;
    }

    .plan-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .plan-card {
        padding: 26px;
        border: 1px solid var(--line);
        border-radius: 16px;
        background: var(--paper);
    }

    .plan-card.inactive {
        opacity: 0.65;
    }

    .plan-card-top {
        display: flex;
        align-items: start;
        justify-content: space-between;
        gap: 18px;
    }

    .plan-type {
        margin: 0 0 8px;
        color: var(--moss);
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .plan-card h2 {
        margin: 0;
        color: var(--forest);
        font-family: "Playfair Display", serif;
        font-size: 1.8rem;
        font-weight: 500;
        letter-spacing: -0.05em;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 9px;
        border-radius: 999px;
        background: #e6f3e6;
        color: #207144;
        font-size: 0.7rem;
        font-weight: 700;
    }

    .status-badge.inactive {
        background: #f1ede7;
        color: #796755;
    }

    .plan-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin: 26px 0;
        padding: 17px 0;
        border-top: 1px solid var(--line);
        border-bottom: 1px solid var(--line);
    }

    .plan-detail-label {
        display: block;
        margin-bottom: 5px;
        color: var(--muted);
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .plan-detail-value {
        color: var(--forest);
        font-size: 0.95rem;
        font-weight: 700;
    }

    .plan-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .outline-button,
    .danger-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 37px;
        padding: 0 13px;
        border-radius: 8px;
        font-size: 0.76rem;
        font-weight: 700;
    }

    .outline-button {
        border: 1px solid var(--forest);
        color: var(--forest);
    }

    .outline-button:hover {
        background: var(--forest);
        color: white;
    }

    .danger-button {
        border: 1px solid #dfaaaa;
        background: white;
        color: #b63434;
    }

    .danger-button:hover {
        background: #fff2f2;
    }

    .empty-state {
        padding: 52px 24px;
        border: 1px dashed var(--line);
        border-radius: 16px;
        background: var(--paper);
        color: var(--muted);
        text-align: center;
    }

    @media (max-width: 800px) {
        .plans-header {
            align-items: start;
            flex-direction: column;
        }

        .plan-grid {
            grid-template-columns: 1fr;
        }
    }
@endpush

@section('content')
    <section class="plans-header">
        <div>
            <p class="eyebrow">Membership Setup</p>
            <h1>Categories & Plans</h1>
            <p>Manage TRAIL membership offerings, their tiers, yearly fees, and public availability.</p>
        </div>

        <a href="{{ route('admin.categories.create') }}" class="primary-button">
            + Add membership plan
        </a>
    </section>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @forelse ($categories as $category)
        @if ($loop->first)
            <section class="plan-grid">
        @endif

        <article class="plan-card {{ ! $category->is_active ? 'inactive' : '' }}">
            <div class="plan-card-top">
                <div>
                    <p class="plan-type">Membership category</p>
                    <h2>{{ $category->name }}</h2>
                </div>

                <span class="status-badge {{ ! $category->is_active ? 'inactive' : '' }}">
                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <div class="plan-details">
                <div>
                    <span class="plan-detail-label">Membership level</span>
                    <span class="plan-detail-value">{{ $category->level }}</span>
                </div>

                <div>
                    <span class="plan-detail-label">Annual fee</span>
                    <span class="plan-detail-value">₱{{ number_format($category->fee, 2) }}</span>
                </div>
            </div>

            <div class="plan-actions">
                <a
                    href="{{ route('admin.categories.edit', $category) }}"
                    class="outline-button"
                >
                    Edit plan
                </a>

                <form
                    method="POST"
                    action="{{ route('admin.categories.destroy', $category) }}"
                    onsubmit="return confirm('Remove or deactivate this membership plan?');"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="danger-button">
                        {{ $category->is_active ? 'Deactivate' : 'Delete' }}
                    </button>
                </form>
            </div>
        </article>

        @if ($loop->last)
            </section>
        @endif
    @empty
        <section class="empty-state">
            No membership plans yet. Add your first TRAIL membership plan.
        </section>
    @endforelse
@endsection