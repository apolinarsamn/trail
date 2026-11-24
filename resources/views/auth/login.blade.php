<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | TRAIL</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --forest: #163a2b;
            --cream: #f5f2ec;
            --paper: #fffefa;
            --muted: #69736b;
            --line: #d9dfd3;
        }

        * {
            box-sizing: border-box;
        }

        body {
            display: grid;
            min-height: 100vh;
            margin: 0;
            place-items: center;
            padding: 28px;
            background: var(--cream);
            color: var(--forest);
            font-family: "DM Sans", sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .auth-card {
            width: min(520px, 100%);
            padding: 48px 52px;
            border: 1px solid var(--line);
            border-radius: 24px;
            background: var(--paper);
        }

        .brand {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-bottom: 20px;
        }

        .brand img {
            display: block;
            width: 210px;
            height: 64px;
            object-fit: contain;
        }

        .eyebrow {
            margin: 0 0 12px;
            color: #54724f;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0;
            font-family: "Playfair Display", serif;
            font-size: clamp(2.3rem, 5vw, 3.3rem);
            font-weight: 500;
            letter-spacing: -0.06em;
        }

        .intro {
            margin: 14px 0 30px;
            color: var(--muted);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .error-box {
            margin-bottom: 22px;
            padding: 13px 15px;
            border: 1px solid #e7b9b4;
            border-radius: 10px;
            background: #fff5f3;
            color: #9e3025;
            font-size: 0.82rem;
        }

        .field {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid var(--line);
            border-radius: 12px;
            outline: none;
            background: white;
            color: var(--forest);
            font: inherit;
            font-size: 0.9rem;
        }

        input:focus {
            border-color: var(--forest);
            box-shadow: 0 0 0 3px rgba(22, 58, 43, 0.1);
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 4px 0 22px;
            color: var(--muted);
            font-size: 0.8rem;
            font-weight: 600;
        }

        .remember input {
            width: 17px;
            height: 17px;
            margin: 0;
            accent-color: var(--forest);
        }

        .submit-button {
            width: 100%;
            padding: 15px 18px;
            border: 0;
            border-radius: 999px;
            background: var(--forest);
            color: white;
            font: inherit;
            font-size: 0.86rem;
            font-weight: 700;
            cursor: pointer;
        }

        .submit-button:hover {
            background: #0f2a1f;
        }

        .auth-switch {
            margin: 22px 0 0;
            color: var(--muted);
            font-size: 0.82rem;
            text-align: center;
        }

        .auth-switch a {
            color: var(--forest);
            font-weight: 700;
        }

        @media (max-width: 550px) {
            body {
                padding: 18px;
            }

            .auth-card {
                padding: 34px 26px;
            }

            .brand img {
                width: 165px;
                height: 52px;
            }
        }
    </style>
</head>
<body>
    <main class="auth-card">
        <a href="{{ route('home') }}" class="brand" aria-label="TRAIL home">
            <img src="{{ asset('images/TRAIL LOGO.png') }}" alt="TRAIL Outdoor Club">
        </a>

        <p class="eyebrow">TRAIL Community</p>
        <h1>Welcome back.</h1>
        <p class="intro">
            Login to continue your TRAIL journey.
        </p>

        @if ($errors->any())
            <div class="error-box">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.store') }}" method="POST">
            @csrf

            <div class="field">
                <label for="email">Email address</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                >
            </div>

            <label class="remember">
                <input type="checkbox" name="remember">
                Keep me logged in
            </label>

            <button type="submit" class="submit-button">
                Login →
            </button>
        </form>

        <p class="auth-switch">
            New to TRAIL?
            <a href="{{ route('register') }}">Create an account</a>
        </p>
    </main>
</body>
</html>