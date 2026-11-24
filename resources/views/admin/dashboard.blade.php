@extends('layouts.admin')

@section('title', 'Dashboard | TRAIL Admin')

@push('styles')
    .dashboard-heading {
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

    .dashboard-heading h1 {
        margin: 0;
        color: var(--forest);
        font-family: "Playfair Display", serif;
        font-size: clamp(2.3rem, 4vw, 3.8rem);
        font-weight: 500;
        letter-spacing: -0.06em;
    }

    .dashboard-heading p:last-child {
        max-width: 460px;
        margin: 12px 0 0;
        color: var(--muted);
        font-size: 0.92rem;
        line-height: 1.6;
    }

    .dashboard-date {
        color: var(--muted);
        font-size: 0.78rem;
        white-space: nowrap;
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .stat-card {
        min-height: 150px;
        padding: 22px;
        border: 1px solid var(--line);
        border-radius: 16px;
        background: var(--paper);
    }

    .stat-card.highlight {
        border-color: var(--forest);
        background: var(--forest);
        color: white;
    }

    .stat-label {
        margin: 0;
        color: var(--muted);
        font-size: 0.75rem;
        font-weight: 700;
    }

    .highlight .stat-label {
        color: rgba(255, 255, 255, 0.72);
    }

    .stat-value {
        margin: 23px 0 0;
        color: var(--forest);
        font-family: "Playfair Display", serif;
        font-size: 3rem;
        font-weight: 500;
        letter-spacing: -0.07em;
        line-height: 1;
    }

    .highlight .stat-value {
        color: white;
    }

    .stat-caption {
        margin: 10px 0 0;
        color: var(--muted);
        font-size: 0.74rem;
    }

    .highlight .stat-caption {
        color: rgba(255, 255, 255, 0.72);
    }

    .dashboard-lower {
        display: grid;
        grid-template-columns: 1.35fr 0.65fr;
        gap: 16px;
        margin-top: 28px;
    }

    .dashboard-panel {
        padding: 26px;
        border: 1px solid var(--line);
        border-radius: 16px;
        background: var(--paper);
    }

    .panel-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 22px;
    }

    .panel-heading h2 {
        margin: 0;
        color: var(--forest);
        font-family: "Playfair Display", serif;
        font-size: 1.45rem;
        font-weight: 500;
        letter-spacing: -0.04em;
    }

    .panel-heading span {
        color: var(--muted);
        font-size: 0.74rem;
    }

    .quick-actions {
        display: grid;
        gap: 10px;
    }

    .quick-action {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px;
        border: 1px solid var(--line);
        border-radius: 10px;
        color: var(--forest);
        font-size: 0.82rem;
        font-weight: 700;
    }

    .quick-action:hover {
        border-color: var(--moss);
        background: #f0f5ed;
    }

    .system-note {
        padding: 18px;
        border-radius: 12px;
        background: #edf3e9;
    }

    .system-note strong {
        display: block;
        color: var(--forest);
        font-size: 0.84rem;
    }

    .system-note p {
        margin: 8px 0 0;
        color: var(--muted);
        font-size: 0.8rem;
        line-height: 1.55;
    }

    @media (max-width: 1100px) {
        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 760px) {
        .dashboard-heading,
        .dashboard-lower {
            display: block;
        }

        .dashboard-date {
            display: block;
            margin-top: 16px;
        }

        .dashboard-lower {
            margin-top: 16px;
        }

        .dashboard-panel + .dashboard-panel {
            margin-top: 16px;
        }
    }

    @media (max-width: 500px) {
        .stat-grid {
            grid-template-columns: 1fr;
        }
    }
@endpush

@section('content')
    <section class="dashboard-heading">
        <div>
            <p class="eyebrow">Operations Overview</p>
            <h1>Good morning.</h1>
            <p>Monitor TRAIL memberships, applications, transactions, and payments in one place.</p>
        </div>

        <span class="dashboard-date">{{ now()->format('l, F j, Y') }}</span>
    </section>

    <section class="stat-grid">
        <article class="stat-card">
            <p class="stat-label">Total members</p>
            <p class="stat-value">{{ $totalMembers }}</p>
            <p class="stat-caption">All registered TRAIL members</p>
        </article>

        <article class="stat-card highlight">
            <p class="stat-label">Active members</p>
            <p class="stat-value">{{ $activeMembers }}</p>
            <p class="stat-caption">Currently active memberships</p>
        </article>

        <article class="stat-card">
            <p class="stat-label">Pending transactions</p>
            <p class="stat-value">{{ $pendingTransactions }}</p>
            <p class="stat-caption">Awaiting verified payment</p>
        </article>

        <article class="stat-card">
            <p class="stat-label">Collected payments</p>
            <p class="stat-value">₱{{ number_format($collectedPayments, 2) }}</p>
            <p class="stat-caption">All verified membership payments</p>
        </article>
    </section>

    <section class="dashboard-lower">
        <article class="dashboard-panel">
            <div class="panel-heading">
                <h2>Quick actions</h2>
                <span>Manage TRAIL records</span>
            </div>

            <div class="quick-actions">
                <a href="{{ route('members.create') }}" class="quick-action">
                    Register a member <span>→</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" class="quick-action">
                    Manage membership categories <span>→</span>
                </a>

                <a href="{{ route('admin.levels.index') }}" class="quick-action">
                    Manage membership levels <span>→</span>
                </a>

                <a href="{{ route('admin.applications.index') }}" class="quick-action">
                    Review membership applications <span>→</span>
                </a>

                <a href="{{ route('admin.transactions.index') }}" class="quick-action">
                    Process transactions <span>→</span>
                </a>

                <a href="{{ route('admin.payments.index') }}" class="quick-action">
                    Record a payment <span>→</span>
                </a>
            </div>
        </article>

        <article class="dashboard-panel">
            <div class="panel-heading">
                <h2>System status</h2>
            </div>

            <div class="system-note">
                <strong>TRAIL workflow is active</strong>
                <p>
                    Applications can be reviewed, transactions created, payments recorded,
                    and only fully paid transactions can be approved.
                </p>
            </div>
        </article>
    </section>
@endsection