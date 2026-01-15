<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

/**
 * Controller: Quản lý Packages (Admin)
 */
class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::ordered()->get();

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'in:basic,premium'],
            'duration_days' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'integer', 'min:0'],
            'features' => ['nullable', 'array'],
            'is_active' => ['boolean'],
            'sort_order' => ['integer'],
        ]);

        Package::create($validated);

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Đã tạo gói mới.');
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'in:basic,premium'],
            'duration_days' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'integer', 'min:0'],
            'features' => ['nullable', 'array'],
            'is_active' => ['boolean'],
            'sort_order' => ['integer'],
        ]);

        $package->update($validated);

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Đã cập nhật gói.');
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Đã xóa gói.');
    }
}
