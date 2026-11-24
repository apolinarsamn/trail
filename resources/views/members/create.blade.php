@extends('layouts.admin')


@section('title', 'Register Member | TRAIL')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Register Member</h1>
            <p class="text-muted mb-0">
                Add a new member to the TRAIL membership system.
            </p>
        </div>

        <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">
            ← Back to Members
        </a>
    </div>

    <div class="card page-card">
        <div class="card-body p-4">
            <form action="{{ route('members.store') }}" method="POST">
                @csrf

                @include('members._form', [
                    'member' => $member,
                    'buttonText' => 'Register Member'
                ])
            </form>
        </div>
    </div>
@endsection