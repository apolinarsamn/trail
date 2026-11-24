@extends('layouts.admin')

@section('title', 'Create Transaction | TRAIL')

@push('styles')
    .transaction-form-page { max-width: 980px; }

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

    .transaction-form-card {
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
    .form-group select {
        width: 100%;
        padding: 13px 14px;
        color: var(--ink);
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 10px;
        outline: none;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: var(--forest);
        box-shadow: 0 0 0 3px rgba(22, 58, 43, .12);
    }

    .form-help {
        margin: 0;
        color: var(--muted);
        font-size: .78rem;
        line-height: 1.5;
    }

    .source-panel {
        grid-column: 1 / -1;
        padding: 20px;
        background: #f1f4ee;
        border: 1px solid var(--line);
        border-radius: 14px;
    }

    .source-panel[hidden] {
        display: none;
    }

    .source-panel h2 {
        margin: 0 0 6px;
        color: var(--forest);
        font-family: "Playfair Display", serif;
        font-size: 1.3rem;
    }

    .source-panel > p {
        margin: 0 0 16px;
        color: var(--muted);
        font-size: .83rem;
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
        .source-panel {
            grid-column: auto;
        }
    }
@endpush

@section('content')
    <section class="transaction-form-page">
        <div class="form-header">
            <div>
                <p class="eyebrow">Transaction Processing</p>
                <h1>Create transaction</h1>
                <p>Create a payable membership application or renewal record.</p>
            </div>

            <a href="{{ route('admin.transactions.index') }}" class="back-button">
                ← Back to transactions
            </a>
        </div>

        <div class="transaction-form-card">
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

            <form action="{{ route('admin.transactions.store') }}" method="POST">
                @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <label for="transaction_type">Transaction type</label>

                        <select id="transaction_type" name="transaction_type" required>
                            <option value="application" @selected(old('transaction_type', 'application') === 'application')>
                                New membership application
                            </option>

                            <option value="renewal" @selected(old('transaction_type') === 'renewal')>
                                Membership renewal
                            </option>
                        </select>

                        <p class="form-help">
                            Choose whether this payment is for a new applicant or an existing member.
                        </p>
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount due (₱)</label>

                        <input
                            type="number"
                            id="amount"
                            name="amount"
                            value="{{ old('amount') }}"
                            min="0"
                            step="0.01"
                            placeholder="e.g. 500.00"
                            required
                        >

                        <p class="form-help">
                            Enter the membership fee to be collected for this transaction.
                        </p>
                    </div>

                    <div id="application-source" class="source-panel">
                        <h2>Choose an applicant</h2>
                        <p>Select a public TRAIL application that does not have a transaction yet.</p>

                        <div class="form-group">
                            <label for="membership_application_id">Membership application</label>

                            <select id="membership_application_id" name="membership_application_id">
                                <option value="">Choose an applicant</option>

                                @foreach ($applications as $application)
                                    <option
                                        value="{{ $application->id }}"
                                        @selected(old('membership_application_id') == $application->id)
                                    >
                                        {{ $application->full_name }}
                                        — {{ $application->reference_no }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="renewal-source" class="source-panel" hidden>
                        <h2>Choose an active member</h2>
                        <p>Select the TRAIL member whose membership is being renewed.</p>

                        <div class="form-group">
                            <label for="member_id">TRAIL member</label>

                            <select id="member_id" name="member_id">
                                <option value="">Choose a member</option>

                                @foreach ($members as $member)
                                    <option
                                        value="{{ $member->id }}"
                                        @selected(old('member_id') == $member->id)
                                    >
                                        {{ $member->first_name }} {{ $member->last_name }}
                                        — {{ $member->membership_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.transactions.index') }}" class="back-button">
                        Cancel
                    </a>

                    <button type="submit" class="save-button">
                        Create pending transaction →
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const transactionType = document.getElementById('transaction_type');
        const applicationSource = document.getElementById('application-source');
        const renewalSource = document.getElementById('renewal-source');
        const applicationSelect = document.getElementById('membership_application_id');
        const memberSelect = document.getElementById('member_id');

        function updateTransactionSource() {
            const isApplication = transactionType.value === 'application';

            applicationSource.hidden = !isApplication;
            renewalSource.hidden = isApplication;

            applicationSelect.required = isApplication;
            memberSelect.required = !isApplication;
        }

        transactionType.addEventListener('change', updateTransactionSource);
        updateTransactionSource();
    </script>
@endpush