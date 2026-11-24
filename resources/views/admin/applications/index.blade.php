@extends('layouts.admin')

@section('title', 'Applications | TRAIL')

@push('styles')
    .applications-page {
        max-width: 1450px;
    }

    .applications-header {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 30px;
    }

    .applications-header h1 {
        margin: 8px 0;
    }

    .applications-header p {
        margin: 0;
        color: var(--muted);
    }

    .application-summary {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .summary-chip {
        min-width: 145px;
        padding: 13px 16px;
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 14px;
    }

    .summary-chip span {
        display: block;
        margin-bottom: 4px;
        color: var(--muted);
        font-size: .73rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .summary-chip strong {
        color: var(--forest);
        font-size: 1.25rem;
    }

    .application-filters {
        display: grid;
        grid-template-columns: minmax(240px, 1fr) 220px auto;
        gap: 12px;
        padding: 16px;
        margin-bottom: 24px;
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 18px;
    }

    .application-filters input,
    .application-filters select {
        width: 100%;
        padding: 12px 14px;
        color: var(--ink);
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 10px;
        outline: none;
    }

    .application-filters input:focus,
    .application-filters select:focus {
        border-color: var(--forest);
        box-shadow: 0 0 0 3px rgba(22, 58, 43, .10);
    }

    .filter-button {
        padding: 12px 21px;
        color: #fff;
        background: var(--forest);
        border: 1px solid var(--forest);
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
    }

    .applications-table-wrap {
        overflow-x: auto;
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 18px;
    }

    .applications-table {
        width: 100%;
        min-width: 900px;
        border-collapse: collapse;
    }

    .applications-table th {
        padding: 15px 20px;
        color: var(--muted);
        background: #f1f2ec;
        font-size: .72rem;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .applications-table td {
        padding: 18px 20px;
        border-top: 1px solid var(--line);
        vertical-align: middle;
    }

    .applicant-name {
        margin-bottom: 4px;
        color: var(--ink);
        font-weight: 800;
    }

    .applicant-email,
    .reference-number,
    .application-date {
        color: var(--muted);
        font-size: .83rem;
    }

    .reference-number {
        color: var(--forest);
        font-family: monospace;
        font-weight: 700;
    }

    .status-badge {
        display: inline-flex;
        padding: 7px 10px;
        border-radius: 999px;
        font-size: .72rem;
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

        .view-application-link {
        display: inline-flex;
        padding: 9px 12px;
        color: var(--forest);
        border: 1px solid var(--forest);
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 800;
        text-decoration: none;
        white-space: nowrap;
    }

    .view-application-link:hover {
        color: #fff;
        background: var(--forest);
    }

    .empty-state {
        padding: 72px 24px;
        text-align: center;
    }

    .empty-state h2 {
        margin-bottom: 8px;
        color: var(--forest);
    }

    .empty-state p {
        margin: 0;
        color: var(--muted);
    }

    @media (max-width: 800px) {
        .applications-header {
            align-items: stretch;
            flex-direction: column;
        }

        .application-filters {
            grid-template-columns: 1fr;
        }
    }
@endpush

@section('content')
    <section class="applications-page">
        <div class="applications-header">
            <div>
                <p class="eyebrow">Membership Operations</p>
                <h1>Applications</h1>
                <p>Review membership applications submitted through the public TRAIL website.</p>
            </div>

            <div class="application-summary">
                <div class="summary-chip">
                    <span>Total applications</span>
                    <strong>{{ $applications->count() }}</strong>
                </div>

                <div class="summary-chip">
                    <span>Pending review</span>
                    <strong>{{ $applications->where('status', 'pending')->count() }}</strong>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.applications.index') }}" method="GET" class="application-filters">
            <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search name, email, or reference number"
            >

            <select name="status">
                <option value="">All statuses</option>
                @foreach (['pending', 'paid', 'approved', 'expired', 'cancelled'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="filter-button">Search</button>
        </form>

        <div class="applications-table-wrap">
            @forelse ($applications as $application)
                @php
                    $statusClass = in_array($application->status, ['paid', 'approved', 'expired', 'cancelled'])
                        ? $application->status
                        : 'pending';
                @endphp

                @if ($loop->first)
                    <table class="applications-table">
                        <thead>
                            <tr>
                                <th>Applicant</th>
                                <th>Reference number</th>
                                <th>Contact</th>
                                <th>Submitted</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                @endif

                <tr>
                    <td>
                        <div class="applicant-name">{{ $application->full_name }}</div>
                        <div class="applicant-email">{{ $application->email }}</div>
                    </td>

                    <td>
                        <span class="reference-number">{{ $application->reference_no }}</span>
                    </td>

                    <td>
                        <div>{{ $application->phone ?: 'No phone number' }}</div>
                    </td>

                    <td>
                        <div class="application-date">
                            {{ $application->created_at->format('M d, Y') }}
                        </div>
                    </td>

                    <td>
                        <span class="status-badge status-{{ $statusClass }}">
                            {{ ucfirst($application->status) }}
                        </span>
                    </td>

                    <td>
                        <a
                            href="{{ route('admin.applications.show', $application) }}"
                            class="view-application-link"
                        >
                            View details →
                        </a>
                    </td>
                                    </tr>

                @if ($loop->last)
                        </tbody>
                    </table>
                @endif
            @empty
                <div class="empty-state">
                    <h2>No applications found</h2>
                    <p>New membership applications from the public TRAIL form will appear here.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection