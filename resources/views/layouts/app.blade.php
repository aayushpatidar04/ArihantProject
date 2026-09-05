<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google Tag Manager -->

    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':

    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],

    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=

    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);

    })(window,document,'script','dataLayer','GTM-NL23JDKS');</script>

    <!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ArihantPLUS — Central India`s Largest AI & Algo Conclave')</title>
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

        /* Header & Nav */
        header{position:sticky;top:0;z-index:100;background:rgba(5,2,8,0.75);backdrop-filter:blur(14px);border-bottom:1px solid rgba(255,255,255,0.06)}
        .nav{display:flex;align-items:center;justify-content:space-between;padding:18px 24px;margin:0 15px;}
        .logo{display:flex;align-items:center;gap:8px;font-family:'Sora',sans-serif;font-weight:700;font-size:20px}
        .logo-img{height:32px;width:auto;display:block}
        nav.links{display:flex;gap:38px;font-size:15px;color:#e9e4f0}
        nav.links a{opacity:.85;transition:opacity .2s}
        nav.links a:hover{opacity:1;color:var(--purple-1)}
        .nav-cta{display:inline-flex}
        .menu-toggle{display:none;width:42px;height:42px;border-radius:12px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.14);align-items:center;justify-content:center;color:#f6f3fa;cursor:pointer;flex-shrink:0}

        /* Mobile Menu */
        .mobile-menu{position:fixed;top:0;right:-100%;width:280px;height:100vh;background:linear-gradient(180deg,#170b22 0%,#0b0511 100%);border-left:1px solid rgba(255,255,255,0.1);z-index:200;padding:80px 28px 28px;transition:right 0.35s ease;box-shadow:-20px 0 60px rgba(0,0,0,0.6)}
        .mobile-menu.active{right:0}
        .mobile-menu a{display:block;padding:14px 0;font-size:16px;color:#e9e4f0;border-bottom:1px solid rgba(255,255,255,0.06);transition:color 0.2s}
        .mobile-menu a:hover{color:var(--purple-1)}
        .mobile-menu .btn-primary{display:block;width:100%;margin-top:20px;text-align:center}
        .menu-close{position:absolute;top:18px;right:24px;width:40px;height:40px;border-radius:10px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.14);display:flex;align-items:center;justify-content:center;color:#f6f3fa;cursor:pointer}
        .menu-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);z-index:150;opacity:0;pointer-events:none;transition:opacity 0.3s}
        .menu-overlay.active{opacity:1;pointer-events:auto}

        /* Footer */
        footer{position:relative;background:linear-gradient(180deg,#0a0410 0%,#060208 100%);border-top:1px solid rgba(255,255,255,0.06);padding:60px 24px 0;overflow:hidden}
        .footer-glow{position:absolute;top:-100px;left:50%;transform:translateX(-50%);width:600px;height:200px;background:radial-gradient(ellipse,rgba(184,102,247,0.08) 0%,transparent 70%);pointer-events:none}
        .footer-main{max-width:var(--max);margin:0 auto;display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr;gap:40px;padding-bottom:40px}
        .footer-col h4{font-size:14px;font-weight:700;color:#fff;margin-bottom:16px;letter-spacing:0.5px}
        .footer-col ul{list-style:none;padding:0;margin:0}
        .footer-col ul li{margin-bottom:10px;font-size:13px;color:rgba(230,220,240,0.6);line-height:1.5}
        .footer-col ul li a{color:rgba(230,220,240,0.6);text-decoration:none;transition:color 0.2s}
        .footer-col ul li a:hover{color:#d4a5ff}
        .brand-col .footer-logo{display:flex;align-items:center;gap:10px;font-family:'Sora',sans-serif;font-size:18px;font-weight:700;color:#fff;margin-bottom:12px}
        .brand-col .footer-desc{font-size:13px;color:var(--muted);line-height:1.6;margin-bottom:20px}
        .footer-social{display:flex;gap:12px}
        .social-ic{width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;color:var(--muted);transition:all 0.2s}
        .social-ic:hover{background:rgba(184,102,247,0.1);border-color:rgba(184,102,247,0.3);color:#d4a5ff}
        .social-ic svg{width:18px;height:18px;stroke:currentColor}
        .footer-sebi{max-width:var(--max);margin:0 auto;padding:32px 0;border-top:1px solid rgba(255,255,255,0.06);border-bottom:1px solid rgba(255,255,255,0.06)}
        .footer-sebi p{font-size:12px;line-height:1.7;color:rgba(230,220,240,0.5);margin-bottom:12px}
        .footer-sebi p strong{color:rgba(230,220,240,0.75)}
        .sebi-grid{display:flex;flex-wrap:wrap;gap:8px 20px;margin-bottom:16px}
        .sebi-grid span{font-size:11px;color:rgba(230,220,240,0.45);background:rgba(255,255,255,0.03);padding:4px 10px;border-radius:6px;border:1px solid rgba(255,255,255,0.05)}
        .sebi-notice{font-style:italic;padding:12px 16px;background:rgba(255,200,0,0.04);border-left:3px solid rgba(255,200,0,0.3);border-radius:0 8px 8px 0}
        .sebi-attention{padding:12px 16px;background:rgba(40,180,100,0.04);border-left:3px solid rgba(40,180,100,0.3);border-radius:0 8px 8px 0}
        .sebi-links{display:flex;flex-wrap:wrap;gap:4px 12px;margin-top:12px}
        .sebi-links a{font-size:11px;color:rgba(184,102,247,0.7);text-decoration:none;transition:color 0.2s}
        .sebi-links a:hover{color:#d4a5ff;text-decoration:underline}
        .footer-bottom{max-width:var(--max);margin:0 auto;padding:20px 0;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;font-size:12px;color:rgba(230,220,240,0.35)}
        .footer-bottom a{color:rgba(230,220,240,0.5);text-decoration:none}
        .footer-bottom a:hover{color:#d4a5ff}
        .heart{color:#ff6b81}

        /* Responsive */
        @media(max-width:1024px){
            .footer-main{grid-template-columns:1fr 1fr;gap:32px}
        }
        @media(max-width:819px){
            nav.links,.nav-cta{display:none}
            .menu-toggle{display:flex}
        }
        @media(max-width:640px){
            .footer-main{grid-template-columns:1fr;gap:28px}
            .footer-bottom{flex-direction:column;text-align:center}
            .sebi-grid{gap:6px 10px}
            .sebi-links{flex-direction:column;gap:6px}
            .nav{padding:14px 18px}
            .logo{font-size:18px}
            .logo-img{height:28px}
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Google Tag Manager (noscript) -->

    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NL23JDKS"

    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

    <!-- End Google Tag Manager (noscript) -->
    <header>
        <div class="nav">
            <div style="display: flex; align-items: center;">
                <a href="{{ route('index') }}" class="logo" style="margin-right: 50px;"><img src="{{ asset('assets/images/logo-2.png') }}" alt="ArihantPLUS" class="logo-img"></a>
                <nav class="links">
                    <a href="{{ route('index') }}#home">Home</a>
                    <a href="{{ route('index') }}#speaker">Speaker</a>
 <a href="/quiz">Quizzes</a>
                    {{-- <a href="{{ route('index') }}#agenda">Agenda</a> --}}
                    @auth
                        @if(auth()->user()->eventRegistrations()->exists())
                            <a href="{{ route('registration.success') }}">My Ticket</a>
                        @endif
                    @endauth
                </nav>
            </div>
            @guest
                <a href="{{ route('registration.form') }}" class="btn btn-primary nav-cta">Reserve Your Spot</a>
            @else
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-ghost nav-cta">Logout</button>
                </form>
            @endguest
            <button class="menu-toggle" id="menuToggle" aria-label="Open menu">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <div class="menu-overlay" id="menuOverlay"></div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <button class="menu-close" id="menuClose" aria-label="Close menu">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
        <a href="{{ route('index') }}#home">Home</a>
        <a href="{{ route('index') }}#speaker">Speaker</a>
 <a href="/quiz">Quizzes</a>
        {{-- <a href="{{ route('index') }}#agenda">Agenda</a> --}}
        @auth
            @if(auth()->user()->eventRegistrations()->exists())
                <a href="{{ route('registration.success') }}">My Ticket</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-ghost" style="width:100%;margin-top:10px">Logout</button>
            </form>
        @else
            <a href="{{ route('registration.form') }}" class="btn btn-primary">Reserve Your Spot</a>
        @endguest
    </div>

    <main>
        @yield('content')
    </main>

    <x-flash />
    
    <!-- Footer -->
    <footer>
        <div class="footer-glow"></div>

        <div class="footer-main">
            <div class="footer-col brand-col">
                <div class="footer-logo">
                    <a href="{{ route('index') }}" class="logo"><img src="{{ asset('assets/images/logo-2.png') }}" alt="ArihantPLUS" class="logo-img"></a>
                </div>
                <p class="footer-desc">AI & Algo Conclave 2026 — Empowering investors and traders with cutting-edge technology.</p>
                <div class="footer-social">
                    <a class="social-ic" target="_blank" href="https://www.instagram.com/arihant_plus/" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.3" cy="6.7" r="1" fill="currentColor" stroke="none"/></svg>
                    </a>
                    <a class="social-ic" target="_blank" href="https://www.linkedin.com/company/arihant-capital-markets-ltd/about/?viewAsMember=true" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M7 10v7M7 7v.01M11 17v-4.5a2 2 0 014-.2M15 17v-4.5"/></svg>
                    </a>
                    <a class="social-ic" target="_blank" href="https://x.com/ArihantPlus" aria-label="X">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><path d="M4 4l16 16M20 4L4 20"/></svg>
                    </a>
                    <a class="social-ic" target="_blank" href="https://www.youtube.com/@arihant_plus" aria-label="YouTube">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="4"/><polygon points="10,8 16,12 10,16" fill="currentColor" stroke="none"/></svg>
                    </a>
                    <a class="social-ic" target="_blank" href="https://www.facebook.com/arihantcapitalmarket" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="4"/><path d="M13 10h2v-2h-2c-1.1 0-2 .9-2 2v2h-2v2h2v6h2v-6h2l1-2h-3v-2c0-.55.45-1 1-1z"/></svg>
                    </a>
                </div>
            </div>

            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ route('event.policy') }}">Event Policy</a></li>
                    <li><a href="{{ route('payment.terms') }}">Payment Terms</a></li>
                    <li><a href="{{ route('cookie.policy') }}">Cookie Policy</a></li>
                    <li><a href="{{ route('disclaimer') }}">Disclaimer & Risk Disclosure</a></li>
                    <li><a href="/login">Login</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Contact</h4>
                <ul>
                    <li><a href="mailto:compliance@arihantcapital.com">compliance@arihantcapital.com</a></li>
                    <li><a href="mailto:depository@arihantcapital.com">depository@arihantcapital.com</a></li>
                    <li>601, Atlantis Tower, Plot No. 13A, Scheme No. 78, Indore – 452010</li>
                    <li>#1011 Solitaire Corporate Park, Andheri Ghatkopar Link Road, Chakala, Andheri (E), Mumbai - 400093</li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Important Links</h4>
                <ul>
                    <li><a href="https://www.sebi.gov.in" target="_blank">SEBI</a></li>
                    <li><a href="https://www.bseindia.com" target="_blank">BSE</a></li>
                    <li><a href="https://www.nseindia.com" target="_blank">NSE</a></li>
                    <li><a href="https://www.mcxindia.com" target="_blank">MCX</a></li>
                    <li><a href="https://www.cdslindia.com" target="_blank">CDSL</a></li>
                    <li><a href="https://scores.sebi.gov.in" target="_blank">SEBI SCORES</a></li>
                    <li><a href="https://smartodr.in" target="_blank">ODR Portal</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-sebi">
            <p><strong>Arihant Capital Markets Limited</strong> is a SEBI registered stock broker and depository participant.</p>
            <div class="sebi-grid">
                <span>SEBI Stock Broker: INZ000180939</span>
                <span>DP: IN301983</span>
                <span>NSDL: IN-DP-127-2015</span>
                <span>CDSL DP ID: 43000</span>
                <span>NCDEX: 01274</span>
                <span>MCX: 56565</span>
                <span>AMFI: ARN 15114</span>
                <span>SEBI Research Analyst: INH000002764</span>
            </div>
            <p class="sebi-notice">Investments in securities market are subject to market risks; read all the related documents carefully before investing. Brokerage will not exceed the SEBI prescribed limit. The securities are quoted as an example and not as a recommendation.</p>
            <p class="sebi-attention"><strong>Attention Investors:</strong> KYC is one time exercise while dealing in securities markets. Prevent unauthorised transactions in your account — update your mobile numbers/email IDs with your stockbrokers. Receive information of your transactions directly from Exchange on your mobile/email at the end of the day. Update your Mobile Number with your Depository Participant to receive alerts for all debit and other important transactions in your demat account directly from CDSL/NSDL on the same day.</p>
            <p class="sebi-links">
                <a href="https://www.bseindia.com/investors/aperc.aspx" target="_blank">BSE Rights & Obligations</a> |
                <a href="https://www.nseindia.com/invest/resources/download-documents" target="_blank">NSE Do's & Don'ts</a> |
                <a href="https://www.mcxindia.com/investor-education" target="_blank">MCX Investor Charter</a> |
                <a href="https://www.cdslindia.com/investor-charter.aspx" target="_blank">CDSL Investor Charter</a> |
                <a href="https://smartodr.in" target="_blank">ODR Portal</a>
            </p>
        </div>

        <div class="footer-bottom">
            <span>All copyrights are reserved © Arihant Capital Markets Limited</span>
        </div>
    </footer>

    @stack('scripts')

    <script>
        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const menuClose = document.getElementById('menuClose');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuOverlay = document.getElementById('menuOverlay');

        function openMenu() {
            mobileMenu.classList.add('active');
            menuOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeMenu() {
            mobileMenu.classList.remove('active');
            menuOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        menuToggle.addEventListener('click', openMenu);
        menuClose.addEventListener('click', closeMenu);
        menuOverlay.addEventListener('click', closeMenu);
    </script>
</body>
</html>