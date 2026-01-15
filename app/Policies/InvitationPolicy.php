<?php

namespace App\Policies;

use App\Models\Invitation;
use App\Models\User;

/**
 * Policy: Phân quyền cho Invitation
 */
class InvitationPolicy
{
    /**
     * Admin có thể làm mọi thứ
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    /**
     * Xem thiệp
     */
    public function view(User $user, Invitation $invitation): bool
    {
        return $user->id === $invitation->user_id;
    }

    /**
     * Cập nhật thiệp
     */
    public function update(User $user, Invitation $invitation): bool
    {
        return $user->id === $invitation->user_id;
    }

    /**
     * Xóa thiệp
     */
    public function delete(User $user, Invitation $invitation): bool
    {
        return $user->id === $invitation->user_id;
    }
}
