<?php

namespace App\Http\Middleware;

use App\Models\Invitation;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware: Kiểm tra trạng thái thiệp (cho public view)
 */
class CheckInvitationAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('slug');
        $invitation = Invitation::where('slug', $slug)->first();

        if (!$invitation) {
            abort(404, 'Thiệp không tồn tại.');
        }

        // Nếu thiệp bị khóa -> redirect
        if ($invitation->isLocked()) {
            return redirect()->route('invitation.locked', ['slug' => $slug]);
        }

        // Nếu thiệp hết hạn
        if ($invitation->isExpired()) {
            return redirect()->route('invitation.expired', ['slug' => $slug]);
        }

        // Tăng lượt xem
        $invitation->incrementViewCount();

        // Truyền invitation vào request
        $request->merge(['invitation' => $invitation]);

        return $next($request);
    }
}
