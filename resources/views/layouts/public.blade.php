<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'TRAIL | Outdoor Recreation')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --forest: #163a2b;
            --forest-dark: #0f2a1f;
            --moss: #54724f;
            --cream: #f5f2ec;
            --paper: #fffefa;
            --ink: #1b2920;
            --muted: #69736b;
            --line: #d9dfd3;
            --accent: #dce47c;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background: var(--cream);
            color: var(--ink);
            font-family: "DM Sans", sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .site-header {
            position: sticky;
            z-index: 1000;
            top: 0;
            border-bottom: 1px solid rgba(22, 58, 43, 0.1);
            background: rgba(255, 254, 250, 0.94);
            backdrop-filter: blur(14px);
        }

        .site-nav {
            display: flex;
            width: min(1240px, calc(100% - 40px));
            height: 78px;
            min-height: 78px;
            margin: auto;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .brand {
            display: inline-flex;
            height: 50px;
            align-items: center;
            color: var(--forest);
        }

        .brand-image {
            display: block;
            width: 150px;
            height: 50px;
            max-height: 50px;
            flex: 0 0 auto;
            object-fit: contain;
            object-position: left center;
            transform: scale(1.65);
            transform-origin: left center;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 22px;
            color: var(--forest);
            font-size: 0.82rem;
            font-weight: 600;
        }

        .nav-links a:hover {
            color: var(--moss);
        }

        .nav-login {
            padding: 9px 13px;
            border: 1px solid var(--forest);
            border-radius: 999px;
        }

        .nav-login:hover {
            border-color: var(--moss);
            background: #eef3ea;
        }

        .nav-signup {
            color: var(--muted);
        }

        .nav-signup:hover {
            color: var(--forest);
        }

        .nav-cta {
            padding: 11px 16px;
            border-radius: 999px;
            background: var(--forest);
            color: white !important;
        }

        .nav-cta:hover {
            background: var(--forest-dark);
        }

        .nav-user {
            color: var(--muted);
            font-size: 0.82rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .nav-logout-form {
            margin: 0;
        }

        .nav-logout {
            padding: 0;
            border: 0;
            background: transparent;
            color: var(--muted);
            font: inherit;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
        }

        .nav-logout:hover {
            color: #b42318;
        }

        .site-footer {
            margin-top: 80px;
            padding: 34px 20px;
            background: var(--forest-dark);
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.82rem;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            width: min(1240px, 100%);
            margin: auto;
            gap: 20px;
        }

        .footer-brand {
            color: white;
            font-weight: 700;
            letter-spacing: -0.04em;
        }

        @media (max-width: 650px) {
            .site-nav {
                width: min(100% - 28px, 1240px);
                height: 64px;
                min-height: 64px;
            }

            .brand {
                height: 40px;
            }

            .brand-image {
                width: 118px;
                height: 40px;
                max-height: 40px;
                transform: scale(1.3);
                transform-origin: left center;
            }

            .nav-links {
                gap: 10px;
            }

            .nav-links > a:not(.nav-login):not(.nav-cta) {
                display: none;
            }

            .nav-user {
                display: none;
            }

            .footer-content {
                display: block;
            }

            .footer-content p {
                margin-top: 10px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <header class="site-header">
        <nav class="site-nav">
            <a href="{{ route('home') }}" class="brand" aria-label="TRAIL Outdoor Club home">
                <img
                    src="{{ asset('images/TRAIL LOGO.png') }}"
                    alt="TRAIL Outdoor Club"
                    class="brand-image"
                >
            </a>

            <div class="nav-links">
                <a href="{{ route('home') }}#membership">Memberships</a>
                <a href="{{ route('home') }}#adventures">Adventures</a>

                @guest
                    <a href="{{ route('login') }}" class="nav-login">Login</a>
                    <a href="{{ route('register') }}" class="nav-signup">Sign up</a>
                    <a href="{{ route('membership.create') }}" class="nav-cta">Join TRAIL</a>
                @endguest

                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-login">
                            Admin workspace
                        </a>
                    @else
                        <span class="nav-user">
                            Hi, {{ auth()->user()->name }}
                        </span>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="nav-logout-form">
                        @csrf
                        <button type="submit" class="nav-logout">Logout</button>
                    </form>
                @endauth
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="footer-content">
            <span class="footer-brand">TRAIL Outdoor Club</span>
            <p>Membership for people who choose the outdoors.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>