@extends('layouts.admin')

@section('title', 'Member Profile | TRAIL')

@section('content')
    @php
        $fullName = trim($member->first_name . ' ' . $member->middle_name . ' ' . $member->last_name);
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Member Profile</h1>
            <p class="text-muted mb-0">View registered member details.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">
                ← Back to Members
            </a>

            <a href="{{ route('members.edit', $member) }}" class="btn btn-brand">
                Edit Member
            </a>
        </div>
    </div>

    <div class="card page-card">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start border-bottom pb-4 mb-4">
                <div>
                    <p class="text-muted mb-1">Membership Number</p>
                    <h3 class="fw-bold mb-2">{{ $member->membership_number }}</h3>
                    <h4 class="mb-0">{{ $fullName }}</h4>
                </div>

                <span class="badge fs-6 {{ $member->status === 'Active' ? 'text-bg-success' : 'text-bg-secondary' }}">
                    {{ $member->status }}
                </span>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <p class="text-muted mb-1">Email Address</p>
                    <p class="fw-semibold">{{ $member->email }}</p>
                </div>

                <div class="col-md-6">
                    <p class="text-muted mb-1">Phone Number</p>
                    <p class="fw-semibold">{{ $member->phone_number ?: 'Not provided' }}</p>
                </div>

                <div class="col-md-6">
                    <p class="text-muted mb-1">Membership Category</p>
                    <p class="fw-semibold">{{ $member->membership_category }}</p>
                </div>

                <div class="col-md-6">
                    <p class="text-muted mb-1">Membership Level</p>
                    <p class="fw-semibold">{{ $member->membership_level }}</p>
                </div>

                <div class="col-md-6">
                    <p class="text-muted mb-1">Birth Date</p>
                    <p class="fw-semibold">
                        {{ $member->birth_date ? \Carbon\Carbon::parse($member->birth_date)->format('F d, Y') : 'Not provided' }}
                    </p>
                </div>

                <div class="col-md-6">
                    <p class="text-muted mb-1">Registered On</p>
                    <p class="fw-semibold">{{ $member->created_at->format('F d, Y') }}</p>
                </div>

                <div class="col-12">
                    <p class="text-muted mb-1">Address</p>
                    <p class="fw-semibold mb-0">{{ $member->address ?: 'Not provided' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection