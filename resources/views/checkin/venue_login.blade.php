<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Login — ArihantPLUS</title>
    <style>
        body{background:#060208;color:#f6f3fa;font-family:'Inter',sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0}
        .card{max-width:360px;width:100%;background:linear-gradient(165deg,#170b22 0%,#0b0511 100%);border:1px solid rgba(255,255,255,0.08);border-radius:26px;padding:40px 32px;text-align:center}
        h1{font-size:22px;font-weight:700;margin-bottom:8px}
        p{color:#a79bb5;font-size:13px;margin-bottom:28px}
        input{background:rgba(255,255,255,0.055);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:16px;color:#fff;font-size:18px;text-align:center;letter-spacing:8px;outline:none;margin-bottom:20px}
        input:focus{border-color:rgba(184,102,247,0.55)}
        button{width:60%;padding:14px;border-radius:999px;background:linear-gradient(135deg,#d43fe0,#7a1fc9);color:#fff;border:none;font-weight:600;font-size:15px;cursor:pointer}
        .error{color:#ff9e9e;font-size:13px;margin-bottom:16px}
    </style>
</head>
<body>
    <div class="card">
        <h1>🔒 Venue Access</h1>
        <p>Enter the staff PIN to open the check-in scanner.</p>
        
        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('venue.login.post') }}" method="POST">
            @csrf
            <input type="password" name="pin" placeholder="••••" maxlength="10" required autofocus>
            <button type="submit">Unlock Scanner</button>
        </form>
    </div>
</body>
</html>