@extends('layouts.app')

@section('title', 'Thiệp đã hết hạn - Mời Bạn')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4">
    <div class="text-center max-w-md">
        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-500/20 flex items-center justify-center">
            <i class="fa-solid fa-clock text-4xl text-gray-400"></i>
        </div>
        <h1 class="text-3xl font-semibold mb-4">Thiệp đã hết hạn</h1>
        <p class="text-white/60 mb-8">
            Thiệp "{{ $invitation->title }}" đã hết thời hạn sử dụng.
        </p>
        
        @auth
            @if(auth()->id() === $invitation->user_id)
            <a href="{{ route('user.invitations.purchase', $invitation) }}" class="glass-btn inline-block px-8 py-3">
                <i class="fa-solid fa-rotate mr-2"></i>
                Gia hạn thiệp
            </a>
            @endif
        @endauth
        
        <div class="mt-8">
            <a href="{{ route('home') }}" class="text-white/60 hover:text-white">
                <i class="fa-solid fa-arrow-left mr-2"></i> Về trang chủ
            </a>
        </div>
    </div>
</div>
@endsection
