@extends('layouts.app')

@section('title', 'Submit Post — ArihantPLUS')

@push('styles')
<style>
    .influencer-page {
        min-height: 100vh;
        padding: 40px 24px 70px;
        background: var(--bg-soft);
    }

    .influencer-wrap {
        max-width: 700px;
        margin: 0 auto;
    }

    .page-header {
        margin-bottom: 25px;
    }

    .page-header h1 {
        font-size: 28px;
        margin-bottom: 6px;
    }

    .page-header p {
        color: var(--muted);
        font-size: 14px;
    }

    .form-card {
        background: linear-gradient(
            160deg,
            rgba(22,12,30,.9),
            rgba(8,4,12,.96)
        );
        border: 1px solid rgba(255,255,255,.07);
        border-radius: 20px;
        padding: 28px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        color: #ded7e6;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px;
        border-radius: 10px;
        border: 1px solid rgba(255,255,255,.1);
        background: rgba(255,255,255,.04);
        color: var(--ink);
        outline: none;
    }

    .form-control:focus {
        border-color: rgba(184,102,247,.6);
    }

    select.form-control option {
        background: #160c1e;
    }

    .form-error {
        color: #ffaaaa;
        font-size: 12px;
        margin-top: 6px;
    }

    .form-help {
        color: var(--muted);
        font-size: 12px;
        margin-top: 6px;
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-top: 28px;
    }

    @media(max-width:640px) {
        .influencer-page {
            padding: 28px 16px 50px;
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

<div class="influencer-page">

    <div class="influencer-wrap">

        <div class="page-header">

            <h1>Submit Event Post</h1>

            <p>
                Submit your social media post for admin approval.
            </p>

        </div>

        <div class="form-card">

            <form
                method="POST"
                action="{{ route('influencer.posts.store') }}"
            >

                @csrf

                <div class="form-group">

                    <label for="platform">
                        Platform
                    </label>

                    <select
                        id="platform"
                        name="platform"
                        class="form-control"
                        required
                    >

                        <option value="">
                            Select platform
                        </option>

                        <option
                            value="instagram"
                            @selected(old('platform') === 'instagram')
                        >
                            Instagram
                        </option>

                        <option
                            value="facebook"
                            @selected(old('platform') === 'facebook')
                        >
                            Facebook
                        </option>

                        <option
                            value="youtube"
                            @selected(old('platform') === 'youtube')
                        >
                            YouTube
                        </option>

                        <option
                            value="x"
                            @selected(old('platform') === 'x')
                        >
                            X
                        </option>

                        <option
                            value="linkedin"
                            @selected(old('platform') === 'linkedin')
                        >
                            LinkedIn
                        </option>

                    </select>

                    @error('platform')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="form-group">

                    <label for="post_type">
                        Post Type
                    </label>

                    <select
                        id="post_type"
                        name="post_type"
                        class="form-control"
                        required
                    >

                        <option value="">
                            Select post type
                        </option>

                        <option
                            value="reel"
                            @selected(old('post_type') === 'reel')
                        >
                            Reel
                        </option>

                        <option
                            value="post"
                            @selected(old('post_type') === 'post')
                        >
                            Post
                        </option>

                        <option
                            value="video"
                            @selected(old('post_type') === 'video')
                        >
                            Video
                        </option>

                        <option
                            value="story"
                            @selected(old('post_type') === 'story')
                        >
                            Story
                        </option>

                    </select>

                    @error('post_type')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="form-group">

                    <label for="post_url">
                        Post URL
                    </label>

                    <input
                        type="url"
                        id="post_url"
                        name="post_url"
                        class="form-control"
                        value="{{ old('post_url') }}"
                        placeholder="https://..."
                        required
                    >

                    <div class="form-help">
                        Paste the public URL of your event post.
                    </div>

                    @error('post_url')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="form-actions">

                    <a
                        href="{{ route('influencer.dashboard') }}"
                        class="btn btn-light"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Submit for Approval
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection