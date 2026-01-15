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
}
