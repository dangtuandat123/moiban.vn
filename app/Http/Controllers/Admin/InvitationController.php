<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use Illuminate\Http\Request;

/**
 * Controller: Quản lý Invitations (Admin)
 */
class InvitationController extends Controller
{
    public function index(Request $request)
    {
        $query = Invitation::withTrashed()->with(['user', 'template']);

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $invitations = $query->latest()->paginate(20);

        return view('admin.invitations.index', compact('invitations'));
    }

    public function show(Invitation $invitation)
    {
        $invitation->load(['user', 'template', 'subscriptions.package', 'rsvps', 'guestbookEntries']);

        return view('admin.invitations.show', compact('invitation'));
    }

    public function lock(Invitation $invitation)
    {
        // Admin only - but ensure invitation exists and is not already locked
        abort_if($invitation->isLocked(), 400, 'Thiệp đã bị khóa.');
        
        $invitation->lock();

        return back()->with('success', 'Đã khóa thiệp.');
    }

    public function unlock(Invitation $invitation)
    {
        // Admin only - ensure invitation is locked before unlocking
        abort_if(!$invitation->isLocked(), 400, 'Thiệp chưa bị khóa.');
        
        $invitation->update(['status' => 'active']);

        return back()->with('success', 'Đã mở khóa thiệp.');
    }

    public function destroy(Invitation $invitation)
    {
        // Soft delete - can be restored later
        $invitation->delete();

        return redirect()
            ->route('admin.invitations.index')
            ->with('success', 'Đã xóa thiệp.');
    }
}
