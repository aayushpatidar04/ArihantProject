<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ArihantPLUS — Central India\'s Largest AI & Algo Conclave')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <style>
        :root { --bg:#060208; --bg-soft:#0b0510; --panel:#0e0812; --purple-1:#b866f7; --purple-2:#8b2fd9; --purple-3:#6a1fb8; --magenta:#c92fd0; --ink:#f6f3fa; --muted:#a79bb5; --muted-2:#7c7188; --border:rgba(180,120,255,0.28); --btn-grad:linear-gradient(135deg,#d43fe0 0%,#7a1fc9 55%,#601fae 100%); --max:1160px; }
        *{margin:0;padding:0;box-sizing:border-box}
        html{scroll-behavior:smooth}
        body{background:var(--bg);color:var(--ink);font-family:'Inter',sans-serif;overflow-x:hidden;-webkit-font-smoothing:antialiased}
        h1,h2,h3,.font-display{font-family:'Sora',sans-serif}
        img{display:block;max-width:100%}
        a{color:inherit;text-decoration:none}
        .wrap{max-width:var(--max);margin:0 auto;padding:0 24px}
        .btn{display:inline-flex;align-items:center;justify-content:center;font-family:'Inter',sans-serif;font-weight:600;font-size:15px;padding:13px 26px;border-radius:999px;border:none;cursor:pointer;transition:transform .25s ease,box-shadow .25s ease,filter .25s ease}
        .btn:hover{transform:translateY(-2px)}
        .btn-primary{background:var(--btn-grad);color:#fff;box-shadow:0 8px 24px rgba(160,40,200,0.45),inset 0 1px 0 rgba(255,255,255,0.25)}
        .btn-primary:hover{box-shadow:0 12px 32px rgba(190,50,230,0.6),inset 0 1px 0 rgba(255,255,255,0.3)}
        .btn-white{background:#fff;color:#150a1e;box-shadow:0 8px 30px rgba(200,140,255,0.25)}
        .btn-ghost{background:rgba(120,60,180,0.35);color:#e9defa;font-size:13px;border:1px solid rgba(180,130,255,0.35);padding:10px 22px}
        .alert{padding:14px 18px;border-radius:12px;margin-bottom:20px;font-size:14px}
        .alert-success{background:rgba(40,180,100,0.15);border:1px solid rgba(40,180,100,0.4);color:#8ff0b3}
        .alert-error{background:rgba(220,60,60,0.15);border:1px solid rgba(220,60,60,0.4);color:#ff9e9e}
        header{position:sticky;top:0;z-index:100;background:rgba(5,2,8,0.75);backdrop-filter:blur(14px);border-bottom:1px solid rgba(255,255,255,0.06)}
        .nav{display:flex;align-items:center;justify-content:space-between;padding:18px 24px;max-width:var(--max);margin:0 auto}
        .logo{display:flex;align-items:center;gap:8px;font-family:'Sora',sans-serif;font-weight:700;font-size:20px}
        .logo-img{height:32px;width:auto;display:block}
        nav.links{display:flex;gap:38px;font-size:15px;color:#e9e4f0}
        nav.links a{opacity:.85;transition:opacity .2s}
        nav.links a:hover{opacity:1;color:var(--purple-1)}
        .nav-cta{display:inline-flex}
        .menu-toggle{display:none;width:42px;height:42px;border-radius:12px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.14);align-items:center;justify-content:center;color:#f6f3fa;cursor:pointer;flex-shrink:0}
        @media(max-width:819px){nav.links,.nav-cta{display:none}.menu-toggle{display:flex}}
    </style>
    @stack('styles')
</head>
<body>
    <header>
        <div class="nav">
            <a href="{{ route('index') }}" class="logo"><img src="{{ asset('assets/images/logo.png') }}" alt="ArihantPLUS" class="logo-img"></a>
            <nav class="links">
                <a href="{{ route('index') }}#home">Home</a>
                <a href="{{ route('index') }}#speaker">Speaker</a>
                <a href="{{ route('index') }}#agenda">Agenda</a>
                @auth
                    @if(auth()->user()->eventRegistrations()->exists())
                        <a href="{{ route('registration.success') }}">My Ticket</a>
                    @endif
                @endauth
            </nav>
            @guest
                <a href="{{ route('registration.form') }}" class="btn btn-primary nav-cta">Reserve Your Spot</a>
            @else
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-ghost nav-cta">Logout</button>
                </form>
            @endguest
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
