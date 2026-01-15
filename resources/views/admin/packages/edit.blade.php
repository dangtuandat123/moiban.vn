@extends('layouts.admin')

@section('title', 'Sửa Gói - Admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.packages.index') }}" class="text-white/60 hover:text-white">
        <i class="fa-solid fa-arrow-left mr-2"></i> Quay lại
    </a>
</div>

<div class="max-w-2xl">
    <h1 class="text-2xl font-semibold mb-6">Sửa: {{ $package->name }}</h1>
    
    <form action="{{ route('admin.packages.update', $package) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.packages._form', ['package' => $package])
    </form>
</div>
@endsection
