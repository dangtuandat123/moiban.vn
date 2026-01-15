<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Rsvp;
use Illuminate\Http\Request;

/**
 * Controller: Xử lý RSVP
 */
class RsvpController extends Controller
{
    public function store(Request $request, string $slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        // Kiểm tra widget RSVP có bật không
        $rsvpWidget = $invitation->widgets()->where('widget_type', 'rsvp')->first();
        if (!$rsvpWidget || !$rsvpWidget->is_enabled) {
            return back()->with('error', 'Chức năng RSVP không được bật.');
        }

        $validated = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'attendees_count' => ['required', 'integer', 'min:1', 'max:10'],
            'status' => ['required', 'in:attending,not_attending,maybe'],
            'message' => ['nullable', 'string', 'max:500'],
        ], [
            'guest_name.required' => 'Vui lòng nhập tên của bạn',
            'attendees_count.required' => 'Vui lòng chọn số người tham dự',
            'attendees_count.min' => 'Số người phải ít nhất là 1',
            'status.required' => 'Vui lòng chọn trạng thái tham dự',
        ]);

        Rsvp::create([
            'invitation_id' => $invitation->id,
            'guest_name' => $validated['guest_name'],
            'attendees_count' => $validated['attendees_count'],
            'status' => $validated['status'],
            'message' => $validated['message'] ?? null,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('rsvp_success', 'Cảm ơn bạn đã xác nhận!');
    }
}
