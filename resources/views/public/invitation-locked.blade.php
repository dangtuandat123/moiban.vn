@extends('layouts.app')

@section('title', 'Thiệp đã bị khóa - Mời Bạn')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4">
    <div class="text-center max-w-md">
        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-red-500/20 flex items-center justify-center">
            <i class="fa-solid fa-lock text-4xl text-red-400"></i>
        </div>
        <h1 class="text-3xl font-semibold mb-4">Thiệp đã bị khóa</h1>
        <p class="text-white/60 mb-8">
            Thiệp "{{ $invitation->title }}" đã hết thời gian dùng thử và chưa được kích hoạt.
        </p>
        
        @auth
            @if(auth()->id() === $invitation->user_id)
            <a href="{{ route('user.invitations.purchase', $invitation) }}" class="glass-btn inline-block px-8 py-3">
                <i class="fa-solid fa-unlock mr-2"></i>
                Mở khóa thiệp
            </a>
            @else
            <p class="text-white/60">Vui lòng liên hệ chủ thiệp để được hỗ trợ.</p>
            @endif
        @else
            <p class="text-white/60">Vui lòng liên hệ chủ thiệp để được hỗ trợ.</p>
        @endauth
        
        <div class="mt-8">
            <a href="{{ route('home') }}" class="text-white/60 hover:text-white">
                <i class="fa-solid fa-arrow-left mr-2"></i> Về trang chủ
            </a>
        </div>
    </div>
</div>
@endsection
