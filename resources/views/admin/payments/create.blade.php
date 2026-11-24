@extends('layouts.admin')

@section('title', 'Record Payment | TRAIL')

@push('styles')
    .payment-form-page { max-width: 980px; }

    .form-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 30px;
    }

    .form-header h1 { margin: 8px 0; }

    .form-header p {
        margin: 0;
        color: var(--muted);
    }

    .back-button,
    .save-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 18px;
        border-radius: 999px;
        font-size: .82rem;
        font-weight: 800;
        text-decoration: none;
        cursor: pointer;
    }

    .back-button {
        color: var(--forest);
        border: 1px solid var(--forest);
        background: transparent;
        white-space: nowrap;
    }

    .save-button {
        color: #fff;
        border: 1px solid var(--forest);
        background: var(--forest);
    }

    .payment-form-card {
        padding: 34px;
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 20px;
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

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        color: var(--ink);
        font-size: .82rem;
        font-weight: 800;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 13px 14px;
        color: var(--ink);
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 10px;
        outline: none;
    }

    .form-group textarea {
        min-height: 105px;
        resize: vertical;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: var(--forest);
        box-shadow: 0 0 0 3px rgba(22, 58, 43, .12);
    }

    .form-help {
        margin: 0;
        color: var(--muted);
        font-size: .78rem;
        line-height: 1.5;
    }

    .balance-notice {
        grid-column: 1 / -1;
        padding: 17px 19px;
        color: var(--forest);
        background: #edf3e9;
        border: 1px solid #d6e3cd;
        border-radius: 13px;
    }

    .balance-notice span {
        display: block;
        margin-bottom: 4px;
        color: var(--muted);
        font-size: .71rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .balance-notice strong {
        font-family: "Playfair Display", serif;
        font-size: 1.55rem;
    }

    .validation-box {
        padding: 15px 18px;
        margin-bottom: 24px;
        color: #842029;
        background: #fff3f3;
        border: 1px solid #f1b9b7;
        border-radius: 12px;
    }

    .validation-box ul {
        margin: 8px 0 0;
        padding-left: 20px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 30px;
        padding-top: 24px;
        border-top: 1px solid var(--line);
    }

    .empty-payment-state {
        padding: 35px;
        text-align: center;
        background: #f1f4ee;
        border-radius: 14px;
    }

    .empty-payment-state h2 {
        margin-bottom: 8px;
        color: var(--forest);
        font-family: "Playfair Display", serif;
    }

    .empty-payment-state p {
        margin-bottom: 20px;
        color: var(--muted);
    }

    @media (max-width: 700px) {
        .form-header,
        .form-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full-width,
        .balance-notice {
            grid-column: auto;
        }
    }
@endpush

@section('content')
    <section class="payment-form-page">
        <div class="form-header">
            <div>
                <p class="eyebrow">Transaction Processing</p>
                <h1>Record payment</h1>
                <p>Record a verified payment against a pending TRAIL transaction.</p>
            </div>

            <a href="{{ route('admin.payments.index') }}" class="back-button">
                ← Back to payments
            </a>
        </div>

        <div class="payment-form-card">
            @if ($transactions->isEmpty())
                <div class="empty-payment-state">
                    <h2>No pending transactions</h2>
                    <p>Create a membership transaction before recording a payment.</p>

                    <a href="{{ route('admin.transactions.create') }}" class="save-button">
                        Create transaction →
                    </a>
                </div>
            @else
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

                <form action="{{ route('admin.payments.store') }}" method="POST">
                    @csrf

                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="membership_transaction_id">Pending transaction</label>

                            <select id="membership_transaction_id" name="membership_transaction_id" required>
                                <option value="">Choose a transaction</option>

                                @foreach ($transactions as $transaction)
                                    @php
                                        $paidAmount = $transaction->payments->sum('amount');
                                        $remainingAmount = $transaction->amount - $paidAmount;

                                        $personName = $transaction->application?->full_name
                                            ?? trim(
                                                ($transaction->member?->first_name ?? '')
                                                . ' '
                                                . ($transaction->member?->last_name ?? '')
                                            )
                                            ?: 'Unknown record';
                                    @endphp

                                    <option
                                        value="{{ $transaction->id }}"
                                        data-remaining="{{ $remainingAmount }}"
                                        @selected(old('membership_transaction_id') == $transaction->id)
                                    >
                                        {{ $transaction->reference_no }}
                                        — {{ $personName }}
                                        — ₱{{ number_format($remainingAmount, 2) }} remaining
                                    </option>
                                @endforeach
                            </select>

                            <p class="form-help">
                                Only transactions with a pending balance can receive a payment.
                            </p>
                        </div>

                        <div class="balance-notice">
                            <span>Remaining balance</span>
                            <strong id="remaining-balance">Choose a transaction</strong>
                        </div>

                        <div class="form-group">
                            <label for="amount">Payment amount (₱)</label>

                            <input
                                type="number"
                                id="amount"
                                name="amount"
                                value="{{ old('amount') }}"
                                min="0.01"
                                step="0.01"
                                placeholder="e.g. 500.00"
                                required
                            >

                            <p class="form-help">The amount cannot exceed the remaining balance.</p>
                        </div>

                        <div class="form-group">
                            <label for="payment_method">Payment method</label>

                            <select id="payment_method" name="payment_method" required>
                                <option value="">Choose a payment method</option>
                                @foreach ([
                                    'cash' => 'Cash',
                                    'gcash' => 'GCash',
                                    'bank_transfer' => 'Bank transfer',
                                    'card' => 'Card',
                                ] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('payment_method') === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="payment_reference">External payment reference</label>

                            <input
                                type="text"
                                id="payment_reference"
                                name="payment_reference"
                                value="{{ old('payment_reference') }}"
                                placeholder="Optional GCash / bank reference"
                            >
                        </div>

                        <div class="form-group">
                            <label for="paid_at">Payment date</label>

                            <input
                                type="date"
                                id="paid_at"
                                name="paid_at"
                                value="{{ old('paid_at', now()->format('Y-m-d')) }}"
                                required
                            >
                        </div>

                        <div class="form-group full-width">
                            <label for="notes">Internal notes</label>

                            <textarea
                                id="notes"
                                name="notes"
                                placeholder="Optional verification notes for the administrator"
                            >{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.payments.index') }}" class="back-button">
                            Cancel
                        </a>

                        <button type="submit" class="save-button">
                            Record payment →
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const transactionSelect = document.getElementById('membership_transaction_id');
        const amountInput = document.getElementById('amount');
        const remainingBalance = document.getElementById('remaining-balance');

        function updateRemainingBalance() {
            const selectedOption = transactionSelect.options[transactionSelect.selectedIndex];
            const remaining = selectedOption?.dataset.remaining;

            if (!remaining) {
                remainingBalance.textContent = 'Choose a transaction';
                amountInput.removeAttribute('max');
                return;
            }

            const formattedAmount = Number(remaining).toLocaleString('en-PH', {
                style: 'currency',
                currency: 'PHP',
            });

            remainingBalance.textContent = formattedAmount;
            amountInput.max = remaining;

            if (!amountInput.value || Number(amountInput.value) > Number(remaining)) {
                amountInput.value = Number(remaining).toFixed(2);
            }
        }

        transactionSelect.addEventListener('change', updateRemainingBalance);
        updateRemainingBalance();
    </script>
@endpush