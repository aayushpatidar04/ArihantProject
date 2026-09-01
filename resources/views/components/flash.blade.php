{{-- resources/views/components/flash.blade.php --}}
<div id="flash-container" style="position:fixed;bottom:20px;right:20px;z-index:9999;">
    @if(session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="flash flash-error">{{ session('error') }}</div>
    @endif

    @if(session('warning'))
        <div class="flash flash-warning">{{ session('warning') }}</div>
    @endif

    @if($errors->any())
        <div class="flash flash-error">
            <ul style="margin:0;padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<style>
.flash {
    background: #0e0812;
    color: #fff;
    padding: 12px 16px;
    margin-top: 10px;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    font-size: 14px;
    animation: fadeInOut 5s forwards;
}
.flash-success { border-left: 4px solid #4caf50; }
.flash-error   { border-left: 4px solid #f44336; }
.flash-warning { border-left: 4px solid #ff9800; }

@keyframes fadeInOut {
    0%   { opacity: 0; transform: translateY(20px); }
    10%  { opacity: 1; transform: translateY(0); }
    90%  { opacity: 1; }
    100% { opacity: 0; transform: translateY(20px); }
}
</style>
