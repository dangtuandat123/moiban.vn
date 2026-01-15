<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\GuestbookEntry;
use App\Models\Invitation;
use Illuminate\Http\Request;

/**
 * Controller: Xử lý Guestbook (Sổ lưu bút)
 */
class GuestbookController extends Controller
{
    public function store(Request $request, string $slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        // Kiểm tra widget Guestbook có bật không
        $guestbookWidget = $invitation->widgets()->where('widget_type', 'guestbook')->first();
        if (!$guestbookWidget || !$guestbookWidget->is_enabled) {
            return back()->with('error', 'Chức năng Guestbook không được bật.');
        }

        $validated = $request->validate([
            'author_name' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:1000'],
        ], [
            'author_name.required' => 'Vui lòng nhập tên của bạn',
            'message.required' => 'Vui lòng nhập lời chúc',
            'message.max' => 'Lời chúc không được quá 1000 ký tự',
        ]);

        GuestbookEntry::create([
            'invitation_id' => $invitation->id,
            'author_name' => $validated['author_name'],
            'message' => $validated['message'],
            'is_approved' => true, // Tự động duyệt
            'ip_address' => $request->ip(),
        ]);

        return back()->with('guestbook_success', 'Cảm ơn lời chúc của bạn!');
    }
}
