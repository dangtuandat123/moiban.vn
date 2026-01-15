<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * Model InvitationAlbum
 * Ảnh trong album thiệp
 */
class InvitationAlbum extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'file_path',
        'caption',
        'sort_order',
    ];

    // =========== RELATIONSHIPS ===========

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    // =========== ACCESSORS ===========

    public function getUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    // =========== SCOPES ===========

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
