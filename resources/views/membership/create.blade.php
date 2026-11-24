@extends('layouts.public')

@section('title', 'Join TRAIL — Outdoor Membership')

@php
    $planContent = [
        'Student' => [
            'title' => 'Student Explorer',
            'label' => 'Starter membership',
            'description' => 'For students beginning their outdoor recreation journey.',
            'benefits' => [
                'Digital TRAIL membership profile',
                'Beginner trail and safety briefings',
                'Student-rate community activities',
            ],
        ],
        'Regular' => [
            'title' => 'Trail Explorer',
            'label' => 'Individual membership',
            'description' => 'For weekend hikers, campers, and nature enthusiasts.',
            'benefits' => [
                'Digital TRAIL membership profile',
                'Early notice for TRAIL activities',
                'Member rates and trail weather updates',
            ],
        ],
        'Senior Citizen' => [
            'title' => 'Senior Explorer',
            'label' => 'Active community membership',
            'description' => 'For active seniors who enjoy nature and shared experiences.',
            'benefits' => [
                'Digital TRAIL membership profile',
                'Senior-friendly activity notices',
                'Hosted group walks and safety updates',
            ],
        ],
        'Corporate' => [
            'title' => 'Adventure Team',
            'label' => 'Group membership',
            'description' => 'For organizations planning outdoor wellness and team activities.',
            'benefits' => [
                'Up to five named team members',
                'Team activity coordination',
                'Consolidated payment record',
            ],
        ],
    ];
@endphp

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

 <style>
    :root {
        --forest: #163a2b;
        --moss: #54724f;
        --cream: #f5f2ec;
        --paper: #fffefa;
        --ink: #1b2920;
        --muted: #69736b;
        --line: #d9dfd3;
        --white: #ffffff;
        --danger: #b42318;
    }

    .public-container {
        width: min(1180px, calc(100% - 48px));
        margin: 0 auto;
    }

    .public-page {
        padding: 58px 0 84px;
    }

    .application-header {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 34px;
    }

    .public-kicker {
        margin: 0 0 10px;
        color: var(--moss);
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
    }

    .public-title {
        margin: 0;
        color: var(--forest);
        font-family: "Playfair Display", serif;
        font-size: clamp(2.5rem, 5vw, 4.8rem);
        font-weight: 500;
        letter-spacing: -0.06em;
        line-height: 0.95;
    }

    .public-description,
    .public-section-description {
        color: var(--muted);
        line-height: 1.7;
    }

    .public-description {
        max-width: 540px;
        margin: 16px 0 0;
        font-size: 1rem;
    }

    .public-section-title {
        margin: 0;
        color: var(--forest);
        font-family: "Playfair Display", serif;
        font-size: 2rem;
        font-weight: 500;
        letter-spacing: -0.04em;
    }

    .public-section-description {
        max-width: 580px;
        margin: 10px 0 24px;
        font-size: 0.92rem;
    }

    .public-outline-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 16px;
        border: 1px solid var(--forest);
        border-radius: 999px;
        background: transparent;
        color: var(--forest);
        font-size: 0.82rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .public-outline-btn:hover {
        background: var(--forest);
        color: var(--white);
    }

    .public-form-surface {
        padding: clamp(24px, 4vw, 48px);
        border: 1px solid var(--line);
        border-radius: 24px;
        background: var(--paper);
        box-shadow: 0 18px 50px rgba(22, 58, 43, 0.07);
    }

    .trail-steps {
        display: flex;
        gap: 20px;
        margin: 0 0 36px;
        padding-bottom: 18px;
        border-bottom: 1px solid var(--line);
    }

    .trail-step {
        display: flex;
        align-items: center;
        gap: 9px;
        color: var(--muted);
        font-size: 0.78rem;
    }

    .trail-step span {
        display: grid;
        width: 28px;
        height: 28px;
        place-items: center;
        border: 1px solid var(--line);
        border-radius: 50%;
        font-size: 0.72rem;
    }

    .trail-step.active {
        color: var(--ink);
        font-weight: 700;
    }

    .trail-step.active span {
        border-color: var(--forest);
        background: var(--forest);
        color: var(--white);
    }

    .trail-step-panel[hidden] {
        display: none;
    }

    .plan-picker {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }

    .plan-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .plan-card {
        display: block;
        min-height: 210px;
        padding: 22px;
        border: 1px solid var(--line);
        border-radius: 14px;
        background: var(--cream);
        cursor: pointer;
        transition: 0.2s ease;
    }

    .plan-card:hover {
        transform: translateY(-2px);
        border-color: var(--moss);
    }

    .plan-option input:checked + .plan-card {
        border: 2px solid var(--forest);
        background: #eef4ec;
    }

    .plan-label {
        color: var(--moss);
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .plan-card h3 {
        margin: 12px 0 8px;
        color: var(--forest);
        font-family: "Playfair Display", serif;
        font-size: 1.65rem;
        font-weight: 500;
        letter-spacing: -0.05em;
    }

    .plan-card p {
        margin: 0;
        color: var(--muted);
        font-size: 0.83rem;
        line-height: 1.55;
    }

    .plan-meta {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-top: 25px;
        color: var(--forest);
        font-size: 0.8rem;
        font-weight: 700;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .form-group {
        display: grid;
        gap: 8px;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        color: var(--ink);
        font-size: 0.82rem;
        font-weight: 700;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        border: 1px solid var(--line);
        border-radius: 8px;
        padding: 13px 14px;
        background: var(--cream);
        color: var(--ink);
        font: inherit;
    }

    .form-group textarea {
        min-height: 120px;
        resize: vertical;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: 2px solid #b9d1ba;
        border-color: var(--moss);
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        margin-top: 34px;
    }

    .form-actions.end {
        justify-content: end;
    }

    .step-button {
        display: inline-flex;
        min-height: 44px;
        align-items: center;
        justify-content: center;
        padding: 0 20px;
        border: 1px solid var(--forest);
        border-radius: 999px;
        background: var(--forest);
        color: var(--white);
        cursor: pointer;
        font: inherit;
        font-size: 0.82rem;
        font-weight: 700;
    }

    .step-button:hover {
        background: #0f2a1f;
    }

    .step-button:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }

    .back-button {
        background: transparent;
        color: var(--forest);
    }

    .back-button:hover {
        background: #eef3ec;
        color: var(--forest);
    }

    .map-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.45fr) minmax(280px, 0.55fr);
        gap: 20px;
    }

    #trail-map {
        height: 410px;
        overflow: hidden;
        border: 1px solid var(--line);
        border-radius: 14px;
    }

    .weather-panel {
        display: flex;
        min-height: 410px;
        flex-direction: column;
        justify-content: space-between;
        padding: 27px;
        border-radius: 14px;
        background: var(--forest);
        color: var(--white);
    }

    .weather-label {
        color: #b8d0b9;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.13em;
        text-transform: uppercase;
    }

    .weather-place {
        margin-top: 23px;
        font-size: 1rem;
        font-weight: 700;
    }

    .weather-temp {
        margin: 17px 0 3px;
        font-size: 3.3rem;
        font-weight: 700;
        letter-spacing: -0.06em;
    }

    .weather-description {
        color: #e2ede2;
        font-size: 0.95rem;
        text-transform: capitalize;
    }

    .weather-footer {
        padding-top: 18px;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        color: rgba(255, 255, 255, 0.78);
        font-size: 0.82rem;
    }

    .coordinates {
        margin: 12px 0 0;
        color: var(--muted);
        font-size: 0.78rem;
    }

    .plan-error {
        margin-top: 16px;
        color: var(--danger);
        font-size: 0.82rem;
    }

    @media (max-width: 800px) {
        .application-header {
            align-items: start;
            flex-direction: column;
        }

        .plan-picker,
        .form-grid,
        .map-layout {
            grid-template-columns: 1fr;
        }

        .weather-panel {
            min-height: 280px;
        }
    }

    @media (max-width: 520px) {
        .public-container {
            width: min(100% - 28px, 1180px);
        }

        .public-page {
            padding-top: 38px;
        }

        .trail-steps {
            gap: 12px;
        }

        .trail-step {
            flex: 1;
        }

        .trail-step:not(.active) {
            font-size: 0;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .step-button {
            width: 100%;
        }
    }

        .location-search {
        margin-bottom: 22px;
    }

    .location-search label {
        display: block;
        margin-bottom: 8px;
        color: var(--ink);
        font-size: 0.82rem;
        font-weight: 700;
    }

    .location-search-row {
        display: flex;
        gap: 10px;
    }

    .location-search-input,
    #location-search-input {
        flex: 1;
        min-width: 0;
        border: 1px solid var(--line);
        border-radius: 8px;
        padding: 13px 14px;
        background: var(--cream);
        color: var(--ink);
        font: inherit;
    }

    #location-search-input:focus {
        outline: 2px solid #b9d1ba;
        border-color: var(--moss);
    }

    #search-location-button {
        border: 1px solid var(--forest);
        border-radius: 8px;
        padding: 0 18px;
        background: var(--forest);
        color: #ffffff;
        cursor: pointer;
        font: inherit;
        font-size: 0.82rem;
        font-weight: 700;
    }

    #search-location-button:hover {
        background: #0f2a1f;
    }

    .location-search-help {
        margin: 8px 0 0;
        color: var(--muted);
        font-size: 0.76rem;
    }

    .location-search-results {
        overflow: hidden;
        margin-top: 10px;
        border: 1px solid var(--line);
        border-radius: 10px;
        background: var(--paper);
    }

    .location-result-button {
        display: block;
        width: 100%;
        padding: 12px 14px;
        border: 0;
        border-bottom: 1px solid var(--line);
        background: transparent;
        color: var(--ink);
        cursor: pointer;
        font: inherit;
        font-size: 0.8rem;
        line-height: 1.45;
        text-align: left;
    }

    .location-result-button:last-child {
        border-bottom: 0;
    }

    .location-result-button:hover {
        background: #eef4ec;
    }

    @media (max-width: 520px) {
        .location-search-row {
            flex-direction: column;
        }

        #search-location-button {
            min-height: 44px;
        }
    }

        .plan-card {
        display: flex;
        min-height: 310px;
        flex-direction: column;
    }

    .plan-inclusions {
        display: grid;
        gap: 7px;
        margin-top: 18px;
    }

    .plan-inclusions-label {
        margin-bottom: 2px;
        color: var(--forest);
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    .plan-benefit {
        display: flex;
        align-items: flex-start;
        gap: 7px;
        color: var(--muted);
        font-size: 0.76rem;
        line-height: 1.4;
    }

    .plan-benefit span {
        color: var(--moss);
        font-weight: 700;
    }

    .plan-meta {
        margin-top: auto;
        padding-top: 18px;
    }
</style>
@endpush

@section('content')
    <section class="public-container public-page">
        <div class="application-header">
            <div>
                <p class="public-kicker">Outdoor Recreation Membership</p>
                <h1 class="public-title">Join TRAIL.</h1>
                <p class="public-description">
                    A short application for people who want to explore,
                    connect, and enjoy the outdoors with community.
                </p>
            </div>

            <a class="public-outline-btn" href="{{ route('home') }}">
                ← Back to explore
            </a>
        </div>

        <div class="public-form-surface">
            @if ($errors->any())
                <div style="margin-bottom: 25px; padding: 14px 16px; border: 1px solid #E3B8B8; background: #FFF3F3; color: #8B3030; border-radius: 10px;">
                    <strong>Please review the highlighted information.</strong>

                    <ul style="margin: 8px 0 0; padding-left: 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="trail-steps">
                <div class="trail-step active" data-indicator="1">
                    <span>1</span> Membership
                </div>

                <div class="trail-step" data-indicator="2">
                    <span>2</span> Your Details
                </div>

                <div class="trail-step" data-indicator="3">
                    <span>3</span> Adventure Area
                </div>
            </div>

            <form method="POST" action="{{ route('membership.store') }}" id="trail-application-form">
                @csrf

                <section class="trail-step-panel" data-panel="1">
                    <h2 class="public-section-title">Choose your membership</h2>
                    <p class="public-section-description">
                        Select the TRAIL option that best fits how you want
                        to experience the outdoors.
                    </p>

                    <div class="plan-picker">
                        @forelse ($categories as $category)
                            @php
                                $content = $planContent[$category->name] ?? [
                                    'title' => $category->name,
                                    'label' => 'TRAIL membership',
                                    'description' => 'Become part of the TRAIL outdoor community.',
                                ];
                            @endphp

                            <label class="plan-option">
                                <input
                                    type="radio"
                                    name="membership_category_id"
                                    value="{{ $category->id }}"
                                    @checked(old('membership_category_id') == $category->id)
                                    required
                                >

                                <span class="plan-card">
                                    <span class="plan-label">{{ $content['label'] }}</span>
                                    <h3>{{ $content['title'] }}</h3>
                                    <p>{{ $content['description'] }}</p>

                                    <span class="plan-inclusions">
                                    <span class="plan-inclusions-label">Includes</span>

                                    @foreach (($content['benefits'] ?? []) as $benefit)
                                        <span class="plan-benefit">
                                            <span aria-hidden="true">✓</span>
                                            {{ $benefit }}
                                        </span>
                                    @endforeach
                                </span>
                                    <span class="plan-meta">
                                        <span>{{ $category->level ?: 'Membership tier' }}</span>
                                        <span>₱{{ number_format($category->fee, 2) }}</span>
                                    </span>
                                </span>
                            </label>
                        @empty
                            <p>No memberships are available right now.</p>
                        @endforelse
                    </div>

                    <p class="plan-error" id="plan-error" hidden>
                        Please choose a membership option to continue.
                    </p>

                    <div class="form-actions end">
                        <button type="button" class="step-button" id="to-step-2">
                            Continue to your details →
                        </button>
                    </div>
                </section>

                <section class="trail-step-panel" data-panel="2" hidden>
                    <h2 class="public-section-title">Tell us about yourself</h2>
                    <p class="public-section-description">
                        We use these details for your membership record and
                        email confirmation.
                    </p>

                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="full_name">Full Name <span style="color: var(--danger);">*</span></label>
                            <input
                                type="text"
                                id="full_name"
                                name="full_name"
                                value="{{ old('full_name') }}"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address <span style="color: var(--danger);">*</span></label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                placeholder="e.g. 09171234567"
                                value="{{ old('phone') }}"
                            >
                        </div>

                        <div class="form-group full-width">
                            <label for="address">Home Address</label>
                            <textarea
                                id="address"
                                name="address"
                                placeholder="Enter your city, municipality, or complete address"
                            >{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="step-button back-button" data-back="1">
                            ← Back
                        </button>

                        <button type="button" class="step-button" id="to-step-3">
                            Choose adventure area →
                        </button>
                    </div>
                </section>

                <section class="trail-step-panel" data-panel="3" hidden>
                    <h2 class="public-section-title">Select your adventure area</h2>
                    <p class="public-section-description">
                        Click the map to choose a preferred meet-up point or
                        outdoor activity area. We will show its live weather conditions.
                    </p>

                    <div class="location-search">
    <label for="location-search-input">Search an address or trail</label>

    <div class="location-search-row">
        <input
            id="location-search-input"
            type="search"
            placeholder="e.g. Masungi Georeserve, Baras, Rizal"
            autocomplete="off"
        >

        <button type="button" id="search-location-button">
            Search
        </button>
        </div>

            <p class="location-search-help">
            Search for a trail, landmark, city, or exact address in the Philippines.
             </p>

        <div id="location-search-results" class="location-search-results" hidden></div>
        </div>
                    
                    <div class="map-layout">
                        <div>
                            <div id="trail-map"></div>

                            <input
                                id="latitude"
                                type="hidden"
                                name="latitude"
                                value="{{ old('latitude', '14.5995') }}"
                            >

                            <input
                                id="longitude"
                                type="hidden"
                                name="longitude"
                                value="{{ old('longitude', '120.9842') }}"
                            >

                            <p class="coordinates" id="coordinates">
                                Loading selected location...
                            </p>
                        </div>

                        <aside class="weather-panel">
                            <div>
                                <p class="weather-label">Live Trail Conditions</p>
                                <p class="weather-place" id="weather-place">Selected location</p>
                                <p class="weather-temp" id="weather-temperature">--</p>
                                <p class="weather-description" id="weather-description">
                                    Loading weather...
                                </p>
                            </div>

                            <p class="weather-footer" id="weather-humidity">
                                Humidity: --
                            </p>
                        </aside>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="step-button back-button" data-back="2">
                            ← Back
                        </button>

                        <button type="submit" class="step-button">
                            Submit TRAIL application →
                        </button>
                    </div>
                </section>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const form = document.getElementById('trail-application-form');
        const panels = document.querySelectorAll('.trail-step-panel');
        const indicators = document.querySelectorAll('[data-indicator]');
        const planError = document.getElementById('plan-error');

        let currentStep = 1;
        let trailMap;
        let marker;
        let mapStarted = false;

        function showStep(step) {
            currentStep = step;

            panels.forEach(panel => {
                panel.hidden = Number(panel.dataset.panel) !== step;
            });

            indicators.forEach(indicator => {
                indicator.classList.toggle(
                    'active',
                    Number(indicator.dataset.indicator) <= step
                );
            });

            if (step === 3) {
                setTimeout(initializeMap, 80);
            }

            window.scrollTo({
                top: 0,
                behavior: 'smooth',
            });
        }

        document.getElementById('to-step-2').addEventListener('click', () => {
            const selectedPlan = form.querySelector(
                'input[name="membership_category_id"]:checked'
            );

            if (!selectedPlan) {
                planError.hidden = false;
                return;
            }

            planError.hidden = true;
            showStep(2);
        });

        document.getElementById('to-step-3').addEventListener('click', () => {
            const detailsPanel = document.querySelector('[data-panel="2"]');
            const requiredFields = detailsPanel.querySelectorAll('[required]');

            for (const field of requiredFields) {
                if (!field.checkValidity()) {
                    field.reportValidity();
                    return;
                }
            }

            showStep(3);
        });

        document.querySelectorAll('[data-back]').forEach(button => {
            button.addEventListener('click', () => {
                showStep(Number(button.dataset.back));
            });
        });

        function formatDescription(description) {
            if (!description) {
                return 'Weather unavailable';
            }

            return description.charAt(0).toUpperCase() + description.slice(1);
        }

        function loadWeather(latitude, longitude) {
            document.getElementById('weather-place').textContent =
                'Checking conditions...';

            document.getElementById('weather-temperature').textContent = '--';

            document.getElementById('weather-description').textContent =
                'Loading weather...';

            document.getElementById('weather-humidity').textContent =
                'Humidity: --';

            fetch(
                `{{ route('weather.show') }}?lat=${encodeURIComponent(latitude)}&lon=${encodeURIComponent(longitude)}`
            )
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Weather request failed');
                    }

                    return response.json();
                })
                .then(weather => {
                    document.getElementById('weather-place').textContent =
                        weather.place || 'Selected location';

                    document.getElementById('weather-temperature').textContent =
                        weather.temperature !== null
                            ? `${Math.round(weather.temperature)}°C`
                            : '--';

                    document.getElementById('weather-description').textContent =
                        formatDescription(weather.description);

                    document.getElementById('weather-humidity').textContent =
                        weather.humidity !== null
                            ? `Humidity: ${weather.humidity}%`
                            : 'Humidity: --';
                })
                .catch(() => {
                    document.getElementById('weather-place').textContent =
                        'Selected location';

                    document.getElementById('weather-description').textContent =
                        'Weather is currently unavailable.';
                });
        }

        function setLocation(latitude, longitude, moveMap = false) {
            document.getElementById('latitude').value = latitude.toFixed(7);
            document.getElementById('longitude').value = longitude.toFixed(7);

            document.getElementById('coordinates').textContent =
                `Latitude: ${latitude.toFixed(5)}, Longitude: ${longitude.toFixed(5)}`;

            if (marker) {
                marker.setLatLng([latitude, longitude]);
            } else {
                marker = L.marker([latitude, longitude]).addTo(trailMap);
            }

            if (moveMap) {
                trailMap.flyTo([latitude, longitude], 13);
            }

            loadWeather(latitude, longitude);
        }

        function initializeMap() {
            const latitude = Number(document.getElementById('latitude').value) || 14.5995;
            const longitude = Number(document.getElementById('longitude').value) || 120.9842;

            if (mapStarted) {
                trailMap.invalidateSize();
                return;
            }

            trailMap = L.map('trail-map').setView(
                [latitude, longitude],
                12
            );

            L.tileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors',
                }
            ).addTo(trailMap);

            trailMap.on('click', event => {
                setLocation(event.latlng.lat, event.latlng.lng, true);
            });

            mapStarted = true;
            setLocation(latitude, longitude);
        }

    const searchInput = document.getElementById('location-search-input');
    const searchButton = document.getElementById('search-location-button');
    const searchResults = document.getElementById('location-search-results');

    function clearLocationResults() {
        searchResults.replaceChildren();
        searchResults.hidden = true;
    }

    function useSearchResult(location) {
        if (!mapStarted) {
            initializeMap();
        }

        setLocation(location.latitude, location.longitude, true);

        searchInput.value = location.name;
        clearLocationResults();
    }

    function showLocationMessage(message) {
        const messageElement = document.createElement('p');

        messageElement.textContent = message;
        messageElement.style.margin = '0';
        messageElement.style.padding = '12px 14px';
        messageElement.style.color = 'var(--muted)';
        messageElement.style.fontSize = '0.8rem';

        searchResults.replaceChildren(messageElement);
        searchResults.hidden = false;
    }

    async function searchLocation() {
        const query = searchInput.value.trim();

        if (query.length < 3) {
            showLocationMessage('Please enter at least three characters.');
            return;
        }

        searchButton.disabled = true;
        searchButton.textContent = 'Searching...';
        clearLocationResults();

        try {
            const response = await fetch(
                `{{ route('locations.search') }}?q=${encodeURIComponent(query)}`,
                {
                    headers: {
                        Accept: 'application/json',
                    },
                }
            );

            if (!response.ok) {
                throw new Error('Location search failed.');
            }

            const locations = await response.json();

            if (!locations.length) {
                showLocationMessage('No matching locations found. Try a more specific address.');
                return;
            }

            locations.forEach(location => {
                const resultButton = document.createElement('button');

                resultButton.type = 'button';
                resultButton.className = 'location-result-button';
                resultButton.textContent = location.name;

                resultButton.addEventListener('click', () => {
                    useSearchResult(location);
                });

                searchResults.appendChild(resultButton);
            });

            searchResults.hidden = false;
        } catch (error) {
            showLocationMessage('Location search is currently unavailable. Please click the map instead.');
        } finally {
            searchButton.disabled = false;
            searchButton.textContent = 'Search';
        }
    }

    searchButton.addEventListener('click', searchLocation);

    searchInput.addEventListener('keydown', event => {
        if (event.key === 'Enter') {
            event.preventDefault();
            searchLocation();
        }
    });
    </script>
@endpush