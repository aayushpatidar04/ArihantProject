@extends('layouts.app')

@section('title', 'Create Stall — Admin')

@push('styles')
<style>
    .admin-page {
        min-height: 100vh;
        padding: 40px 24px 70px;
        background: var(--bg-soft);
    }

    .admin-wrap {
        max-width: 900px;
        margin: 0 auto;
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 28px;
    }

    .admin-header h1 {
        font-size: 28px;
        margin-bottom: 6px;
    }

    .admin-header p {
        color: var(--muted);
        font-size: 14px;
    }

    .admin-card {
        background: linear-gradient(
            160deg,
            rgba(22, 12, 30, 0.9) 0%,
            rgba(8, 4, 12, 0.96) 100%
        );
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 20px;
        padding: 28px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group-full {
        grid-column: 1 / -1;
    }

    label {
        font-size: 13px;
        font-weight: 600;
        color: #e9e1f1;
    }

    label span {
        color: #ff84d8;
    }

    input[type="text"],
    textarea {
        width: 100%;
        background: rgba(255, 255, 255, 0.045);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 13px 15px;
        color: var(--ink);
        font-family: inherit;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    textarea {
        resize: vertical;
        min-height: 120px;
    }

    input[type="text"]:focus,
    textarea:focus {
        border-color: rgba(184, 102, 247, 0.7);
        box-shadow: 0 0 0 3px rgba(184, 102, 247, 0.1);
    }

    .toggle-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        cursor: pointer;
        padding: 14px;
        background: rgba(255, 255, 255, 0.025);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 12px;
    }

    .toggle-row input {
        margin-top: 3px;
        accent-color: #b866f7;
        width: 17px;
        height: 17px;
    }

    .toggle-text {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .toggle-text strong {
        font-size: 14px;
        color: var(--ink);
    }

    .toggle-text small {
        color: var(--muted);
        font-size: 12px;
        line-height: 1.5;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 30px;
        padding-top: 22px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }

    .field-error {
        font-size: 12px;
        color: #ff9e9e;
    }

    @media (max-width: 640px) {
        .admin-page {
            padding: 28px 16px 50px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .admin-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .form-actions .btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="admin-page">
    <div class="admin-wrap">

        <div class="admin-header">
            <div>
                <h1>Create Stall</h1>
                <p>Add a new event stall and generate its unique QR identity.</p>
            </div>

            <a href="{{ route('admin.stalls.index') }}" class="btn btn-ghost">
                ← Back to Stalls
            </a>
        </div>

        <div class="admin-card">
            <form
                method="POST"
                action="{{ route('admin.stalls.store') }}"
            >
                @include('admin.stalls.partials.form')
            </form>
        </div>

    </div>
</div>
@endsection