@extends('layouts.admin')

@section('title', 'Application Details | TRAIL')

@push('styles')
    .application-detail-page {
        max-width: 1150px;
    }

    .detail-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 30px;
    }

    .detail-header h1 {
        margin: 8px 0;
    }

    .detail-header p {
        margin: 0;
        color: var(--muted);
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 16px;
        color: var(--forest);
        border: 1px solid var(--forest);
        border-radius: 999px;
        font-size: .8rem;
        font-weight: 800;
        text-decoration: none;
        white-space: nowrap;
    }

    .detail-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.55fr) minmax(290px, .75fr);
        gap: 22px;
    }

    .detail-card {
        padding: 28px;
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 20px;
    }

    .detail-card h2 {
        margin: 0 0 22px;
        color: var(--forest);
        font-family: "Playfair Display", serif;
        font-size: 1.55rem;
    }

    .detail-card h3 {
        margin: 0 0 8px;
        color: var(--muted);
        font-size: .68rem;
        font-weight: 800;
        letter-spacing: .09em;
        text-transform: uppercase;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .detail-item {
        padding-bottom: 18px;
        border-bottom: 1px solid var(--line);
    }

    .detail-item.full-width {
        grid-column: 1 / -1;
    }

    .detail-item p {
        margin: 0;
        color: var(--ink);
        font-size: .95rem;
        font-weight: 600;
        line-height: 1.55;
    }

    .reference-box {
        padding: 17px;
        margin-bottom: 16px;
        background: #eef2e8;
        border-radius: 14px;
    }

    .reference-box span {
        display: block;
        margin-bottom: 5px;
        color: var(--muted);
        font-size: .7rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .reference-box strong {
        color: var(--forest);
        font-family: monospace;
        font-size: .98rem;
    }

    .status-badge {
        display: inline-flex;
        padding: 8px 11px;
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 800;
        text-transform: capitalize;
    }

    .status-pending {
        color: #875b10;
        background: #fff3d6;
    }

    .status-paid {
        color: #075c4a;
        background: #d9f4ec;
    }

    .status-approved {
        color: #176b39;
        background: #e0f2e4;
    }

    .status-cancelled,
    .status-expired {
        color: #9e2520;
        background: #fde5e3;
    }

    .plan-name {
        margin: 6px 0;
        color: var(--forest);
        font-family: "Playfair Display", serif;
        font-size: 1.8rem;
    }

    .plan-meta {
        margin: 0;
        color: var(--muted);
        font-size: .86rem;
    }

    .side-section {
        padding-bottom: 21px;
        margin-bottom: 21px;
        border-bottom: 1px solid var(--line);
    }

    .side-section:last-child {
        padding-bottom: 0;
        margin-bottom: 0;
        border-bottom: 0;
    }

    @media (max-width: 900px) {
        .detail-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 650px) {
        .detail-header {
            flex-direction: column;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .detail-item.full-width {
            grid-column: auto;
        }
    }
@endpush

@section('content')
    @php
        $statusClass = in_array($application->status, ['paid', 'approved', 'expired', 'cancelled'])
            ? $application->status
            : 'pending';
    @endphp

    <section class="application-detail-page">
        <div class="detail-header">
            <div>
                <p class="eyebrow">Membership Application</p>
                <h1>{{ $application->full_name }}</h1>
                <p>Review the applicant’s submitted membership information.</p>
            </div>

            <a href="{{ route('admin.applications.index') }}" class="back-button">
                ← Back to applications
            </a>
        </div>

        <div class="detail-layout">
            <div class="detail-card">
                <h2>Applicant details</h2>

                <div class="detail-grid">
                    <div class="detail-item">
                        <h3>Full name</h3>
                        <p>{{ $application->full_name }}</p>
                    </div>

                    <div class="detail-item">
                        <h3>Email address</h3>
                        <p>{{ $application->email }}</p>
                    </div>

                    <div class="detail-item">
                        <h3>Phone number</h3>
                        <p>{{ $application->phone ?: 'Not provided' }}</p>
                    </div>

                    <div class="detail-item">
                        <h3>Submitted on</h3>
                        <p>{{ $application->created_at->format('F d, Y · g:i A') }}</p>
                    </div>

                    <div class="detail-item full-width">
                        <h3>Home address</h3>
                        <p>{{ $application->address ?: 'Not provided' }}</p>
                    </div>
                </div>
            </div>

            <aside>
                <div class="detail-card">
                    <div class="side-section">
                        <h3>Application reference</h3>

                        <div class="reference-box">
                            <span>Reference number</span>
                            <strong>{{ $application->reference_no }}</strong>
                        </div>

                        <span class="status-badge status-{{ $statusClass }}">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>

                    <div class="side-section">
                        <h3>Selected membership plan</h3>

                        @if ($plan)
                            <p class="plan-name">{{ $plan->name }}</p>
                            <p class="plan-meta">{{ $plan->level }} Membership</p>
                            <p class="plan-meta">
                                Annual fee: ₱{{ number_format($plan->fee, 2) }}
                            </p>
                        @else
                            <p class="plan-meta">The selected plan is no longer available.</p>
                        @endif
                    </div>

                    <div class="side-section">
                        <h3>Application status</h3>
                        <p class="plan-meta">
                            This application is currently marked as
                            <strong>{{ ucfirst($application->status) }}</strong>.
                        </p>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection