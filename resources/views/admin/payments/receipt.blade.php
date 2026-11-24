@extends('layouts.admin')

@section('title', 'Payment Receipt | TRAIL')

@push('styles')
    .receipt-page {
        max-width: 860px;
        margin: auto;
    }

    .receipt-actions {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 24px;
    }

    .back-button,
    .print-button {
        padding: 11px 16px;
        border-radius: 999px;
        font-size: .8rem;
        font-weight: 800;
        text-decoration: none;
        cursor: pointer;
    }

    .back-button {
        color: var(--forest);
        background: transparent;
        border: 1px solid var(--forest);
    }

    .print-button {
        color: #fff;
        background: var(--forest);
        border: 1px solid var(--forest);
    }

    .receipt {
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 22px;
    }

    .receipt-top {
        display: flex;
        justify-content: space-between;
        gap: 24px;
        padding: 34px;
        color: #fff;
        background: var(--forest);
    }

    .receipt-brand {
        margin: 0 0 5px;
        font-size: 1.65rem;
        font-weight: 800;
        letter-spacing: -.06em;
    }

    .receipt-top p {
        margin: 0;
        color: #d5e3cc;
        font-size: .8rem;
    }

    .receipt-title {
        margin: 0;
        font-family: "Playfair Display", serif;
        font-size: 2rem;
        text-align: right;
    }

    .receipt-content {
        padding: 34px;
    }

    .receipt-meta {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        padding-bottom: 24px;
        margin-bottom: 25px;
        border-bottom: 1px solid var(--line);
    }

    .receipt-meta span,
    .receipt-row span {
        display: block;
        margin-bottom: 5px;
        color: var(--muted);
        font-size: .68rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .receipt-meta strong {
        color: var(--forest);
        font-family: monospace;
        font-size: .91rem;
    }

    .recipient {
        margin-bottom: 27px;
    }

    .recipient h2 {
        margin: 5px 0;
        color: var(--forest);
        font-family: "Playfair Display", serif;
        font-size: 1.75rem;
    }

    .recipient p {
        margin: 0;
        color: var(--muted);
        font-size: .85rem;
    }

    .receipt-summary {
        padding: 22px;
        margin-bottom: 24px;
        background: #eef3e9;
        border-radius: 14px;
    }

    .receipt-summary span {
        display: block;
        margin-bottom: 8px;
        color: var(--muted);
        font-size: .7rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .receipt-summary strong {
        color: var(--forest);
        font-family: "Playfair Display", serif;
        font-size: 2.4rem;
    }

    .receipt-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 22px;
    }

    .receipt-row p {
        margin: 0;
        color: var(--ink);
        font-size: .9rem;
        font-weight: 600;
    }

    .receipt-footer {
        padding: 22px 34px;
        color: var(--muted);
        border-top: 1px solid var(--line);
        font-size: .77rem;
        text-align: center;
    }

    @media (max-width: 650px) {
        .receipt-top,
        .receipt-actions {
            flex-direction: column;
        }

        .receipt-title { text-align: left; }

        .receipt-meta,
        .receipt-details {
            grid-template-columns: 1fr;
        }
    }

    @media print {
        .admin-sidebar,
        .admin-topbar,
        .receipt-actions {
            display: none !important;
        }

        .admin-shell {
            display: block !important;
        }

        .admin-content {
            width: 100% !important;
            padding: 0 !important;
        }

        .receipt-page {
            max-width: none !important;
        }

        .receipt {
            border: 0 !important;
            border-radius: 0 !important;
        }
    }
@endpush

@section('content')
    @php
        $recipientName = $payment->transaction?->application?->full_name
            ?? trim(
                ($payment->transaction?->member?->first_name ?? '')
                . ' '
                . ($payment->transaction?->member?->last_name ?? '')
            )
            ?: 'TRAIL Member';

        $recipientEmail = $payment->transaction?->application?->email
            ?? $payment->transaction?->member?->email;
    @endphp

    <section class="receipt-page">
        <div class="receipt-actions">
            <a href="{{ route('admin.payments.index') }}" class="back-button">
                ← Back to payments
            </a>

            <button type="button" class="print-button" onclick="window.print()">
                Print receipt
            </button>
        </div>

        <article class="receipt">
            <div class="receipt-top">
                <div>
                    <h1 class="receipt-brand">TRAIL</h1>
                    <p>Outdoor Recreation Membership System</p>
                </div>

                <div>
                    <h2 class="receipt-title">Payment Receipt</h2>
                </div>
            </div>

            <div class="receipt-content">
                <div class="receipt-meta">
                    <div>
                        <span>Receipt number</span>
                        <strong>{{ $payment->payment_no }}</strong>
                    </div>

                    <div>
                        <span>Payment date</span>
                        <strong>{{ $payment->paid_at->format('F d, Y') }}</strong>
                    </div>
                </div>

                <div class="recipient">
                    <span class="eyebrow">Received from</span>
                    <h2>{{ $recipientName }}</h2>
                    <p>{{ $recipientEmail }}</p>
                </div>

                <div class="receipt-summary">
                    <span>Amount received</span>
                    <strong>₱{{ number_format($payment->amount, 2) }}</strong>
                </div>

                <div class="receipt-details">
                    <div class="receipt-row">
                        <span>Transaction reference</span>
                        <p>{{ $payment->transaction?->reference_no }}</p>
                    </div>

                    <div class="receipt-row">
                        <span>Payment method</span>
                        <p>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                    </div>

                    <div class="receipt-row">
                        <span>External reference</span>
                        <p>{{ $payment->payment_reference ?: 'Not provided' }}</p>
                    </div>

                    <div class="receipt-row">
                        <span>Transaction type</span>
                        <p>{{ ucfirst($payment->transaction?->transaction_type) }}</p>
                    </div>
                </div>

                @if ($payment->notes)
                    <div class="receipt-row" style="margin-top: 24px;">
                        <span>Notes</span>
                        <p>{{ $payment->notes }}</p>
                    </div>
                @endif
            </div>

            <footer class="receipt-footer">
                This is a system-generated TRAIL payment receipt.
            </footer>
        </article>
    </section>
@endsection