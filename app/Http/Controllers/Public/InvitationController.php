<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Services\TemplateService;
use Illuminate\Http\Request;

/**
 * Controller: Xem thiệp công khai
 */
class InvitationController extends Controller
{
    public function __construct(
        private TemplateService $templateService
    ) {}

    /**
     * Hiển thị thiệp
     */
    public function show(Request $request, string $slug)
    {
        $invitation = $request->invitation; // Được set bởi middleware

        // Render thiệp với template
        return $this->templateService->renderInvitation($invitation);
    }

    /**
     * Trang thiệp bị khóa
     */
    public function locked(string $slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        return view('public.invitation-locked', compact('invitation'));
    }

    /**
     * Trang thiệp hết hạn
     */
    public function expired(string $slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        return view('public.invitation-expired', compact('invitation'));
    }
}
