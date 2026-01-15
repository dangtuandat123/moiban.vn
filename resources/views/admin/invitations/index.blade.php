@extends('layouts.admin')

@section('title', 'Quản lý Thiệp - Admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Thiệp</h1>
        <p class="text-white/60">Quản lý tất cả thiệp cưới</p>
    </div>
</div>

<!-- Filter -->
<div class="glass-card p-4 mb-6 flex flex-wrap gap-4">
    <a href="{{ route('admin.invitations.index') }}" class="px-4 py-2 rounded-lg {{ !request('status') ? 'bg-rose-gold' : 'bg-white/10' }}">
        Tất cả
    </a>
    <a href="{{ route('admin.invitations.index', ['status' => 'trial']) }}" class="px-4 py-2 rounded-lg {{ request('status') === 'trial' ? 'bg-rose-gold' : 'bg-white/10' }}">
        Trial
    </a>
    <a href="{{ route('admin.invitations.index', ['status' => 'active']) }}" class="px-4 py-2 rounded-lg {{ request('status') === 'active' ? 'bg-rose-gold' : 'bg-white/10' }}">
        Active
    </a>
    <a href="{{ route('admin.invitations.index', ['status' => 'locked']) }}" class="px-4 py-2 rounded-lg {{ request('status') === 'locked' ? 'bg-rose-gold' : 'bg-white/10' }}">
        Locked
    </a>
</div>

<div class="glass-card overflow-hidden">
    <table class="w-full">
        <thead class="border-b border-white/10">
            <tr class="text-left text-white/60 text-sm">
                <th class="p-4">ID</th>
                <th class="p-4">Tiêu đề</th>
                <th class="p-4">User</th>
                <th class="p-4">Template</th>
                <th class="p-4">Status</th>
                <th class="p-4">Views</th>
                <th class="p-4">Ngày tạo</th>
                <th class="p-4">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @foreach($invitations as $inv)
            <tr class="hover:bg-white/5">
                <td class="p-4">#{{ $inv->id }}</td>
                <td class="p-4">
                    <a href="{{ $inv->public_url }}" target="_blank" class="hover:text-rose-gold">
                        {{ Str::limit($inv->title, 25) }}
                    </a>
                </td>
                <td class="p-4 text-sm">{{ $inv->user->name ?? 'N/A' }}</td>
                <td class="p-4 text-sm text-white/60">{{ $inv->template->name ?? 'N/A' }}</td>
                <td class="p-4">
                    <span class="px-2 py-1 text-xs rounded {{ $inv->status_class }}">{{ $inv->status_label }}</span>
                </td>
                <td class="p-4">{{ number_format($inv->view_count) }}</td>
                <td class="p-4 text-sm text-white/60">{{ $inv->created_at->format('d/m/Y') }}</td>
                <td class="p-4 flex items-center space-x-2">
                    <a href="{{ route('admin.invitations.show', $inv) }}" class="text-white/60 hover:text-white">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    @if($inv->isLocked())
                    <form action="{{ route('admin.invitations.unlock', $inv) }}" method="POST" class="inline">
                        @csrf
                        <button class="text-green-400 hover:text-green-300"><i class="fa-solid fa-unlock"></i></button>
                    </form>
                    @else
                    <form action="{{ route('admin.invitations.lock', $inv) }}" method="POST" class="inline">
                        @csrf
                        <button class="text-yellow-400 hover:text-yellow-300"><i class="fa-solid fa-lock"></i></button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="p-4 border-t border-white/10">
        {{ $invitations->links() }}
    </div>
</div>
@endsection
