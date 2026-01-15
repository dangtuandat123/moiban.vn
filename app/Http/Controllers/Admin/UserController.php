<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Controller: Quản lý Users (Admin)
 */
class UserController extends Controller
{
    public function index()
    {
        $users = User::withTrashed()
            ->withCount('invitations')
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['wallet', 'invitations' => function ($q) {
            $q->withTrashed()->latest()->take(10);
        }]);

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Đã xóa user.');
    }
}
