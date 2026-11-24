@extends('layouts.admin')

@section('title', 'Transactions | TRAIL')

@push('styles')
    .transactions-page {
        max-width: 1450px;
    }

    .transactions-header {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 30px;
    }

    .transactions-header h1 {
        margin: 8px 0;
    }

    .transactions-header p {
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
        white-space: nowrap;
    }

    .transaction-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        padding: 18px 20px;
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 16px;
    }

    .stat-card span {
        display: block;
        margin-bottom: 7px;
        color: var(--muted);
        font-size: .69rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .stat-card strong {
        color: var(--forest);
        font-family: "Playfair Display", serif;
        font-size: 1.8rem;
    }

    .transaction-filters {
        display: grid;
        grid-template-columns: minmax(230px, 1fr) 210px auto;
        gap: 12px;
        padding: 16px;
        margin-bottom: 24px;
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 18px;
    }

    .transaction-filters input,
    .transaction-filters select {
        width: 100%;
        padding: 12px 14px;
        color: var(--ink);
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 10px;
        outline: none;
    }

    .filter-button {
        padding: 12px 21px;
        color: #fff;
        background: var(--forest);
        border: 0;
        border-radius: 10px;
        font-weight: 800;
        cursor: pointer;
    }

    .success-message,
    .error-message {
        padding: 15px 18px;
        margin-bottom: 22px;
        border-radius: 12px;
        font-weight: 600;
    }

    .success-message {
        color: #176b39;
        background: #e7f4e8;
        border: 1px solid #b6ddbb;
    }

    .error-message {
        color: #842029;
        background: #fff3f3;
        border: 1px solid #f1b9b7;
    }

    .transactions-table-wrap {
        overflow-x: auto;
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 18px;
    }

    .transactions-table {
        width: 100%;
        min-width: 1050px;
        border-collapse: collapse;
    }

    .transactions-table th {
        padding: 15px 20px;
        color: var(--muted);
        background: #f1f2ec;
        font-size: .7rem;
        text-align: left;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .transactions-table td {
        padding: 17px 20px;
        border-top: 1px solid var(--line);
        vertical-align: middle;
    }

    .reference-number {
        color: var(--forest);
        font-family: monospace;
        font-size: .82rem;
        font-weight: 800;
    }

    .member-name {
        margin-bottom: 4px;
        color: var(--ink);
        font-weight: 800;
    }

    .subtle-text {
        color: var(--muted);
        font-size: .78rem;
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

    .transaction-action-group {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
    }

    .approve-button,
    .record-payment-link,
    .cancel-button,
    .expire-button {
        padding: 8px 10px;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 800;
        text-decoration: none;
        cursor: pointer;
        white-space: nowrap;
    }

    .approve-button,
    .record-payment-link {
        color: #176b39;
        background: #e0f2e4;
        border: 1px solid #9dccaa;
    }

    .cancel-button {
        color: #b42318;
        background: #fff;
        border: 1px solid #efaaa5;
    }

    .expire-button {
        color: #875b10;
        background: #fff3d6;
        border: 1px solid #f0d18c;
    }

    .completed-label {
        color: #176b39;
        font-size: .75rem;
        font-weight: 800;
    }

    .empty-state {
        padding: 70px 24px;
        text-align: center;
    }

    .empty-state h2 {
        margin-bottom: 8px;
        color: var(--forest);
        font-family: "Playfair Display", serif;
    }

    .empty-state p {
        margin: 0 0 20px;
        color: var(--muted);
    }

    @media (max-width: 800px) {
        .transactions-header {
            align-items: stretch;
            flex-direction: column;
        }

        .transaction-stats,
        .transaction-filters {
            grid-template-columns: 1fr;
        }
    }
@endpush

@section('content')
    <section class="transactions-page">
        <div class="transactions-header">
            <div>
                <p class="eyebrow">Transaction Processing</p>
                <h1>Transactions</h1>
                <p>Track application fees, renewals, payment progress, and membership approval status.</p>
            </div>

            <a href="{{ route('admin.transactions.create') }}" class="primary-button">
                + Create transaction
            </a>
        </div>

        <div class="transaction-stats">
            <div class="stat-card">
                <span>Total transactions</span>
                <strong>{{ $transactions->count() }}</strong>
            </div>

            <div class="stat-card">
                <span>Pending payment</span>
                <strong>{{ $transactions->where('status', 'pending')->count() }}</strong>
            </div>

            <div class="stat-card">
                <span>Outstanding value</span>
                <strong>₱{{ number_format($transactions->where('status', 'pending')->sum('amount'), 2) }}</strong>
            </div>
        </div>

        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.transactions.index') }}" method="GET" class="transaction-filters">
            <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search reference, applicant, or member"
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

        @if ($transactions->isEmpty())
            <div class="transactions-table-wrap">
                <div class="empty-state">
                    <h2>No transactions yet</h2>
                    <p>Create an application or renewal transaction to begin recording membership payments.</p>

                    <a href="{{ route('admin.transactions.create') }}" class="primary-button">
                        + Create first transaction
                    </a>
                </div>
            </div>
        @else
            <div class="transactions-table-wrap">
                <table class="transactions-table">
                    <thead>
                        <tr>
                            <th>Transaction</th>
                            <th>Member / Applicant</th>
                            <th>Type</th>
                            <th>Amount due</th>
                            <th>Payments received</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($transactions as $transaction)
                            @php
                                $memberName = trim(
                                    ($transaction->member?->first_name ?? '')
                                    . ' '
                                    . ($transaction->member?->last_name ?? '')
                                );

                                $personName = $transaction->application?->full_name
                                    ?: ($memberName ?: 'Unknown record');

                                $paidAmount = $transaction->payments->sum('amount');

                                $statusClass = in_array(
                                    $transaction->status,
                                    ['paid', 'approved', 'expired', 'cancelled']
                                )
                                    ? $transaction->status
                                    : 'pending';
                            @endphp

                            <tr>
                                <td>
                                    <div class="reference-number">
                                        {{ $transaction->reference_no }}
                                    </div>

                                    <div class="subtle-text">
                                        {{ $transaction->created_at->format('M d, Y') }}
                                    </div>
                                </td>

                                <td>
                                    <div class="member-name">{{ $personName }}</div>

                                    <div class="subtle-text">
                                        {{ $transaction->application?->email ?? 'Existing TRAIL member' }}
                                    </div>
                                </td>

                                <td>{{ ucfirst($transaction->transaction_type) }}</td>

                                <td>₱{{ number_format($transaction->amount, 2) }}</td>

                                <td>₱{{ number_format($paidAmount, 2) }}</td>

                                <td>
                                    <span class="status-badge status-{{ $statusClass }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>

                                <td>
                                    @if ($transaction->status === 'paid')
                                        <form
                                            action="{{ route('admin.transactions.approve', $transaction) }}"
                                            method="POST"
                                            onsubmit="return confirm('Approve this paid transaction?');"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="approve-button">
                                                Approve membership
                                            </button>
                                        </form>

                                    @elseif ($transaction->status === 'pending')
                                        <div class="transaction-action-group">
                                            <a
                                                href="{{ route('admin.payments.create') }}"
                                                class="record-payment-link"
                                            >
                                                Record payment
                                            </a>

                                            <form
                                                action="{{ route('admin.transactions.cancel', $transaction) }}"
                                                method="POST"
                                                onsubmit="return confirm('Cancel this pending transaction?');"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" class="cancel-button">
                                                    Cancel
                                                </button>
                                            </form>

                                            <form
                                                action="{{ route('admin.transactions.expire', $transaction) }}"
                                                method="POST"
                                                onsubmit="return confirm('Mark this transaction as expired?');"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" class="expire-button">
                                                    Expire
                                                </button>
                                            </form>
                                        </div>

                                    @elseif ($transaction->status === 'approved')
                                        <span class="completed-label">Approved</span>

                                    @elseif ($transaction->status === 'cancelled')
                                        <span class="completed-label">Cancelled</span>

                                    @else
                                        <span class="completed-label">Expired</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection