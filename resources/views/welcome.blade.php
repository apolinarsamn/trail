@extends('layouts.public')

@section('title', 'TRAIL | Outdoor Recreation Community')

@push('styles')
    <style>
        .homepage {
            overflow: hidden;
        }

        .page-container {
            width: min(1240px, calc(100% - 48px));
            margin: auto;
        }

        .hero {
            position: relative;
            min-height: calc(100svh - 74px);
            overflow: hidden;
            color: white;
            background:
                linear-gradient(90deg, rgba(8, 25, 17, 0.62), rgba(8, 25, 17, 0.12)),
                linear-gradient(0deg, rgba(8, 25, 17, 0.52), transparent 58%),
                url("https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=2200&q=90")
                center / cover;
        }

        .hero-inner {
            position: relative;
            display: flex;
            width: min(1240px, calc(100% - 48px));
            min-height: calc(100svh - 74px);
            margin: auto;
            align-items: end;
            padding: 82px 0 72px;
        }

        .hero-copy {
            width: min(475px, 100%);
            animation: hero-rise 0.7s ease-out both;
        }

        .hero-label,
        .eyebrow {
            margin: 0 0 13px;
            color: #dce47c;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
        }

        .hero h1 {
            max-width: 510px;
            margin: 0;
            font-family: "Playfair Display", serif;
            font-size: clamp(2.8rem, 4.8vw, 4.5rem);
            font-weight: 500;
            letter-spacing: -0.075em;
            line-height: 0.97;
        }

        .hero-description {
            max-width: 355px;
            margin: 22px 0 27px;
            color: rgba(255, 255, 255, 0.86);
            font-size: 0.93rem;
            line-height: 1.65;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 13px;
            align-items: center;
        }

        .hero-action {
            display: inline-flex;
            min-height: 48px;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 0 21px;
            border-radius: 999px;
            background: white;
            color: var(--forest);
            font-size: 0.83rem;
            font-weight: 700;
            transition: transform 0.2s ease, background 0.2s ease;
        }

        .hero-action:hover {
            background: #e7efd9;
            color: var(--forest);
            transform: translateY(-3px);
        }

        .hero-text-link {
            color: white;
            font-size: 0.82rem;
            font-weight: 700;
        }

        .hero-text-link:hover {
            color: #dce47c;
        }

        .hero-scroll {
            position: absolute;
            right: 0;
            bottom: 33px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.04em;
        }

        .scroll-icon {
            display: grid;
            width: 34px;
            height: 34px;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, 0.45);
            border-radius: 50%;
            font-size: 1rem;
            animation: scroll-bounce 1.8s infinite;
        }

        .quick-flow {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            padding: 29px 0;
            border-bottom: 1px solid var(--line);
            scroll-margin-top: 90px;
        }

        .quick-flow div {
            display: flex;
            align-items: center;
            gap: 11px;
            color: var(--forest);
            font-size: 0.82rem;
            font-weight: 600;
        }

        .quick-flow span {
            display: grid;
            width: 29px;
            height: 29px;
            flex: 0 0 auto;
            place-items: center;
            border-radius: 50%;
            background: var(--forest);
            color: white;
            font-size: 0.72rem;
        }

        .section {
            padding: 104px 0;
            scroll-margin-top: 70px;
        }

        .section-heading {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 30px;
            margin-bottom: 38px;
        }

        .section-heading h2,
        .benefits h2 {
            margin: 0;
            color: var(--forest);
            font-family: "Playfair Display", serif;
            font-size: clamp(2.4rem, 4.5vw, 4rem);
            font-weight: 500;
            letter-spacing: -0.07em;
            line-height: 0.98;
        }

        .section-description {
            max-width: 350px;
            margin: 0;
            color: var(--muted);
            font-size: 0.92rem;
            line-height: 1.65;
        }

        .plans {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .plan {
            position: relative;
            display: flex;
            min-height: 360px;
            flex-direction: column;
            justify-content: end;
            padding: 24px;
            overflow: hidden;
            border-radius: 18px;
            background: var(--forest);
            color: white;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .plan:hover {
            box-shadow: 0 18px 32px rgba(22, 58, 43, 0.18);
            transform: translateY(-7px);
        }

        .plan::before {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 22%, rgba(6, 24, 15, 0.84) 100%);
            content: "";
        }

        .plan > * {
            position: relative;
            z-index: 1;
        }

        .plan:nth-child(2) {
            background:
                url("https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=900&q=85")
                center / cover;
        }

        .plan:nth-child(3) {
            background:
                url("https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=85")
                center / cover;
        }

        .plan:nth-child(4) {
            background:
                url("https://images.unsplash.com/photo-1500534623283-312aade485b7?auto=format&fit=crop&w=900&q=85")
                center / cover;
        }

        .plan-label {
            margin: 0 0 9px;
            color: #dce47c;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.11em;
            text-transform: uppercase;
        }

        .plan h3 {
            margin: 0 0 11px;
            font-family: "Playfair Display", serif;
            font-size: 1.72rem;
            font-weight: 500;
            letter-spacing: -0.05em;
        }

        .plan p:not(.plan-label) {
            min-height: 42px;
            margin: 0 0 20px;
            color: rgba(255, 255, 255, 0.86);
            font-size: 0.81rem;
            line-height: 1.55;
        }

        .plan-action {
            width: fit-content;
            color: white;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .plan-action:hover {
            color: #dce47c;
        }

        .benefits {
            display: grid;
            grid-template-columns: 0.86fr 1.14fr;
            gap: 80px;
            align-items: start;
            padding: 92px 0;
            border-top: 1px solid var(--line);
        }

        .benefits > div > p:not(.eyebrow) {
            max-width: 400px;
            color: var(--muted);
            line-height: 1.7;
        }

        .benefit {
            display: grid;
            grid-template-columns: 48px 1fr;
            gap: 18px;
            padding: 24px 0;
            border-top: 1px solid var(--line);
        }

        .benefit-number {
            color: var(--moss);
            font-family: "Playfair Display", serif;
            font-size: 1.45rem;
        }

        .benefit h3 {
            margin: 0 0 7px;
            color: var(--forest);
            font-size: 1rem;
        }

        .benefit p {
            margin: 0;
            color: var(--muted);
            font-size: 0.87rem;
            line-height: 1.6;
        }

        @keyframes hero-rise {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scroll-bounce {
            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(5px);
            }
        }

        @media (max-width: 950px) {
            .plans,
            .quick-flow {
                grid-template-columns: repeat(2, 1fr);
            }

            .benefits {
                grid-template-columns: 1fr;
                gap: 36px;
            }
        }

        @media (max-width: 650px) {
            .page-container,
            .hero-inner {
                width: min(100% - 32px, 1240px);
            }

            .hero,
            .hero-inner {
                min-height: calc(100svh - 64px);
            }

            .hero-inner {
                padding: 80px 0 98px;
            }

            .hero h1 {
                font-size: clamp(2.7rem, 12vw, 3.9rem);
            }

            .hero-description {
                font-size: 0.91rem;
            }

            .hero-scroll {
                right: 0;
                bottom: 28px;
            }

            .quick-flow {
                gap: 17px 10px;
                padding: 28px 0;
            }

            .quick-flow div {
                align-items: start;
                font-size: 0.76rem;
            }

            .section {
                padding: 74px 0;
            }

            .section-heading {
                align-items: start;
                flex-direction: column;
                margin-bottom: 28px;
            }

            .plans {
                grid-template-columns: 1fr;
            }

            .plan {
                min-height: 300px;
            }

            .benefits {
                padding: 72px 0;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="homepage">
        <section class="hero">
            <div class="hero-inner">
                <div class="hero-copy">
                    <p class="hero-label">Outdoor Recreation Community</p>

                    <h1>Explore the outdoors. Find your people.</h1>

                    <p class="hero-description">
                        Join a community built for hikers, campers, and weekend
                        explorers who want more from the outdoors.
                    </p>

                    <div class="hero-actions">
                        <a class="hero-action" href="{{ route('membership.create') }}">
                            Start your journey <span>→</span>
                        </a>

                        <a class="hero-text-link" href="#membership">
                            View memberships
                        </a>
                    </div>
                </div>

                <a class="hero-scroll" href="#adventures">
                    <span>Scroll to explore</span>
                    <span class="scroll-icon">↓</span>
                </a>
            </div>
        </section>

        <div class="page-container">
            <section class="quick-flow" id="adventures">
                <div><span>1</span> Choose a membership</div>
                <div><span>2</span> Share your details</div>
                <div><span>3</span> Select an adventure area</div>
                <div><span>4</span> Receive email confirmation</div>
            </section>

            <section class="section" id="membership">
                <div class="section-heading">
                    <div>
                        <p class="eyebrow">Memberships</p>
                        <h2>Find your place<br>on the trail.</h2>
                    </div>

                    <p class="section-description">
                        Choose a TRAIL membership designed for your outdoor
                        interests, community, and next adventure.
                    </p>
                </div>

                <div class="plans">
                    <article class="plan">
                        <p class="plan-label">Student · Basic</p>
                        <h3>Start Exploring</h3>
                        <p>For students starting their outdoor recreation journey.</p>
                        <a class="plan-action" href="{{ route('membership.create') }}">
                            Apply now →
                        </a>
                    </article>

                    <article class="plan">
                        <p class="plan-label">Regular · Basic</p>
                        <h3>Trail Ready</h3>
                        <p>For outdoor enthusiasts ready to join the community.</p>
                        <a class="plan-action" href="{{ route('membership.create') }}">
                            Apply now →
                        </a>
                    </article>

                    <article class="plan">
                        <p class="plan-label">Senior Citizen · Silver</p>
                        <h3>Explore Together</h3>
                        <p>For active seniors who enjoy nature and shared experiences.</p>
                        <a class="plan-action" href="{{ route('membership.create') }}">
                            Apply now →
                        </a>
                    </article>

                    <article class="plan">
                        <p class="plan-label">Corporate · Gold</p>
                        <h3>Move as One</h3>
                        <p>For teams looking for meaningful outdoor group activities.</p>
                        <a class="plan-action" href="{{ route('membership.create') }}">
                            Apply now →
                        </a>
                    </article>
                </div>
            </section>

            <section class="benefits">
                <div>
                    <p class="eyebrow">Why TRAIL</p>
                    <h2>Elevate your adventures.</h2>
                    <p>
                        TRAIL brings membership, location selection, weather
                        awareness, and outdoor community into one simple experience.
                    </p>
                </div>

                <div>
                    <article class="benefit">
                        <span class="benefit-number">01</span>
                        <div>
                            <h3>Adventure-focused membership</h3>
                            <p>Choose a plan that fits how you want to experience the outdoors.</p>
                        </div>
                    </article>

                    <article class="benefit">
                        <span class="benefit-number">02</span>
                        <div>
                            <h3>Location and weather awareness</h3>
                            <p>Select a preferred adventure area and view its current conditions.</p>
                        </div>
                    </article>

                    <article class="benefit">
                        <span class="benefit-number">03</span>
                        <div>
                            <h3>Clear application updates</h3>
                            <p>Receive a unique reference number and email confirmation after applying.</p>
                        </div>
                    </article>
                </div>
            </section>
        </div>
    </div>
@endsection