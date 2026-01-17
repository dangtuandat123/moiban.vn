@extends('layouts.admin')

@section('title', 'Dashboard - Admin')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-semibold">Dashboard</h1>
    <p class="text-white/60">Tổng quan hệ thống</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="glass-card p-6">
        <div class="flex items-center justify-between mb-2">
            <i class="fa-solid fa-users text-blue-400 text-2xl"></i>
            <span class="text-xs text-green-400 bg-green-500/20 px-2 py-0.5 rounded">+{{ $newUsers }} tuần này</span>
        </div>
        <p class="text-3xl font-bold">{{ number_format($stats['total_users']) }}</p>
        <p class="text-sm text-white/60">Người dùng</p>
    </div>
    
    <div class="glass-card p-6">
        <div class="flex items-center justify-between mb-2">
            <i class="fa-solid fa-envelope text-pink-400 text-2xl"></i>
        </div>
        <p class="text-3xl font-bold">{{ number_format($stats['total_invitations']) }}</p>
        <p class="text-sm text-white/60">Tổng thiệp</p>
    </div>
    
    <div class="glass-card p-6">
        <div class="flex items-center justify-between mb-2">
            <i class="fa-solid fa-check-circle text-green-400 text-2xl"></i>
        </div>
        <p class="text-3xl font-bold">{{ number_format($stats['active_invitations']) }}</p>
        <p class="text-sm text-white/60">Thiệp active</p>
    </div>
    
    <div class="glass-card p-6">
        <div class="flex items-center justify-between mb-2">
            <i class="fa-solid fa-money-bill text-yellow-400 text-2xl"></i>
        </div>
        <p class="text-3xl font-bold">{{ number_format($monthlyRevenue, 0, ',', '.') }}đ</p>
        <p class="text-sm text-white/60">Doanh thu tháng</p>
    </div>
</div>

<!-- Revenue Chart -->
<div class="glass-card p-6 mb-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold">Biểu đồ doanh thu</h2>
            <p class="text-sm text-white/60">Tháng {{ now()->format('m/Y') }}</p>
        </div>
        <div class="text-right">
            <p class="text-2xl font-bold text-rose-gold">{{ number_format($monthlyRevenue, 0, ',', '.') }}đ</p>
            <p class="text-xs text-white/60">Tổng tháng này</p>
        </div>
    </div>
    <div class="h-64">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <!-- Recent Invitations -->
    <div class="glass-card p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold">Thiệp mới</h2>
            <a href="{{ route('admin.invitations.index') }}" class="text-sm text-rose-gold hover:underline">Xem tất cả</a>
        </div>
        <div class="space-y-3">
            @forelse($recentInvitations as $inv)
            <div class="flex items-center justify-between p-3 rounded-lg bg-white/5 hover:bg-white/10 transition">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-rose-gold/20 flex items-center justify-center">
                        <i class="fa-solid fa-envelope text-rose-gold"></i>
                    </div>
                    <div>
                        <p class="font-medium">{{ Str::limit($inv->title, 25) }}</p>
                        <p class="text-xs text-white/60">{{ $inv->user->name }} • {{ $inv->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <span class="px-2 py-1 text-xs rounded {{ $inv->status_class }}">{{ $inv->status_label }}</span>
            </div>
            @empty
            <p class="text-white/60 text-center py-4">Chưa có thiệp nào</p>
            @endforelse
        </div>
    </div>
    
    <!-- Recent Transactions -->
    <div class="glass-card p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold">Nạp tiền gần đây</h2>
        </div>
        <div class="space-y-3">
            @forelse($recentTransactions as $tx)
            <div class="flex items-center justify-between p-3 rounded-lg bg-white/5 hover:bg-white/10 transition">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center">
                        <i class="fa-solid fa-arrow-down text-green-400"></i>
                    </div>
                    <div>
                        <p class="font-medium">{{ $tx->wallet?->user?->name ?? 'N/A' }}</p>
                        <p class="text-xs text-white/60">{{ $tx->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <span class="text-green-400 font-semibold">+{{ number_format($tx->amount, 0, ',', '.') }}đ</span>
            </div>
            @empty
            <p class="text-white/60 text-center py-4">Chưa có giao dịch nào</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // Data từ controller
    const chartData = @json($dailyRevenue);
    const labels = chartData.map(item => {
        const date = new Date(item.date);
        return date.getDate() + '/' + (date.getMonth() + 1);
    });
    const data = chartData.map(item => item.total);
    
    // Tạo gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 256);
    gradient.addColorStop(0, 'rgba(183, 110, 121, 0.5)');
    gradient.addColorStop(1, 'rgba(183, 110, 121, 0)');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels.length ? labels : ['Chưa có dữ liệu'],
            datasets: [{
                label: 'Doanh thu (VND)',
                data: data.length ? data : [0],
                borderColor: '#b76e79',
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#b76e79',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#b76e79',
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return new Intl.NumberFormat('vi-VN').format(context.raw) + ' VND';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        color: 'rgba(255,255,255,0.05)'
                    },
                    ticks: {
                        color: 'rgba(255,255,255,0.5)'
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(255,255,255,0.05)'
                    },
                    ticks: {
                        color: 'rgba(255,255,255,0.5)',
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN', { notation: 'compact' }).format(value);
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
