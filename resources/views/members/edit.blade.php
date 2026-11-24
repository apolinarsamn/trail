@extends('layouts.admin')

@section('title', 'Edit Member | TRAIL')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Edit Member</h1>
            <p class="text-muted mb-0">
                Update details for {{ $member->first_name }} {{ $member->last_name }}.
            </p>
        </div>

        <a href="{{ route('members.show', $member) }}" class="btn btn-outline-secondary">
            ← Back to Profile
        </a>
    </div>

    <div class="card page-card">
        <div class="card-body p-4">
            <form action="{{ route('members.update', $member) }}" method="POST">
                @csrf
                @method('PUT')

                @include('members._form', [
                    'member' => $member,
                    'buttonText' => 'Save Changes'
                ])
            </form>
        </div>
    </div>
@endsection