<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Services\InvitationService;
use Illuminate\Http\Request;

/**
 * Controller: Editor thiệp
 */
class EditorController extends Controller
{
    public function __construct(
        private InvitationService $invitationService
    ) {}

    /**
     * Hiển thị editor
     */
    public function index(Invitation $invitation)
    {
        $this->authorize('update', $invitation);

        $invitation->load(['template', 'widgets', 'albums']);
        $template = $invitation->template;
        $fields = $template->fields;

        return view('user.invitations.editor', compact('invitation', 'template', 'fields'));
    }

    /**
     * Lưu thay đổi từ editor
     */
    public function save(Request $request, Invitation $invitation)
    {
        $this->authorize('update', $invitation);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'array'],
            'widgets' => ['nullable', 'array'],
        ]);

        // Cập nhật nội dung thiệp
        $this->invitationService->update($invitation, [
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        // Cập nhật widgets
        if (isset($validated['widgets'])) {
            foreach ($validated['widgets'] as $widgetType => $config) {
                $invitation->widgets()
                    ->where('widget_type', $widgetType)
                    ->update([
                        'is_enabled' => $config['enabled'] ?? false,
                        'config' => $config['config'] ?? null,
                    ]);
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Đã lưu thay đổi']);
        }

        return back()->with('success', 'Đã lưu thay đổi.');
    }

    /**
     * Upload ảnh album
     */
    public function uploadPhoto(Request $request, Invitation $invitation)
    {
        $this->authorize('update', $invitation);

        $request->validate([
            'photo' => ['required', 'image', 'max:5120'], // Max 5MB
        ]);

        // Lưu file vào storage
        $path = $request->file('photo')->store(
            "invitations/{$invitation->id}/album",
            'public'
        );

        // Lấy URL công khai
        $url = asset('storage/' . $path);

        // Thêm vào album_photos trong content
        $content = $invitation->content ?? [];
        $albumPhotos = $content['album_photos'] ?? [];
        $albumPhotos[] = $url;
        $content['album_photos'] = $albumPhotos;

        $invitation->update(['content' => $content]);

        return response()->json([
            'success' => true,
            'url' => $url,
            'path' => $path,
        ]);
    }

    /**
     * Xóa ảnh album
     */
    public function deletePhoto(Request $request, Invitation $invitation)
    {
        $this->authorize('update', $invitation);

        $request->validate([
            'url' => ['required', 'string'],
        ]);

        $urlToDelete = $request->input('url');

        // Xóa khỏi content
        $content = $invitation->content ?? [];
        $albumPhotos = $content['album_photos'] ?? [];
        $albumPhotos = array_values(array_filter($albumPhotos, fn($url) => $url !== $urlToDelete));
        $content['album_photos'] = $albumPhotos;

        $invitation->update(['content' => $content]);

        // Xóa file từ storage (optional, có thể giữ lại)
        $path = str_replace(asset('storage/'), '', $urlToDelete);
        \Storage::disk('public')->delete($path);

        return response()->json(['success' => true]);
    }

    /**
     * Upload nhạc nền
     */
    public function uploadMusic(Request $request, Invitation $invitation)
    {
        $this->authorize('update', $invitation);

        $request->validate([
            'music' => ['required', 'file', 'mimes:mp3,wav,ogg', 'max:' . config('moiban.max_music_size', 10240)], // Default 10MB
        ], [
            'music.max' => 'File nhạc tối đa ' . (config('moiban.max_music_size', 10240) / 1024) . 'MB',
            'music.mimes' => 'Chỉ hỗ trợ file MP3, WAV, OGG',
        ]);

        // Xóa file nhạc cũ nếu có
        $content = $invitation->content ?? [];
        if (!empty($content['music_file'])) {
            \Storage::disk('public')->delete($content['music_file']);
        }

        // Lưu file mới
        $path = $request->file('music')->store(
            "invitations/{$invitation->id}/music",
            'public'
        );

        // Lấy URL công khai
        $url = asset('storage/' . $path);

        // Cập nhật content
        $content['music_url'] = $url;
        $content['music_file'] = $path;
        $invitation->update(['content' => $content]);

        return response()->json([
            'success' => true,
            'url' => $url,
            'path' => $path,
        ]);
    }

    /**
     * Xóa nhạc nền
     */
    public function deleteMusic(Request $request, Invitation $invitation)
    {
        $this->authorize('update', $invitation);

        $content = $invitation->content ?? [];
        
        // Xóa file từ storage
        if (!empty($content['music_file'])) {
            \Storage::disk('public')->delete($content['music_file']);
        }

        // Xóa khỏi content
        unset($content['music_url'], $content['music_file']);
        $invitation->update(['content' => $content]);

        return response()->json(['success' => true]);
    }
}
