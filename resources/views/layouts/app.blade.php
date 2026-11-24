<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TRAIL')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles') 

    <style>
        :root {
            --navy: #2F4156;
            --teal: #567C8D;
            --sky: #CBD9E6;
            --beige: #F5EFEB;
        }

        body {
            background-color: var(--beige);
            color: var(--navy);
        }

        .navbar-brand,
        .nav-link {
            color: white !important;
        }

        .bg-brand {
            background-color: var(--navy);
        }

        .btn-brand {
            background-color: var(--teal);
            border-color: var(--teal);
            color: white;
        }

        .btn-brand:hover {
            background-color: var(--navy);
            border-color: var(--navy);
            color: white;
        }

        .page-card {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(47, 65, 86, 0.12);
        }

        .table thead th {
            background-color: var(--navy);
            color: white;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-brand shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="{{ route('members.index') }}">
                TRAIL
            </a>

            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('members.index') }}">Members</a>
                <a class="nav-link" href="{{ route('members.create') }}">Register Member</a>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>