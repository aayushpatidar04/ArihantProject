@extends('layouts.app')

@section('title', 'Edit Influencer — Admin')

@push('styles')
    <style>
        .admin-page {
            min-height: 100vh;
            padding: 40px 24px 70px;
            background: var(--bg-soft);
        }

        .admin-wrap {
            max-width: 760px;
            margin: 0 auto;
        }

        .admin-header {
            margin-bottom: 28px;
        }

        .admin-header h1 {
            font-size: 30px;
            margin-bottom: 6px;
        }

        .admin-header p {
            color: var(--muted);
            font-size: 14px;
        }

        .admin-card {
            background: linear-gradient(160deg,
                    rgba(22, 12, 30, 0.9),
                    rgba(8, 4, 12, 0.96));
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 20px;
            padding: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: var(--ink);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.04);
            color: var(--ink);
            outline: none;
        }

        .form-control:focus {
            border-color: rgba(184, 102, 247, 0.55);
        }

        .form-help {
            margin-top: 6px;
            color: var(--muted);
            font-size: 12px;
        }

        .form-error {
            margin-top: 6px;
            color: #ff9b9b;
            font-size: 12px;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-top: 28px;
        }

        .back-link {
            color: var(--purple-1);
            font-size: 14px;
            text-decoration: none;
        }

        @media (max-width: 600px) {
            .admin-page {
                padding: 28px 16px 50px;
            }

            .admin-card {
                padding: 20px;
            }

            .form-actions {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .form-actions .btn,
            .back-link {
                width: 100%;
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')

    <div class="admin-page">

        <div class="admin-wrap">

            <div class="admin-header">

                <h1>Edit Influencer</h1>

                <p>
                    Update {{ $user->name }}'s account information.
                </p>

            </div>

            <div class="admin-card">

                <form method="POST" action="{{ route('admin.influencers.update', $user) }}">

                    @csrf
                    @method('PUT')

                    <div class="form-group">

                        <label class="form-label">
                            Influencer Name
                        </label>

                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>

                        @error('name')
                            <div class="form-error">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            Email Address
                        </label>

                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                            required>

                        @error('email')
                            <div class="form-error">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            New Password
                        </label>

                        <input type="password" name="password" class="form-control"
                            placeholder="Leave blank to keep current password">

                        <div class="form-help">
                            Only enter a password if you want to change it.
                        </div>

                        @error('password')
                            <div class="form-error">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            Confirm New Password
                        </label>

                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Re-enter new password">

                    </div>

                    <div class="form-actions">

                        <a href="{{ route('admin.influencers.show', $user) }}" class="back-link">
                            ← Back to Influencer
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Save Changes
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection