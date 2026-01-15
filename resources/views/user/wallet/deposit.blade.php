@extends('layouts.app')

@section('title', 'Nạp tiền - Mời Bạn')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('user.wallet') }}" class="text-white/60 hover:text-white mb-4 inline-block">
            <i class="fa-solid fa-arrow-left mr-2"></i> Quay lại
        </a>
        <h1 class="text-3xl font-semibold">Nạp tiền vào ví</h1>
        <p class="text-white/60 mt-1">Quét mã QR để nạp tiền nhanh chóng</p>
    </div>
    
    <!-- QR Code Card -->
    <div class="glass-card p-8 text-center mb-6">
        <div class="mb-4">
            <img src="{{ $qrUrl }}" alt="VietQR" class="mx-auto rounded-xl max-w-xs w-full">
        </div>
        <p class="text-lg font-semibold mb-2">Quét mã QR để nạp tiền</p>
        <p class="text-white/60 text-sm">Hỗ trợ tất cả các ứng dụng ngân hàng</p>
    </div>
    
    <!-- Instructions -->
    <div class="glass-card p-6">
        <h2 class="text-lg font-semibold mb-4">Hướng dẫn nạp tiền</h2>
        
        <div class="space-y-4">
            <div class="flex items-start space-x-4">
                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-rose-gold/20 flex items-center justify-center text-rose-gold font-semibold">1</span>
                <div>
                    <p class="font-medium">Mở ứng dụng ngân hàng</p>
                    <p class="text-sm text-white/60">Momo, ViettelPay, ZaloPay hoặc app của ngân hàng</p>
                </div>
            </div>
            
            <div class="flex items-start space-x-4">
                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-rose-gold/20 flex items-center justify-center text-rose-gold font-semibold">2</span>
                <div>
                    <p class="font-medium">Quét mã QR ở trên</p>
                    <p class="text-sm text-white/60">Chọn chức năng quét mã và hướng camera vào mã QR</p>
                </div>
            </div>
            
            <div class="flex items-start space-x-4">
                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-rose-gold/20 flex items-center justify-center text-rose-gold font-semibold">3</span>
                <div>
                    <p class="font-medium">Xác nhận chuyển khoản</p>
                    <p class="text-sm text-white/60">Nhập số tiền muốn nạp và xác nhận</p>
                </div>
            </div>
            
            <div class="flex items-start space-x-4">
                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center text-green-400 font-semibold">✓</span>
                <div>
                    <p class="font-medium">Tiền sẽ vào ví tự động</p>
                    <p class="text-sm text-white/60">Thường trong vòng 1-5 phút. Bạn sẽ nhận được thông báo.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Important Note -->
    <div class="glass-card p-6 mt-6 border-l-4 border-yellow-500">
        <div class="flex items-start space-x-4">
            <i class="fa-solid fa-exclamation-triangle text-yellow-400 text-xl"></i>
            <div>
                <h3 class="font-semibold mb-1">Lưu ý quan trọng</h3>
                <p class="text-sm text-white/60">
                    Vui lòng <strong class="text-white">KHÔNG sửa nội dung chuyển khoản</strong>. 
                    Mã <code class="bg-white/10 px-2 py-0.5 rounded">{{ $depositInfo }}</code> giúp hệ thống xác định tài khoản của bạn.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
