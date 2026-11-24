<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Workspace | TRAIL')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --forest: #163a2b;
            --forest-dark: #0f2a1f;
            --cream: #f5f2ec;
            --paper: #fffefa;
            --ink: #1b2920;
            --muted: #748078;
            --line: #dce2da;
            --moss: #66815f;
            --accent: #e4edcf;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            background: var(--cream);
            color: var(--ink);
            font-family: "DM Sans", sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .admin-shell {
            display: grid;
            grid-template-columns: 250px minmax(0, 1fr);
            min-height: 100vh;
        }

        .admin-sidebar {
            display: flex;
            position: sticky;
            top: 0;
            min-height: 100vh;
            flex-direction: column;
            padding: 28px 18px;
            background: var(--forest-dark);
            color: rgba(255, 255, 255, 0.75);
        }

        .admin-brand {
            display: block;
            margin: 0 10px 42px;
        }

       .admin-logo-surface {
            display: flex;
            width: 174px;
            height: 54px;
            align-items: center;
            padding: 0;
            overflow: visible;
            background: transparent;
        }

        .admin-logo-image {
            display: block;
            width: 138px;
            height: 42px;
            object-fit: contain;
            object-position: left center;
            transform: scale(1.80);
            transform-origin: left center;
        }

        .admin-brand span {
            display: block;
            margin: 9px 0 0 3px;
            color: #bdd0a9;
            font-size: 0.64rem;
            font-weight: 700;
            letter-spacing: 0.13em;
            text-transform: uppercase;
        }

        .nav-label {
            margin: 0 10px 10px;
            color: rgba(255, 255, 255, 0.38);
            font-size: 0.64rem;
            font-weight: 700;
            letter-spacing: 0.13em;
            text-transform: uppercase;
        }

        .admin-nav {
            display: grid;
            gap: 5px;
        }

        .admin-nav a {
            padding: 11px 12px;
            border-radius: 9px;
            font-size: 0.84rem;
            font-weight: 600;
        }

        .admin-nav a:hover,
        .admin-nav a.active {
            background: rgba(255, 255, 255, 0.12);
            color: white;
        }

        .admin-nav a.active {
            box-shadow: inset 3px 0 0 #cde19c;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding: 18px 10px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }

        .sidebar-bottom a {
            font-size: 0.78rem;
            font-weight: 600;
        }

        .admin-main {
            min-width: 0;
        }

        .admin-topbar {
            display: flex;
            min-height: 78px;
            align-items: center;
            justify-content: space-between;
            padding: 0 48px;
            border-bottom: 1px solid var(--line);
            background: rgba(255, 254, 250, 0.9);
        }

        .admin-topbar p {
            margin: 0;
            color: var(--muted);
            font-size: 0.8rem;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 9px;
            color: var(--forest);
            font-size: 0.8rem;
            font-weight: 700;
        }

        .admin-avatar {
            display: grid;
            width: 32px;
            height: 32px;
            place-items: center;
            border-radius: 50%;
            background: var(--accent);
            font-size: 0.7rem;
        }

        .logout-button {
            padding: 8px 12px;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: transparent;
            color: var(--forest);
            font-size: 0.72rem;
            font-weight: 700;
            cursor: pointer;
        }

        .logout-button:hover {
            border-color: var(--moss);
            background: #edf3e9;
        }

        .admin-content {
            width: min(1380px, 100%);
            margin: auto;
            padding: 48px;
        }

        @media (max-width: 850px) {
            .admin-shell {
                display: block;
            }

            .admin-sidebar {
                position: static;
                min-height: auto;
            }

            .admin-brand {
                margin-bottom: 22px;
            }

            .admin-nav {
                grid-template-columns: repeat(2, 1fr);
            }

            .sidebar-bottom {
                display: none;
            }

            .admin-topbar,
            .admin-content {
                padding-right: 24px;
                padding-left: 24px;
            }
        }

        @media (max-width: 500px) {
            .admin-nav {
                grid-template-columns: 1fr;
            }

            .admin-topbar {
                min-height: 64px;
            }

            .admin-topbar p {
                display: none;
            }

            .admin-content {
                padding: 28px 18px;
            }
        }

        @stack('styles')
    </style>
</head>
<body>
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a href="{{ route('admin.dashboard') }}" class="admin-brand">
                <div class="admin-logo-surface">
                    <img
                        src="{{ asset('images/Trail Logo-1.png') }}"
                        alt="TRAIL"
                        class="admin-logo-image"
                    >
                </div>

                <span>Admin Workspace</span>
            </a>

            <p class="nav-label">Overview</p>

            <nav class="admin-nav">
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                >
                    Dashboard
                </a>

                <a
                    href="{{ route('members.index') }}"
                    class="{{ request()->routeIs('members.*') ? 'active' : '' }}"
                >
                    Members
                </a>
            </nav>

            <p class="nav-label" style="margin-top: 28px;">Membership</p>

            <nav class="admin-nav">
                <a href="{{ url('/admin/categories') }}">Categories & Plans</a>
                <a href="{{ route('admin.levels.index') }}">Membership Levels</a>
                <a href="{{ url('/admin/applications') }}">Applications</a>
                <a href="{{ url('/admin/transactions') }}">Transactions</a>
                <a href="{{ url('/admin/payments') }}">Payments</a>
            </nav>

            <div class="sidebar-bottom">
                <a href="{{ route('home') }}">← View public website</a>
            </div>
        </aside>

        <section class="admin-main">
            <header class="admin-topbar">
                <p>TRAIL Outdoor Recreation Membership System</p>

                <div style="display: flex; align-items: center; gap: 16px;">
                    <div class="admin-user">
                        <span class="admin-avatar">AD</span>
                        Administrator
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-button">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="admin-content">
                @yield('content')
            </main>
        </section>
    </div>

    @stack('scripts')
</body>
</html>