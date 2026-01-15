@extends('layouts.admin')

@section('title', 'Chi tiết User - Admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="text-white/60 hover:text-white">
        <i class="fa-solid fa-arrow-left mr-2"></i> Quay lại
    </a>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <!-- User Info -->
    <div class="glass-card p-6">
        <h2 class="text-lg font-semibold mb-4">Thông tin</h2>
        <div class="space-y-4">
            <div>
                <p class="text-sm text-white/60">Tên</p>
                <p class="font-medium">{{ $user->name }}</p>
            </div>
            <div>
                <p class="text-sm text-white/60">Email</p>
                <p>{{ $user->email }}</p>
            </div>
            <div>
                <p class="text-sm text-white/60">SĐT</p>
                <p>{{ $user->phone ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-white/60">Role</p>
                <span class="px-2 py-1 text-xs rounded {{ $user->role === 'admin' ? 'bg-purple-500/20 text-purple-400' : 'bg-blue-500/20 text-blue-400' }}">
                    {{ $user->role }}
                </span>
            </div>
            <div>
                <p class="text-sm text-white/60">Số dư ví</p>
                <p class="text-xl font-bold text-green-400">{{ number_format($user->wallet_balance, 0, ',', '.') }}đ</p>
            </div>
        </div>
    </div>
    
    <!-- Invitations -->
    <div class="lg:col-span-2 glass-card p-6">
        <h2 class="text-lg font-semibold mb-4">Thiệp gần đây</h2>
        <div class="space-y-3">
            @forelse($user->invitations as $inv)
            <div class="flex items-center justify-between p-3 rounded-lg bg-white/5">
                <div>
                    <p class="font-medium">{{ $inv->title }}</p>
                    <p class="text-xs text-white/60">{{ $inv->template->name ?? 'N/A' }}</p>
                </div>
                <span class="px-2 py-1 text-xs rounded {{ $inv->status_class }}">{{ $inv->status_label }}</span>
            </div>
            @empty
            <p class="text-white/60 text-center py-4">Chưa có thiệp</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
