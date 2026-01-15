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
        $invitation->lock();

        return back()->with('success', 'Đã khóa thiệp.');
    }

    public function unlock(Invitation $invitation)
    {
        $invitation->update(['status' => 'active']);

        return back()->with('success', 'Đã mở khóa thiệp.');
    }

    public function destroy(Invitation $invitation)
    {
        $invitation->delete();

        return redirect()
            ->route('admin.invitations.index')
            ->with('success', 'Đã xóa thiệp.');
    }
}
