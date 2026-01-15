@extends('layouts.admin')

@section('title', 'Upload Template - Admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.templates.index') }}" class="text-white/60 hover:text-white">
        <i class="fa-solid fa-arrow-left mr-2"></i> Quay lại
    </a>
</div>

<div class="max-w-2xl">
    <h1 class="text-2xl font-semibold mb-6">Upload Template</h1>
    
    <form action="{{ route('admin.templates.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="glass-card p-6 mb-6">
            <h2 class="font-semibold mb-4">File ZIP Template</h2>
            <p class="text-sm text-white/60 mb-4">
                Upload file ZIP chứa: <code class="bg-white/10 px-1 rounded">view.blade.php</code>, 
                <code class="bg-white/10 px-1 rounded">config.json</code>, 
                <code class="bg-white/10 px-1 rounded">thumbnail.jpg</code>
            </p>
            
            <input type="file" name="template_zip" accept=".zip" 
                   class="w-full p-4 border-2 border-dashed border-white/20 rounded-lg bg-white/5" required>
            
            @error('template_zip')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="glass-card p-6 mb-6">
            <h2 class="font-semibold mb-4">Cấu trúc config.json</h2>
            <pre class="bg-black/30 p-4 rounded-lg text-sm overflow-x-auto"><code>{
  "name": "Template Name",
  "version": "1.0",
  "type": "basic|premium",
  "description": "Mô tả template",
  "fields": {
    "groom_name": {
      "type": "text",
      "label": "Tên chú rể",
      "required": true
    }
  },
  "widgets": ["countdown", "album", "rsvp"]
}</code></pre>
        </div>
        
        <button type="submit" class="glass-btn px-6 py-3">
            <i class="fa-solid fa-upload mr-2"></i> Upload
        </button>
    </form>
</div>
@endsection
