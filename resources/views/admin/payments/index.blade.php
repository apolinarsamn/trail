@extends('layouts.admin')

@section('title', 'Payments | TRAIL')

@push('styles')
    .payments-page { max-width: 1450px; }

    .payments-header {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 30px;
    }

    .payments-header h1 {
        margin: 8px 0;
    }

    .payments-header p {
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

    .payment-stats {
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

    .success-message {
        padding: 15px 18px;
        margin-bottom: 22px;
        color: #176b39;
        background: #e7f4e8;
        border: 1px solid #b6ddbb;
        border-radius: 12px;
        font-weight: 600;
    }

    .payments-table-wrap {
        overflow-x: auto;
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 18px;
    }

    .payments-table {
        width: 100%;
        min-width: 950px;
        border-collapse: collapse;
    }

    .payments-table th {
        padding: 15px 20px;
        color: var(--muted);
        background: #f1f2ec;
        font-size: .7rem;
        text-align: left;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .payments-table td {
        padding: 17px 20px;
        border-top: 1px solid var(--line);
        vertical-align: middle;
    }

    .payment-number,
    .transaction-number {
        color: var(--forest);
        font-family: monospace;
        font-size: .81rem;
        font-weight: 800;
    }

    .person-name {
        margin-bottom: 4px;
        color: var(--ink);
        font-weight: 800;
    }

    .subtle-text {
        color: var(--muted);
        font-size: .78rem;
    }

    .method-badge {
        display: inline-flex;
        padding: 7px 10px;
        color: #305743;
        background: #e8f0e3;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 800;
        text-transform: capitalize;
    }

        .receipt-link {
        display: inline-flex;
        padding: 9px 12px;
        color: var(--forest);
        background: transparent;
        border: 1px solid var(--forest);
        border-radius: 999px;
        font-size: .74rem;
        font-weight: 800;
        text-decoration: none;
        white-space: nowrap;
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
        .payments-header { align-items: stretch; flex-direction: column; }
        .payment-stats { grid-template-columns: 1fr; }
    }
@endpush

@section('content')
    <section class="payments-page">
        <div class="payments-header">
            <div>
                <p class="eyebrow">Transaction Processing</p>
                <h1>Payments</h1>
                <p>Record and review payments received for TRAIL membership transactions.</p>
            </div>

            <a href="{{ route('admin.payments.create') }}" class="primary-button">
                + Record payment
            </a>
        </div>

        <div class="payment-stats">
            <div class="stat-card">
                <span>Recorded payments</span>
                <strong>{{ $payments->count() }}</strong>
            </div>

            <div class="stat-card">
                <span>Total collected</span>
                <strong>₱{{ number_format($payments->sum('amount'), 2) }}</strong>
            </div>

            <div class="stat-card">
                <span>Collected today</span>
                <strong>₱{{ number_format($payments->filter(fn ($payment) => $payment->paid_at->isToday())->sum('amount'), 2) }}</strong>
            </div>
        </div>

        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <div class="payments-table-wrap">
            @forelse ($payments as $payment)
                @php
                    $personName = $payment->transaction?->application?->full_name
                        ?? trim(
                            ($payment->transaction?->member?->first_name ?? '')
                            . ' '
                            . ($payment->transaction?->member?->last_name ?? '')
                        )
                        ?: 'Unknown record';
                @endphp

                @if ($loop->first)
                    <table class="payments-table">
                        <thead>
                            <tr>
                                <th>Payment</th>
                                <th>Member / Applicant</th>
                                <th>Transaction</th>
                                <th>Method</th>
                                <th>Amount</th>
                                <th>Received on</th>
                                <th>Receipt</th>
                            </tr>
                        </thead>
                        <tbody>
                @endif

                <tr>
                    <td>
                        <div class="payment-number">{{ $payment->payment_no }}</div>
                        <div class="subtle-text">
                            {{ $payment->payment_reference ?: 'No external reference' }}
                        </div>
                    </td>

                    <td>
                        <div class="person-name">{{ $personName }}</div>
                        <div class="subtle-text">
                            {{ $payment->transaction?->application?->email ?? 'Existing TRAIL member' }}
                        </div>
                    </td>

                    <td>
                        <span class="transaction-number">
                            {{ $payment->transaction?->reference_no }}
                        </span>
                    </td>

                    <td>
                        <span class="method-badge">
                            {{ str_replace('_', ' ', $payment->payment_method) }}
                        </span>
                    </td>

                    <td>₱{{ number_format($payment->amount, 2) }}</td>

                    <td>{{ $payment->paid_at->format('M d, Y') }}</td>

                    <td>
                        <a
                            href="{{ route('admin.payments.receipt', $payment) }}"
                            class="receipt-link"
                        >
                            View receipt
                        </a>
                    </td>
                </tr>

                @if ($loop->last)
                        </tbody>
                    </table>
                @endif
            @empty
                <div class="empty-state">
                    <h2>No payments recorded</h2>
                    <p>Record the first payment for a pending TRAIL membership transaction.</p>

                    <a href="{{ route('admin.payments.create') }}" class="primary-button">
                        + Record first payment
                    </a>
                </div>
            @endforelse
        </div>
    </section>
@endsection