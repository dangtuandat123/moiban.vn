<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use Illuminate\Http\JsonResponse;

/**
 * Controller: Public API cho Invitation
 * Dùng cho OG Image generator và các service bên ngoài
 */
class InvitationApiController extends Controller
{
    /**
     * Lấy thông tin thiệp theo slug (cho OG Image)
     */
    public function show(string $slug): JsonResponse
    {
        $invitation = Invitation::with('template')
            ->where('slug', $slug)
            ->first();

        if (!$invitation) {
            return response()->json([
                'success' => false,
                'message' => 'Thiệp không tồn tại',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $invitation->id,
                'slug' => $invitation->slug,
                'title' => $invitation->title,
                'couple_name' => $invitation->couple_name,
                'event_date' => $invitation->event_date,
                'template_name' => $invitation->template->name,
                'status' => $invitation->status,
                'seo_meta' => $invitation->seo_meta,
            ],
        ]);
    }
}
