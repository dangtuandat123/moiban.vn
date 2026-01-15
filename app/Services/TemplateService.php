<?php

namespace App\Services;

use App\Models\Template;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use ZipArchive;

/**
 * Service: TemplateService
 * Xử lý upload, extract và quản lý templates
 */
class TemplateService
{
    private array $requiredFiles = ['view.blade.php', 'config.json'];

    /**
     * Upload và đăng ký template từ file ZIP
     */
    public function uploadAndRegister(UploadedFile $zipFile): Template
    {
        // 1. Extract ZIP
        $extractPath = $this->extractZip($zipFile);

        // 2. Validate structure
        $this->validateTemplateStructure($extractPath);

        // 3. Parse config
        $config = $this->parseConfig($extractPath . '/config.json');

        // 4. Generate slug
        $slug = Str::slug($config['name']);
        $originalSlug = $slug;
        $counter = 1;
        while (Template::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        // 5. Move to final location
        $folderPath = "templates/{$slug}";
        $finalPath = storage_path("app/{$folderPath}");

        if (File::exists($finalPath)) {
            File::deleteDirectory($finalPath);
        }
        File::moveDirectory($extractPath, $finalPath);

        // 6. Register in database
        return Template::create([
            'name' => $config['name'],
            'slug' => $slug,
            'description' => $config['description'] ?? null,
            'thumbnail_path' => "{$folderPath}/thumbnail.jpg",
            'folder_path' => $folderPath,
            'config' => $config,
            'type' => $config['type'] ?? 'basic',
            'is_active' => true,
        ]);
    }

    /**
     * Extract ZIP file to temporary location
     */
    private function extractZip(UploadedFile $file): string
    {
        $tempPath = storage_path('app/temp/' . Str::random(16));
        File::makeDirectory($tempPath, 0755, true);

        $zip = new ZipArchive();
        if ($zip->open($file->getPathname()) === true) {
            $zip->extractTo($tempPath);
            $zip->close();
        } else {
            File::deleteDirectory($tempPath);
            throw new \Exception('Không thể giải nén file ZIP');
        }

        // Kiểm tra nếu extract vào subfolder
        $items = File::directories($tempPath);
        if (count($items) === 1 && File::exists($items[0] . '/config.json')) {
            $subPath = $items[0];
            $newPath = storage_path('app/temp/' . Str::random(16));
            File::moveDirectory($subPath, $newPath);
            File::deleteDirectory($tempPath);
            return $newPath;
        }

        return $tempPath;
    }

    /**
     * Validate template structure
     */
    private function validateTemplateStructure(string $path): void
    {
        foreach ($this->requiredFiles as $file) {
            if (!File::exists($path . '/' . $file)) {
                File::deleteDirectory($path);
                throw new \Exception("Thiếu file bắt buộc: {$file}");
            }
        }
    }

    /**
     * Parse config.json
     */
    private function parseConfig(string $configPath): array
    {
        $content = File::get($configPath);
        $config = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('File config.json không hợp lệ: ' . json_last_error_msg());
        }

        if (empty($config['name'])) {
            throw new \Exception('Config phải có trường "name"');
        }

        return $config;
    }

    /**
     * Render thiệp với template
     */
    public function renderInvitation(\App\Models\Invitation $invitation): \Illuminate\Contracts\View\View
    {
        $template = $invitation->template;
        $viewPath = storage_path("app/{$template->folder_path}");

        // Đăng ký namespace cho blade
        View::addNamespace('invitation_' . $template->slug, $viewPath);

        // Lấy widgets đã enable
        $widgets = $invitation->widgets()->enabled()->get()->keyBy('widget_type');

        return view("invitation_{$template->slug}::view", [
            'invitation' => $invitation,
            'content' => $invitation->content ?? [],
            'widgets' => $widgets,
            'template' => $template,
        ]);
    }

    /**
     * Lấy danh sách templates active
     */
    public function getActiveTemplates()
    {
        return Template::active()->ordered()->get();
    }

    /**
     * Lấy templates theo type
     */
    public function getTemplatesByType(string $type)
    {
        return Template::active()->where('type', $type)->ordered()->get();
    }
}
