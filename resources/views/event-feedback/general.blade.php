<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Event Feedback | ARIHANT PLUS AI & ALGO CONCLAVE</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #080808;
            color: #fff;
        }

        .page {
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 850px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-logo {
            display: block;
            width: min(220px, 70vw);
            height: auto;
            margin: 0 auto 24px;
        }

        .header h1 {
            margin: 0 0 10px;
            font-size: 30px;
        }

        .header p {
            margin: 0;
            color: #aaa;
            line-height: 1.6;
        }

        .card {
            background: #151515;
            border: 1px solid #292929;
            border-radius: 16px;
            padding: 30px;
        }

        /*
        |--------------------------------------------------------------------------
        | Step Indicator
        |--------------------------------------------------------------------------
        */

        .steps {
            display: flex;
            align-items: center;
            margin-bottom: 32px;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #777;
            font-size: 14px;
            font-weight: 600;
        }

        .step-number {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid #444;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 14px;
        }

        .step.active {
            color: #fff;
        }

        .step.active .step-number {
            background: linear-gradient(135deg,
                    #7b2ff7,
                    #b63cff);

            border-color: #9a4dff;
        }

        .step.completed .step-number {
            background: #7b2ff7;
            border-color: #7b2ff7;
        }

        .step-line {
            flex: 1;
            height: 1px;
            background: #333;
            margin: 0 15px;
        }

        /*
        |--------------------------------------------------------------------------
        | Form Steps
        |--------------------------------------------------------------------------
        */

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
        }

        /*
        |--------------------------------------------------------------------------
        | Participant Fields
        |--------------------------------------------------------------------------
        */

        .field-group {
            margin-bottom: 22px;
        }

        .field-group label {
            display: block;
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 9px;
        }

        .field-group input {
            width: 100%;

            padding: 14px 15px;

            border-radius: 9px;

            border: 1px solid #333;

            background: #101010;

            color: #fff;

            font-size: 15px;

            outline: none;
        }

        .field-group input:focus {
            border-color: #8b2fd9;
            box-shadow: 0 0 0 3px rgba(139, 47, 217, .12);
        }

        .field-group input::placeholder {
            color: #666;
        }

        /*
        |--------------------------------------------------------------------------
        | Questions
        |--------------------------------------------------------------------------
        */

        .question {
            margin-bottom: 32px;
        }

        .question-title {
            font-size: 17px;
            font-weight: 600;
            margin-bottom: 14px;
            line-height: 1.5;
        }

        .required {
            color: #ff6b6b;
        }

        .options {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .option {
            display: flex;
            align-items: center;
            gap: 10px;

            padding: 12px 14px;

            background: #1d1d1d;

            border: 1px solid #303030;

            border-radius: 8px;

            cursor: pointer;

            transition: .2s ease;
        }

        .option:hover {
            border-color: #8b2fd9;
        }

        .option input {
            width: 17px;
            height: 17px;

            accent-color: #8b2fd9;
        }

        textarea {

            width: 100%;

            min-height: 120px;

            resize: vertical;

            padding: 14px;

            border-radius: 8px;

            border: 1px solid #333;

            background: #101010;

            color: #fff;

            font-size: 15px;

            outline: none;
        }

        textarea:focus {
            border-color: #8b2fd9;
        }

        textarea::placeholder {
            color: #666;
        }

        .error {

            color: #ff8585;

            font-size: 13px;

            margin-top: 8px;
        }

        /*
        |--------------------------------------------------------------------------
        | Alerts
        |--------------------------------------------------------------------------
        */

        .alert {

            padding: 14px 16px;

            border-radius: 8px;

            margin-bottom: 20px;
        }

        .alert-success {

            background: rgba(50, 180, 100, .12);

            border: 1px solid rgba(50, 180, 100, .3);

            color: #8ff0b3;
        }

        .alert-error {

            background: rgba(255, 80, 80, .12);

            border: 1px solid rgba(255, 80, 80, .3);

            color: #ffaaaa;
        }

        /*
        |--------------------------------------------------------------------------
        | Buttons
        |--------------------------------------------------------------------------
        */

        .button-row {

            display: flex;

            gap: 12px;

            margin-top: 25px;
        }

        .btn {

            border: 0;

            border-radius: 9px;

            padding: 15px 22px;

            font-size: 16px;

            font-weight: 700;

            cursor: pointer;

            transition: .2s ease;
        }

        .btn-primary {

            flex: 1;

            background: linear-gradient(135deg,
                    #7b2ff7,
                    #b63cff);

            color: #fff;
        }

        .btn-primary:hover {

            opacity: .9;

            transform: translateY(-1px);
        }

        .btn-secondary {

            background: #222;

            border: 1px solid #333;

            color: #fff;
        }

        .btn-secondary:hover {

            background: #292929;
        }

        .submit-btn {

            width: 100%;

            padding: 15px;

            border: 0;

            border-radius: 9px;

            background: linear-gradient(135deg,
                    #7b2ff7,
                    #b63cff);

            color: #fff;

            font-size: 16px;

            font-weight: 700;

            cursor: pointer;
        }

        .submit-btn:hover {

            opacity: .9;
        }


        @media (max-width: 600px) {

            .page {
                padding: 20px 12px;
            }

            .card {
                padding: 20px;
            }

            .header h1 {
                font-size: 24px;
            }

            .steps {
                margin-bottom: 25px;
            }

            .step {
                font-size: 12px;
            }

            .step-line {
                margin: 0 8px;
            }

        }
    </style>

</head>


<body>


    <div class="page">

        <div class="container">


            {{-- HEADER --}}

            <div class="header">

                <img src="{{ asset('assets/images/logo-2.png') }}" alt="ArihantPLUS" class="brand-logo">

                <h1>Event Feedback</h1>

                <p>

                    Thank you for being a part of

                    <strong>
                        ARIHANT PLUS AI & ALGO CONCLAVE
                    </strong>.

                    <br>

                    We would love to hear about your experience.

                </p>

            </div>



            <div class="card">


                {{-- STEP INDICATOR --}}

                <div class="steps">

                    <div class="step active" id="stepIndicator1">

                        <div class="step-number">
                            1
                        </div>

                        <span>
                            Your Details
                        </span>

                    </div>


                    <div class="step-line"></div>


                    <div class="step" id="stepIndicator2">

                        <div class="step-number">
                            2
                        </div>

                        <span>
                            Feedback
                        </span>

                    </div>

                </div>



                @if(session('success'))

                    <div class="alert alert-success">

                        {{ session('success') }}

                    </div>

                @endif



                @if(session('error'))

                    <div class="alert alert-error">

                        {{ session('error') }}

                    </div>

                @endif



                <form action="{{ route('event-feedback-store') }}" method="POST" id="feedbackForm">

                    @csrf


                    {{-- =========================================================
                    STEP 1
                    ========================================================= --}}


                    <div class="form-step active" id="step1">


                        <div class="question-title" style="font-size:20px;margin-bottom:25px;">

                            Tell us about yourself

                        </div>



                        {{-- NAME --}}

                        <div class="field-group">

                            <label>

                                Full Name

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <input type="text" name="full_name" value="{{ old('full_name') }}"
                                placeholder="Enter your full name" required>


                            @error('full_name')

                                <div class="error">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- EMAIL --}}

                        <div class="field-group">

                            <label>

                                Email Address

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="Enter your email address" required>


                            @error('email')

                                <div class="error">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- MOBILE --}}

                        <div class="field-group">

                            <label>

                                Mobile Number

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <input type="tel" name="phone" value="{{ old('phone') }}"
                                placeholder="Enter your mobile number" required maxlength="15">


                            @error('phone')

                                <div class="error">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- CITY --}}

                        <div class="field-group">

                            <label>

                                City

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <input type="text" name="city" value="{{ old('city') }}" placeholder="Enter your city"
                                required>


                            @error('city')

                                <div class="error">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        <div class="button-row">

                            <button type="button" class="btn btn-primary" id="nextBtn">

                                Continue to Feedback →

                            </button>

                        </div>


                    </div>



                    {{-- =========================================================
                    STEP 2
                    ========================================================= --}}


                    <div class="form-step" id="step2">



                        {{-- Q1 --}}

                        <div class="question">

                            <div class="question-title">

                                1. How would you rate your experience at
                                ARIHANT PLUS AI & ALGO CONCLAVE?

                                <span class="required">*</span>

                            </div>


                            <div class="options">

                                @foreach([

                                        5 => 'Excellent',

                                        4 => 'Very Good',

                                        3 => 'Good',

                                        2 => 'Average',

                                        1 => 'Poor',

                                    ] as $value => $label)


                                    <label class="option">

                                        <input type="radio" name="experience_rating" value="{{ $value }}" {{ old('experience_rating') == $value ? 'checked' : '' }} required>

                                        {{ $label }}

                                    </label>


                                @endforeach

                            </div>


                            @error('experience_rating')

                                <div class="error">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- Q2 --}}

                        <div class="question">

                            <div class="question-title">

                                2. How would you rate the quality and relevance
                                of the sessions?

                                <span class="required">*</span>

                            </div>


                            <div class="options">

                                @foreach([

                                        'Excellent',

                                        'Very Good',

                                        'Good',

                                        'Average',

                                        'Poor',

                                    ] as $option)


                                    <label class="option">

                                        <input type="radio" name="session_quality" value="{{ $option }}" {{ old('session_quality') === $option ? 'checked' : '' }} required>

                                        {{ $option }}

                                    </label>


                                @endforeach

                            </div>


                            @error('session_quality')

                                <div class="error">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- Q3 --}}

                        <div class="question">

                            <div class="question-title">

                                3. How useful did you find the content related to
                                AI, Algorithmic Trading and Financial Markets?

                                <span class="required">*</span>

                            </div>


                            <div class="options">

                                @foreach([

                                        'Extremely Useful',

                                        'Very Useful',

                                        'Useful',

                                        'Slightly Useful',

                                        'Not Useful',

                                    ] as $option)


                                    <label class="option">

                                        <input type="radio" name="content_usefulness" value="{{ $option }}" {{ old('content_usefulness') === $option ? 'checked' : '' }} required>

                                        {{ $option }}

                                    </label>


                                @endforeach

                            </div>


                            @error('content_usefulness')

                                <div class="error">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- Q4 --}}

                        <div class="question">

                            <div class="question-title">

                                4. How would you rate the networking opportunities
                                at the event?

                                <span class="required">*</span>

                            </div>


                            <div class="options">

                                @foreach([

                                        'Excellent',

                                        'Very Good',

                                        'Good',

                                        'Average',

                                        'Poor',

                                        'Not Applicable',

                                    ] as $option)


                                    <label class="option">

                                        <input type="radio" name="networking_rating" value="{{ $option }}" {{ old('networking_rating') === $option ? 'checked' : '' }} required>

                                        {{ $option }}

                                    </label>


                                @endforeach

                            </div>


                            @error('networking_rating')

                                <div class="error">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- Q5 --}}

                        <div class="question">

                            <div class="question-title">

                                5. Which session/topic did you find most valuable?

                                <span class="required">*</span>

                            </div>


                            <textarea name="most_valuable_session" placeholder="Your answer..."
                                required>{{ old('most_valuable_session') }}</textarea>


                            @error('most_valuable_session')

                                <div class="error">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- Q6 --}}

                        <div class="question">

                            <div class="question-title">

                                6. What did you like most about the event?

                                <span class="required">*</span>

                            </div>


                            <textarea name="liked_most" placeholder="Your answer..."
                                required>{{ old('liked_most') }}</textarea>


                            @error('liked_most')

                                <div class="error">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- Q7 --}}

                        <div class="question">

                            <div class="question-title">

                                7. What could we improve for future events?

                                <span class="required">*</span>

                            </div>


                            <textarea name="improvements" placeholder="Your answer..."
                                required>{{ old('improvements') }}</textarea>


                            @error('improvements')

                                <div class="error">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- Q8 --}}

                        <div class="question">

                            <div class="question-title">

                                8. Would you recommend Arihant Capital and their
                                services to your friends, colleagues or fellow
                                market participants?

                                <span class="required">*</span>

                            </div>


                            <div class="options">

                                @foreach([

                                        'Definitely Yes',

                                        'Probably Yes',

                                        'Maybe',

                                        'Probably No',

                                        'Definitely No',

                                    ] as $option)


                                    <label class="option">

                                        <input type="radio" name="recommendation" value="{{ $option }}" {{ old('recommendation') === $option ? 'checked' : '' }} required>

                                        {{ $option }}

                                    </label>


                                @endforeach

                            </div>


                            @error('recommendation')

                                <div class="error">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- BUTTONS --}}

                        <div class="button-row">


                            <button type="button" class="btn btn-secondary" id="backBtn">

                                ← Back

                            </button>



                            <button type="submit" class="btn btn-primary">

                                Submit Feedback

                            </button>


                        </div>


                    </div>


                </form>


            </div>

        </div>

    </div>



    <script>

        const step1 = document.getElementById('step1');

        const step2 = document.getElementById('step2');


        const nextBtn = document.getElementById('nextBtn');

        const backBtn = document.getElementById('backBtn');


        const stepIndicator1 =
            document.getElementById('stepIndicator1');


        const stepIndicator2 =
            document.getElementById('stepIndicator2');



        /*
        |--------------------------------------------------------------------------
        | NEXT STEP
        |--------------------------------------------------------------------------
        */

        nextBtn.addEventListener('click', function () {


            const fullName =
                document.querySelector('[name="full_name"]');


            const email =
                document.querySelector('[name="email"]');


            const phone =
                document.querySelector('[name="phone"]');


            const city =
                document.querySelector('[name="city"]');


            /*
            |--------------------------------------------------------------------------
            | Validate Step 1
            |--------------------------------------------------------------------------
            */

            if (!fullName.checkValidity()) {

                fullName.reportValidity();

                return;

            }


            if (!email.checkValidity()) {

                email.reportValidity();

                return;

            }


            if (!phone.checkValidity()) {

                phone.reportValidity();

                return;

            }


            if (!city.checkValidity()) {

                city.reportValidity();

                return;

            }



            /*
            |--------------------------------------------------------------------------
            | Show Step 2
            |--------------------------------------------------------------------------
            */

            step1.classList.remove('active');

            step2.classList.add('active');


            stepIndicator1.classList.remove('active');

            stepIndicator1.classList.add('completed');


            stepIndicator2.classList.add('active');


            /*
            |--------------------------------------------------------------------------
            | Scroll Top
            |--------------------------------------------------------------------------
            */

            window.scrollTo({

                top: 0,

                behavior: 'smooth'

            });


        });



        /*
        |--------------------------------------------------------------------------
        | BACK STEP
        |--------------------------------------------------------------------------
        */

        backBtn.addEventListener('click', function () {


            step2.classList.remove('active');

            step1.classList.add('active');


            stepIndicator2.classList.remove('active');


            stepIndicator1.classList.remove('completed');

            stepIndicator1.classList.add('active');


            window.scrollTo({

                top: 0,

                behavior: 'smooth'

            });


        });


        /*
        |--------------------------------------------------------------------------
        | If Laravel validation fails on Step 2
        |--------------------------------------------------------------------------
        |
        | If any feedback field has an error,
        | automatically reopen Step 2.
        |
        */

        @if(
                $errors->has('experience_rating') ||
                $errors->has('session_quality') ||
                $errors->has('content_usefulness') ||
                $errors->has('networking_rating') ||
                $errors->has('most_valuable_session') ||
                $errors->has('liked_most') ||
                $errors->has('improvements') ||
                $errors->has('recommendation')
            )

            step1.classList.remove('active');

            step2.classList.add('active');


            stepIndicator1.classList.remove('active');

            stepIndicator1.classList.add('completed');


            stepIndicator2.classList.add('active');

        @endif


    </script>


</body>

</html>