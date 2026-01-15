<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Services\TemplateService;
use Illuminate\Http\Request;

/**
 * Controller: Quản lý Templates (Admin)
 */
class TemplateController extends Controller
{
    public function __construct(
        private TemplateService $templateService
    ) {}

    public function index()
    {
        $templates = Template::withTrashed()->ordered()->get();

        return view('admin.templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.templates.create');
    }

    /**
     * Upload template từ file ZIP
     */
    public function upload(Request $request)
    {
        $request->validate([
            'template_zip' => ['required', 'file', 'mimes:zip', 'max:51200'], // 50MB max
        ], [
            'template_zip.required' => 'Vui lòng chọn file ZIP',
            'template_zip.mimes' => 'File phải là định dạng ZIP',
            'template_zip.max' => 'File không được quá 50MB',
        ]);

        try {
            $template = $this->templateService->uploadAndRegister($request->file('template_zip'));

            return redirect()
                ->route('admin.templates.index')
                ->with('success', "Đã upload template '{$template->name}' thành công!");

        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function edit(Template $template)
    {
        return view('admin.templates.edit', compact('template'));
    }

    public function update(Request $request, Template $template)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'in:basic,premium'],
            'is_active' => ['boolean'],
            'sort_order' => ['integer'],
        ]);

        $template->update($validated);

        return redirect()
            ->route('admin.templates.index')
            ->with('success', 'Đã cập nhật template.');
    }

    public function destroy(Template $template)
    {
        $template->delete();

        return redirect()
            ->route('admin.templates.index')
            ->with('success', 'Đã xóa template.');
    }
}
