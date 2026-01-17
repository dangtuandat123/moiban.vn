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

    /**
     * Tạo OG Image động cho thiệp
     * Sử dụng service như opengraph.io hoặc tạo ảnh với Intervention/Image
     */
    public function ogImage(string $slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();
        $content = $invitation->content ?? [];
        
        // Sử dụng Placid.app hoặc tạo URL dynamic
        // Ở đây dùng cách đơn giản: tạo URL với text overlay từ service
        $groomName = urlencode($content['groom_name'] ?? 'Chú Rể');
        $brideName = urlencode($content['bride_name'] ?? 'Cô Dâu');
        $eventDate = urlencode(\Carbon\Carbon::parse($content['event_date'] ?? now())->format('d/m/Y'));
        
        // Sử dụng placeholder.com hoặc service tương tự để tạo ảnh đơn giản
        // Trong production, nên dùng Intervention/Image hoặc service như Placid, Bannerbear
        $primaryColor = ltrim($content['primary_color'] ?? '#b76e79', '#');
        
        // Tạo URL OG image với og:image service
        $groomName = $content['groom_name'] ?? 'Chú Rể';
        $brideName = $content['bride_name'] ?? 'Cô Dâu';
        $ogImageUrl = "https://via.placeholder.com/1200x630/{$primaryColor}/ffffff?text=" 
            . urlencode("{$groomName} ❤ {$brideName}");
        
        return redirect($ogImageUrl);
    }
}
