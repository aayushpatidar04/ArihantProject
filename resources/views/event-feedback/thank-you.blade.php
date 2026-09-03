<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Thank You | ARIHANT PLUS</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #080808;
            color: #fff;
            font-family: Arial, Helvetica, sans-serif;
            padding: 20px;
        }

        .card {
            max-width: 550px;
            width: 100%;
            text-align: center;
            background: #151515;
            border: 1px solid #292929;
            border-radius: 16px;
            padding: 45px 30px;
        }

        .brand-logo {
            display: block;
            width: min(220px, 70vw);
            height: auto;
            margin: 0 auto 30px;
        }

        .icon {
            font-size: 50px;
            margin-bottom: 20px;
        }

        h1 {
            margin: 0 0 15px;
        }

        p {
            color: #aaa;
            line-height: 1.7;
        }

        .home-button {
            display: inline-block;
            margin-top: 16px;
            padding: 13px 24px;
            border-radius: 9px;
            background: #fff;
            color: #000;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
        }

        .home-button:hover {
            opacity: .9;
        }
    </style>
</head>

<body>

    <div class="card">

        <img src="{{ asset('assets/images/logo-2.png') }}" alt="ArihantPLUS" class="brand-logo">

        <div class="icon">✓</div>

        <h1>Thank You!</h1>

        <p>
            Your feedback has already been submitted.
            We truly appreciate you taking the time to share your experience
            with us.
        </p>

        <a href="{{ route('index') }}" class="home-button">Go to Home</a>

    </div>

</body>

</html>