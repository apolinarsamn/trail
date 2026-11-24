@extends('layouts.admin')

@section('title', 'Transaction History | TRAIL')

@push('styles')
    .history-page { max-width: 1300px; }

    .history-header {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 28px;
    }

    .history-header h1 { margin: 8px 0; }

    .history-header p {
        margin: 0;
        color: var(--muted);
    }

    .back-button {
        padding: 11px 16px;
        color: var(--forest);
        background: transparent;
        border: 1px solid var(--forest);
        border-radius: 999px;
        font-size: .8rem;
        font-weight: 800;
        text-decoration: none;
        white-space: nowrap;
    }

    .member-summary {
        display: grid;
        grid-template-columns: 1.4fr repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .summary-card {
        padding: 20px;
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 16px;
    }

    .summary-card span {
        display: block;
        margin-bottom: 7px;
        color: var(--muted);
        font-size: .68rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .summary-card strong {
        color: var(--forest);
        font-family: "Playfair Display", serif;
        font-size: 1.5rem;
    }

    .summary-card p {
        margin: 4px 0 0;
        color: var(--muted);
        font-size: .82rem;
    }

    .history-table-wrap {
        overflow-x: auto;
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 18px;
    }

    .history-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    .history-table th {
        padding: 15px 20px;
        color: var(--muted);
        background: #f1f2ec;
        font-size: .7rem;
        text-align: left;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .history-table td {
        padding: 17px 20px;
        border-top: 1px solid var(--line);
    }

    .reference-number {
        color: var(--forest);
        font-family: monospace;
        font-size: .82rem;
        font-weight: 800;
    }

    .status-badge {
        display: inline-flex;
        padding: 7px 10px;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 800;
        text-transform: capitalize;
    }

    .status-pending { color: #875b10; background: #fff3d6; }
    .status-paid { color: #075c4a; background: #d9f4ec; }
    .status-approved { color: #176b39; background: #e0f2e4; }
    .status-cancelled,
    .status-expired { color: #9e2520; background: #fde5e3; }

    .empty-state {
        padding: 70px 24px;
        text-align: center;
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 18px;
    }

    .empty-state h2 {
        margin-bottom: 8px;
        color: var(--forest);
        font-family: "Playfair Display", serif;
    }

    .empty-state p { color: var(--muted); }

    @media (max-width: 800px) {
        .history-header { align-items: stretch; flex-direction: column; }
        .member-summary { grid-template-columns: 1fr; }
    }
@endpush

@section('content')
    @php
        $totalPaid = $member->transactions->sum(
            fn ($transaction) => $transaction->payments->sum('amount')
        );
    @endphp

    <section class="history-page">
        <div class="history-header">
            <div>
                <p class="eyebrow">Member Record</p>
                <h1>Transaction history</h1>
                <p>Payment and membership activity for {{ $member->first_name }} {{ $member->last_name }}.</p>
            </div>

            <a href="{{ route('members.show', $member) }}" class="back-button">
                ← Back to member profile
            </a>
        </div>

        <div class="member-summary">
            <div class="summary-card">
                <span>TRAIL member</span>
                <strong>{{ $member->first_name }} {{ $member->last_name }}</strong>
                <p>{{ $member->membership_number }}</p>
            </div>

            <div class="summary-card">
                <span>Transactions</span>
                <strong>{{ $member->transactions->count() }}</strong>
                <p>Application and renewal records</p>
            </div>

            <div class="summary-card">
                <span>Total payments</span>
                <strong>₱{{ number_format($totalPaid, 2) }}</strong>
                <p>All recorded payments</p>
            </div>
        </div>

        @forelse ($member->transactions as $transaction)
            @if ($loop->first)
                <div class="history-table-wrap">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Transaction</th>
                                <th>Type</th>
                                <th>Amount due</th>
                                <th>Paid</th>
                                <th>Created</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
            @endif

            @php
                $paidAmount = $transaction->payments->sum('amount');

                $statusClass = in_array($transaction->status, ['paid', 'approved', 'expired', 'cancelled'])
                    ? $transaction->status
                    : 'pending';
            @endphp

            <tr>
                <td class="reference-number">{{ $transaction->reference_no }}</td>
                <td>{{ ucfirst($transaction->transaction_type) }}</td>
                <td>₱{{ number_format($transaction->amount, 2) }}</td>
                <td>₱{{ number_format($paidAmount, 2) }}</td>
                <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                <td>
                    <span class="status-badge status-{{ $statusClass }}">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </td>
            </tr>

            @if ($loop->last)
                        </tbody>
                    </table>
                </div>
            @endif
        @empty
            <div class="empty-state">
                <h2>No transaction history yet</h2>
                <p>Approved applications and future renewals will appear here.</p>
            </div>
        @endforelse
    </section>
@endsection