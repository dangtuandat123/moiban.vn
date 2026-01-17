<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Template;
use App\Services\InvitationService;
use App\Services\TelegramService;
use Illuminate\Http\Request;

/**
 * Controller: CRUD Thiệp của User
 */
class InvitationController extends Controller
{
    public function __construct(
        private InvitationService $invitationService,
        private TelegramService $telegramService
    ) {}

    /**
     * Danh sách thiệp của user
     */
    public function index(Request $request)
    {
        $invitations = $request->user()
            ->invitations()
            ->with('template')
            ->withCount(['rsvps', 'guestbookEntries'])
            ->latest()
            ->paginate(12);

        return view('user.invitations.index', compact('invitations'));
    }

    /**
     * Form tạo thiệp mới
     */
    public function create()
    {
        $templates = Template::active()->ordered()->get();
        
        return view('user.invitations.create', compact('templates'));
    }

    /**
     * Lưu thiệp mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_id' => ['required', 'exists:templates,id'],
            'title' => ['required', 'string', 'max:255'],
            'groom_name' => ['required', 'string', 'max:100'],
            'bride_name' => ['required', 'string', 'max:100'],
            'event_date' => ['required', 'date', 'after:today'],
        ], [
            'template_id.required' => 'Vui lòng chọn mẫu thiệp',
            'title.required' => 'Vui lòng nhập tiêu đề',
            'groom_name.required' => 'Vui lòng nhập tên chú rể',
            'bride_name.required' => 'Vui lòng nhập tên cô dâu',
            'event_date.required' => 'Vui lòng chọn ngày cưới',
            'event_date.after' => 'Ngày cưới phải sau ngày hôm nay',
        ]);

        $template = Template::findOrFail($validated['template_id']);
        
        $invitation = $this->invitationService->create(
            $request->user(),
            $template,
            $validated
        );

        // Thông báo Telegram (không block nếu fail)
        try {
            $this->telegramService->notifyNewInvitation($request->user(), $invitation);
        } catch (\Exception $e) {
            \Log::error('Telegram notification failed: ' . $e->getMessage());
        }

        $trialDays = config('app.trial_duration_days', 2);
        return redirect()
            ->route('user.invitations.editor', $invitation)
            ->with('success', "Tạo thiệp thành công! Bạn có {$trialDays} ngày dùng thử miễn phí.");
    }

    /**
     * Xem chi tiết thiệp
     */
    public function show(Invitation $invitation)
    {
        $this->authorize('view', $invitation);

        $invitation->load(['template', 'widgets', 'rsvps', 'guestbookEntries']);
        
        return view('user.invitations.show', compact('invitation'));
    }

    /**
     * Xóa thiệp
     */
    public function destroy(Invitation $invitation)
    {
        $this->authorize('delete', $invitation);

        $invitation->delete();

        return redirect()
            ->route('user.invitations.index')
            ->with('success', 'Đã xóa thiệp thành công.');
    }
}
