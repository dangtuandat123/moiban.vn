<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * Model Template
 * Mẫu thiệp cưới (upload từ ZIP)
 */
class Template extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail_path',
        'folder_path',
        'config',
        'type',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
    ];

    // =========== RELATIONSHIPS ===========

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    // =========== ACCESSORS ===========

    /**
     * Lấy URL thumbnail
     */
    public function getThumbnailUrlAttribute(): string
    {
        return Storage::url($this->thumbnail_path);
    }

    /**
     * Lấy đường dẫn file view.blade.php
     */
    public function getViewPathAttribute(): string
    {
        return storage_path('app/' . $this->folder_path . '/view.blade.php');
    }

    /**
     * Lấy danh sách fields từ config
     */
    public function getFieldsAttribute(): array
    {
        return $this->config['fields'] ?? [];
    }

    /**
     * Lấy danh sách widgets được hỗ trợ
     */
    public function getSupportedWidgetsAttribute(): array
    {
        return $this->config['widgets'] ?? [];
    }

    /**
     * Kiểm tra có phải template premium không
     */
    public function isPremium(): bool
    {
        return $this->type === 'premium';
    }

    // =========== SCOPES ===========

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBasic($query)
    {
        return $query->where('type', 'basic');
    }

    public function scopePremium($query)
    {
        return $query->where('type', 'premium');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
