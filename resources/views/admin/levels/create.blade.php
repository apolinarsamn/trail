@extends('layouts.admin')

@section('title', 'Add Membership Level | TRAIL')

@section('content')
    <section>
        <div style="margin-bottom: 30px;">
            <p class="eyebrow">Membership Setup</p>
            <h1 style="margin: 8px 0;">Add membership level</h1>
            <p style="margin: 0; color: var(--muted);">
                Define the annual fee, membership duration, and benefits for a TRAIL level.
            </p>
        </div>

        @include('admin.levels._form', [
            'action' => route('admin.levels.store'),
            'method' => 'POST',
            'submitLabel' => 'Save membership level',
        ])
    </section>
@endsection