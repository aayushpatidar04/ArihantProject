<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

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

        .participant {
            padding: 15px 18px;
            background: #1d1d1d;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .participant strong {
            display: block;
            margin-bottom: 5px;
        }

        .participant span {
            color: #aaa;
            font-size: 14px;
        }

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
        }

        .option:hover {
            border-color: #555;
        }

        .option input {
            width: 17px;
            height: 17px;
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
            border-color: #666;
        }

        .error {
            color: #ff8585;
            font-size: 13px;
            margin-top: 8px;
        }

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

        .submit-wrapper {
            margin-top: 10px;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            border: 0;
            border-radius: 9px;
            background: #fff;
            color: #000;
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
        }
    </style>
</head>

<body>

<div class="page">

    <div class="container">

        <div class="header">
            <h1>Event Feedback</h1>

            <p>
                Thank you for being a part of
                <strong>ARIHANT PLUS AI & ALGO CONCLAVE</strong>.
                <br>
                We would love to hear about your experience.
            </p>
        </div>

        <div class="card">

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

            <div class="participant">
                <strong>{{ $registration->full_name }}</strong>

                <span>
                    Registration No:
                    {{ $registration->registration_number }}
                </span>
            </div>

            <form
                action="{{ route('event.feedback.store') }}"
                method="POST"
            >

                @csrf

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
                                <input
                                    type="radio"
                                    name="experience_rating"
                                    value="{{ $value }}"
                                    {{ old('experience_rating') == $value ? 'checked' : '' }}
                                >

                                {{ $label }}
                            </label>

                        @endforeach

                    </div>

                    @error('experience_rating')
                        <div class="error">{{ $message }}</div>
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
                                <input
                                    type="radio"
                                    name="session_quality"
                                    value="{{ $option }}"
                                    {{ old('session_quality') === $option ? 'checked' : '' }}
                                >

                                {{ $option }}
                            </label>

                        @endforeach

                    </div>

                    @error('session_quality')
                        <div class="error">{{ $message }}</div>
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
                                <input
                                    type="radio"
                                    name="content_usefulness"
                                    value="{{ $option }}"
                                    {{ old('content_usefulness') === $option ? 'checked' : '' }}
                                >

                                {{ $option }}
                            </label>

                        @endforeach

                    </div>

                    @error('content_usefulness')
                        <div class="error">{{ $message }}</div>
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
                                <input
                                    type="radio"
                                    name="networking_rating"
                                    value="{{ $option }}"
                                    {{ old('networking_rating') === $option ? 'checked' : '' }}
                                >

                                {{ $option }}
                            </label>

                        @endforeach

                    </div>

                    @error('networking_rating')
                        <div class="error">{{ $message }}</div>
                    @enderror

                </div>


                {{-- Q5 --}}
                <div class="question">

                    <div class="question-title">
                        5. Which session/topic did you find most valuable?
                        <span class="required">*</span>
                    </div>

                    <textarea
                        name="most_valuable_session"
                        placeholder="Your answer..."
                    >{{ old('most_valuable_session') }}</textarea>

                    @error('most_valuable_session')
                        <div class="error">{{ $message }}</div>
                    @enderror

                </div>


                {{-- Q6 --}}
                <div class="question">

                    <div class="question-title">
                        6. What did you like most about the event?
                        <span class="required">*</span>
                    </div>

                    <textarea
                        name="liked_most"
                        placeholder="Your answer..."
                    >{{ old('liked_most') }}</textarea>

                    @error('liked_most')
                        <div class="error">{{ $message }}</div>
                    @enderror

                </div>


                {{-- Q7 --}}
                <div class="question">

                    <div class="question-title">
                        7. What could we improve for future events?
                        <span class="required">*</span>
                    </div>

                    <textarea
                        name="improvements"
                        placeholder="Your answer..."
                    >{{ old('improvements') }}</textarea>

                    @error('improvements')
                        <div class="error">{{ $message }}</div>
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
                                <input
                                    type="radio"
                                    name="recommendation"
                                    value="{{ $option }}"
                                    {{ old('recommendation') === $option ? 'checked' : '' }}
                                >

                                {{ $option }}
                            </label>

                        @endforeach

                    </div>

                    @error('recommendation')
                        <div class="error">{{ $message }}</div>
                    @enderror

                </div>


                <div class="submit-wrapper">

                    <button
                        type="submit"
                        class="submit-btn"
                    >
                        Submit Feedback
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>

</html>