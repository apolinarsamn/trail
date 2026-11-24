@extends('layouts.admin')

@section('title', 'Edit Membership Level | TRAIL')

@section('content')
    <section>
        <div style="margin-bottom: 30px;">
            <p class="eyebrow">Membership Setup</p>
            <h1 style="margin: 8px 0;">Edit {{ $level->name }}</h1>
            <p style="margin: 0; color: var(--muted);">
                Update the membership fee, validity period, benefits, or availability.
            </p>
        </div>

        @include('admin.levels._form', [
            'action' => route('admin.levels.update', $level),
            'method' => 'PUT',
            'submitLabel' => 'Save changes',
        ])
    </section>
@endsection