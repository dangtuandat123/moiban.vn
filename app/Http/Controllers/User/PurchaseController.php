<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Package;
use App\Services\InvitationService;
use App\Exceptions\InsufficientBalanceException;
use Illuminate\Http\Request;

/**
 * Controller: Mua gói cho thiệp
 */
class PurchaseController extends Controller
{
    public function __construct(
        private InvitationService $invitationService
    ) {}

    /**
     * Trang chọn gói
     */
    public function index(Invitation $invitation)
    {
        $this->authorize('update', $invitation);

        $packages = Package::active()->ordered()->get();
        $balance = auth()->user()->wallet_balance;

        return view('user.invitations.purchase', compact('invitation', 'packages', 'balance'));
    }

    /**
     * Xử lý mua gói
     */
    public function process(Request $request, Invitation $invitation)
    {
        $this->authorize('update', $invitation);

        $validated = $request->validate([
            'package_id' => ['required', 'exists:packages,id'],
        ]);

        $package = Package::findOrFail($validated['package_id']);

        try {
            $this->invitationService->purchaseAndActivate($invitation, $package);

            return redirect()
                ->route('user.invitations.show', $invitation)
                ->with('success', "Đã kích hoạt gói {$package->name} thành công!");

        } catch (InsufficientBalanceException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
