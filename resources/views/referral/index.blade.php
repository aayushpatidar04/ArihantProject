@extends('layouts.app')

@section('title', 'Refer & Earn — ArihantPLUS')

@push('styles')
    <style>
        .ref-page {
            min-height: 100vh;
            padding: 80px 24px 60px;
            background: var(--bg)
        }

        .ref-card {
            max-width: 720px;
            margin: 0 auto;
            background: linear-gradient(165deg, #170b22 0%, #0b0511 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 26px;
            padding: 42px 36px
        }

        .ref-card h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 8px
        }

        .ref-card>p {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 28px
        }

        .code-box {
            background: rgba(255, 255, 255, 0.04);
            border: 1px dashed rgba(184, 102, 247, 0.4);
            border-radius: 14px;
            padding: 20px;
            text-align: center;
            margin-bottom: 28px
        }

        .code-box .code {
            font-family: 'Sora', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--purple-1);
            letter-spacing: 2px
        }

        .code-box .copy-btn {
            margin-top: 12px;
            padding: 8px 18px;
            border-radius: 999px;
            background: rgba(184, 102, 247, 0.15);
            border: 1px solid rgba(184, 102, 247, 0.3);
            color: var(--purple-1);
            font-size: 13px;
            cursor: pointer
        }

        .invite-form {
            display: flex;
            gap: 10px;
            margin-bottom: 28px
        }

        .invite-form input {
            flex: 1;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 12px 14px;
            color: #fff;
            font-size: 14px;
            outline: none
        }

        .stats-row {
            display: flex;
            gap: 32px;
            margin-bottom: 32px
        }

        .stat-item {
            text-align: center
        }

        .stat-item .num {
            font-size: 28px;
            font-weight: 800;
            color: var(--purple-1);
            line-height: 1
        }

        .stat-item .lbl {
            font-size: 12px;
            color: var(--muted);
            margin-top: 4px
        }

        /* Referrals Table */
        .ref-table-wrap {
            overflow-x: auto
        }

        .ref-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px
        }

        .ref-table thead th {
            text-align: left;
            padding: 12px 16px;
            color: var(--muted);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            white-space: nowrap
        }

        .ref-table tbody td {
            padding: 14px 16px;
            color: #e9e4f0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            white-space: nowrap
        }

        .ref-table tbody tr:last-child td {
            border-bottom: none
        }

        .ref-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize
        }

        .ref-status.paid {
            background: rgba(40, 180, 100, 0.12);
            color: #8ff0b3;
            border: 1px solid rgba(40, 180, 100, 0.3)
        }

        .ref-status.pending {
            background: rgba(255, 200, 0, 0.1);
            color: #ffe08a;
            border: 1px solid rgba(255, 200, 0, 0.25)
        }

        .ref-status.registered {
            background: rgba(184, 102, 247, 0.12);
            color: #d4a5ff;
            border: 1px solid rgba(184, 102, 247, 0.25)
        }

        .empty-state {
            color: var(--muted);
            font-size: 14px;
            text-align: center;
            padding: 32px 0
        }

        /* Pagination */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            margin-top: 24px
        }

        .pagination {
            display: flex;
            gap: 6px;
            list-style: none;
            padding: 0;
            margin: 0
        }

        .pagination li a,
        .pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 12px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            text-decoration: none;
            transition: all .2s
        }

        .pagination li a:hover {
            background: rgba(184, 102, 247, 0.15);
            color: var(--purple-1);
            border-color: rgba(184, 102, 247, 0.3)
        }

        .pagination li.active span {
            background: var(--purple-1);
            color: #fff;
            border-color: var(--purple-1)
        }

        .pagination li.disabled span {
            opacity: .4;
            cursor: not-allowed
        }

        @media(max-width:600px) {
            .ref-card {
                padding: 28px 22px
            }

            .invite-form {
                flex-direction: column
            }

            .stats-row {
                gap: 20px;
                justify-content: center
            }

            .ref-table tbody td {
                padding: 12px 10px;
                font-size: 13px
            }

            .ref-table thead th {
                padding: 10px
            }
        }

        .share-tray {
            margin-bottom: 28px;
            text-align: center;
        }

        .share-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 14px;
        }

        .share-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .share-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-decoration: none;
            cursor: pointer;
            transition: all .2s;
        }

        .share-btn:hover {
            transform: translateY(-2px);
        }

        .share-btn svg {
            width: 18px;
            height: 18px;
        }

        .share-btn.wa {
            background: rgba(37, 211, 102, 0.12);
            border-color: rgba(37, 211, 102, 0.3);
            color: #25d366;
        }

        .share-btn.wa:hover {
            background: rgba(37, 211, 102, 0.2);
        }

        .share-btn.tg {
            background: rgba(0, 136, 204, 0.12);
            border-color: rgba(0, 136, 204, 0.3);
            color: #08c;
        }

        .share-btn.tg:hover {
            background: rgba(0, 136, 204, 0.2);
        }

        .share-btn.tw {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .share-btn.tw:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .share-btn.li {
            background: rgba(10, 102, 194, 0.12);
            border-color: rgba(10, 102, 194, 0.3);
            color: #0a66c2;
        }

        .share-btn.li:hover {
            background: rgba(10, 102, 194, 0.2);
        }

        .share-btn.em {
            background: rgba(234, 67, 53, 0.12);
            border-color: rgba(234, 67, 53, 0.3);
            color: #ea4335;
        }

        .share-btn.em:hover {
            background: rgba(234, 67, 53, 0.2);
        }

        .share-btn.ig {
            background: rgba(225, 48, 108, 0.12);
            border-color: rgba(225, 48, 108, 0.3);
            color: #e1306c;
        }

        .share-btn.ig:hover {
            background: rgba(225, 48, 108, 0.2);
        }

        .share-btn.more {
            background: rgba(184, 102, 247, 0.12);
            border-color: rgba(184, 102, 247, 0.3);
            color: var(--purple-1);
        }

        .share-btn.more:hover {
            background: rgba(184, 102, 247, 0.2);
        }
    </style>
@endpush

@section('content')
    <div class="ref-page">
        <div class="ref-card">
            <h1>Invite & Earn</h1>
            <p>Share your unique code. Earn 50 points for every friend who registers and pays.</p>

            @php
                $shareText = rawurlencode("You're Invited!\n\n" . $reg->full_name . " has referred you to ARIHANT PLUS AI & ALGO CONCLAVE — Central India's Largest AI & ALGO Conclave!\n\n5th September 2026\nMarriott Hotel, Indore\n10:00 AM onwards\n\nBook your ticket using the referral link shared by " . $reg->full_name . " and be a part of this exciting event!\n\nBook Now: " . route('registration.form', ['ref' => $reg->referral_code]) . "\n\nDon't miss the opportunity to explore the future of AI, Algorithmic Trading & Financial Markets!\n\nArihant Capital Markets Limited");

                $shareUrl = route('registration.form', ['ref' => $reg->referral_code]);
            @endphp

            <div class="code-box">
                <div class="code">{{ $reg->referral_code }}</div>
                <button class="copy-btn" onclick="copyLink()">Copy Referral Link</button>
            </div>

            <div class="share-tray">
                <div class="share-label">Share via</div>
                <div class="share-buttons">
                    {{-- WhatsApp --}}
                    <a href="https://wa.me/?text={{ $shareText }}" target="_blank" class="share-btn wa"
                        aria-label="WhatsApp">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        <span>WhatsApp</span>
                    </a>

                    {{-- Telegram --}}
                    <a href="https://t.me/share/url?url={{ rawurlencode($shareUrl) }}&text={{ $shareText }}" target="_blank"
                        class="share-btn tg" aria-label="Telegram">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.479.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z" />
                        </svg>
                        <span>Telegram</span>
                    </a>

                    {{-- Twitter / X --}}
                    <a href="https://twitter.com/intent/tweet?text={{ $shareText }}" target="_blank" class="share-btn tw"
                        aria-label="X">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                        </svg>
                        <span>X / Twitter</span>
                    </a>

                    {{-- LinkedIn --}}
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ rawurlencode($shareUrl) }}"
                        target="_blank" class="share-btn li" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                        <span>LinkedIn</span>
                    </a>

                    {{-- Instagram: Copy text (Instagram web doesn't support pre-filled DMs) --}}
                    <button type="button" class="share-btn ig" onclick="copyForInstagram()" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
                        </svg>
                        <span>Instagram</span>
                    </button>

                    {{-- Native Share (mobile) --}}
                    <button type="button" class="share-btn more" onclick="nativeShare()" aria-label="More">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="18" cy="5" r="3" />
                            <circle cx="6" cy="12" r="3" />
                            <circle cx="18" cy="19" r="3" />
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49" />
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49" />
                        </svg>
                        <span>More</span>
                    </button>
                </div>
            </div>

            <form class="invite-form" action="{{ route('referral.invite') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Friend's Name" required>
                <input type="email" name="email" placeholder="Friend's Email" required>
                <button type="submit" class="btn btn-primary">Invite</button>
            </form>

            <div class="stats-row">
                <div class="stat-item">
                    <div class="num">{{ $totalInvited }}</div>
                    <div class="lbl">Invited</div>
                </div>
                <div class="stat-item">
                    <div class="num">{{ $totalConverted }}</div>
                    <div class="lbl">Converted</div>
                </div>
                <div class="stat-item">
                    <div class="num">{{ $totalPoints }}</div>
                    <div class="lbl">Points</div>
                </div>
            </div>

            <div class="referrals-list">
                <h3 style="font-size:16px;margin-bottom:16px">Your Referrals</h3>

                @if($referrals->count())
                    <div class="ref-table-wrap">
                        <table class="ref-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Points</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($referrals as $r)
                                    <tr>
                                        <td>{{ $r->referred->full_name ?? '—' }}</td>
                                        <td>
                                            <span class="ref-status {{ $r->status }}">
                                                {{ ucfirst($r->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $r->points_awarded ?? 0 }}</td>
                                        <td>{{ $r->created_at?->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrap">
                        {{ $referrals->links() }}
                    </div>
                @else
                    <p class="empty-state">No referrals yet. Share your code to get started!</p>
                @endif
            </div>
        </div>
    </div>
    
    <script>
        function copyLink() {
            const link = '{{ route('registration.form', ['ref' => $reg->referral_code]) }}';
            navigator.clipboard.writeText(link).then(() => alert('Referral link copied!'));
        }

        function copyForInstagram() {
            const text = `You're Invited!\n\n{{ $reg->full_name }} has referred you to ARIHANT PLUS AI & ALGO CONCLAVE — Central India's Largest AI & ALGO Conclave!\n\n5th September 2026\nMarriott Hotel, Indore\n10:00 AM onwards\n\nBook your ticket using the referral link shared by {{ $reg->full_name }} and be a part of this exciting event!\n\nBook Now: {{ route('registration.form', ['ref' => $reg->referral_code]) }}\n\nDon't miss the opportunity to explore the future of AI, Algorithmic Trading & Financial Markets!\n\nArihant Capital Markets Limited`;
            navigator.clipboard.writeText(text).then(() => {
                alert('Text copied! Open Instagram and paste it in a DM or Story.');
            });
        }

        function nativeShare() {
            if (navigator.share) {
                navigator.share({
                    title: 'ArihantPLUS AI & Algo Conclave 2026',
                    text: `{{ $reg->full_name }} has referred you to ARIHANT PLUS AI & ALGO CONCLAVE!`,
                    url: '{{ route('registration.form', ['ref' => $reg->referral_code]) }}'
                }).catch(() => { });
            } else {
                copyLink();
            }
        }
    </script>
@endsection