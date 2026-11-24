@extends('layouts.admin')

@section('title', 'Members | TRAIL')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Members</h1>
            <p class="text-muted mb-0">Manage registered TRAIL members.</p>
        </div>

        <a href="{{ route('members.create') }}" class="btn btn-brand">
            + Register Member
        </a>
    </div>

    <div class="card page-card mb-4">
        <div class="card-body">
            <form action="{{ route('members.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search name, email, or member number"
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach (['Student', 'Regular', 'Senior Citizen', 'Corporate'] as $category)
                            <option value="{{ $category }}" @selected(request('category') === $category)>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="level" class="form-select">
                        <option value="">All Levels</option>
                        @foreach (['Basic', 'Silver', 'Gold', 'Platinum'] as $level)
                            <option value="{{ $level }}" @selected(request('level') === $level)>
                                {{ $level }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-brand">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card page-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Member No.</th>
                            <th>Member</th>
                            <th>Category</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($members as $member)
                            <tr>
                                <td class="ps-4 fw-semibold">{{ $member->membership_number }}</td>
                                <td>
                                    <div class="fw-semibold">
                                        {{ $member->first_name }} {{ $member->last_name }}
                                    </div>
                                    <small class="text-muted">{{ $member->email }}</small>
                                </td>
                                <td>{{ $member->membership_category }}</td>
                                <td>{{ $member->membership_level }}</td>
                                <td>
                                    <span class="badge {{ $member->status === 'Active' ? 'text-bg-success' : 'text-bg-secondary' }}">
                                        {{ $member->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('members.show', $member) }}" class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>

                                    <a href="{{ route('members.history', $member) }}" class="btn btn-outline-success btn-sm">
                                        History
                                    </a>

                                    <a href="{{ route('members.edit', $member) }}" class="btn btn-sm btn-outline-secondary">
                                        Edit
                                    </a>

                                    @if ($member->status === 'Active')
                                        <form action="{{ route('members.destroy', $member) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Deactivate this member?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Deactivate
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    No members found. Click “Register Member” to add your first member.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $members->links() }}
    </div>
@endsection