@extends('layouts.admin')

@section('title', 'Quản lý Users - Admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Người dùng</h1>
        <p class="text-white/60">Quản lý tài khoản người dùng</p>
    </div>
</div>

<div class="glass-card overflow-hidden">
    <table class="w-full">
        <thead class="border-b border-white/10">
            <tr class="text-left text-white/60 text-sm">
                <th class="p-4">ID</th>
                <th class="p-4">Tên</th>
                <th class="p-4">Email</th>
                <th class="p-4">Role</th>
                <th class="p-4">Số thiệp</th>
                <th class="p-4">Ngày tạo</th>
                <th class="p-4">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @foreach($users as $user)
            <tr class="hover:bg-white/5 {{ $user->trashed() ? 'opacity-50' : '' }}">
                <td class="p-4">#{{ $user->id }}</td>
                <td class="p-4">{{ $user->name }}</td>
                <td class="p-4">{{ $user->email }}</td>
                <td class="p-4">
                    <span class="px-2 py-1 text-xs rounded {{ $user->role === 'admin' ? 'bg-purple-500/20 text-purple-400' : 'bg-blue-500/20 text-blue-400' }}">
                        {{ $user->role }}
                    </span>
                </td>
                <td class="p-4">{{ $user->invitations_count }}</td>
                <td class="p-4 text-sm text-white/60">{{ $user->created_at->format('d/m/Y') }}</td>
                <td class="p-4">
                    <a href="{{ route('admin.users.show', $user) }}" class="text-white/60 hover:text-white mr-3">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="p-4 border-t border-white/10">
        {{ $users->links() }}
    </div>
</div>
@endsection
