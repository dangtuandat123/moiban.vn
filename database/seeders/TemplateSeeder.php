<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

/**
 * Seeder cho Templates mẫu
 */
class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo thư mục templates nếu chưa có
        $templatesPath = storage_path('app/templates');
        if (!File::exists($templatesPath)) {
            File::makeDirectory($templatesPath, 0755, true);
        }

        // Template 1: Romantic Rose (Basic)
        $this->createRomanticRose();

        // Template 2: Elegant Gold (Premium)
        $this->createElegantGold();

        // Template 3: Modern Minimal (Premium)
        $this->createModernMinimal();
    }

    private function createRomanticRose(): void
    {
        $slug = 'romantic-rose';
        $folderPath = "templates/{$slug}";
        $fullPath = storage_path("app/{$folderPath}");

        // Tạo thư mục
        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }

        // Config JSON
        $config = [
            'name' => 'Romantic Rose',
            'version' => '1.0',
            'type' => 'basic',
            'description' => 'Mẫu thiệp hồng pastel lãng mạn, phù hợp cho đám cưới truyền thống',
            'author' => 'MoiBan Team',
            'fields' => [
                'groom_name' => [
                    'type' => 'text',
                    'label' => 'Tên chú rể',
                    'default' => 'Minh Anh',
                    'required' => true,
                ],
                'bride_name' => [
                    'type' => 'text',
                    'label' => 'Tên cô dâu',
                    'default' => 'Thùy Linh',
                    'required' => true,
                ],
                'event_date' => [
                    'type' => 'date',
                    'label' => 'Ngày cưới',
                    'required' => true,
                ],
                'event_time' => [
                    'type' => 'time',
                    'label' => 'Giờ làm lễ',
                    'default' => '10:00',
                ],
                'venue_name' => [
                    'type' => 'text',
                    'label' => 'Tên địa điểm',
                    'default' => 'Trung tâm Tiệc cưới ABC',
                ],
                'venue_address' => [
                    'type' => 'textarea',
                    'label' => 'Địa chỉ chi tiết',
                    'default' => '123 Đường ABC, Quận 1, TP.HCM',
                ],
                'hero_image' => [
                    'type' => 'image',
                    'label' => 'Ảnh bìa',
                    'max_size' => '5MB',
                ],
                'story_text' => [
                    'type' => 'richtext',
                    'label' => 'Câu chuyện tình yêu',
                    'default' => 'Chuyện tình của chúng tôi bắt đầu từ...',
                ],
                'primary_color' => [
                    'type' => 'color',
                    'label' => 'Màu chủ đạo',
                    'default' => '#b76e79',
                ],
            ],
            'widgets' => ['countdown', 'album', 'maps'],
        ];

        File::put("{$fullPath}/config.json", json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Tạo record trong database
        Template::create([
            'name' => 'Romantic Rose',
            'slug' => $slug,
            'description' => 'Mẫu thiệp hồng pastel lãng mạn, phù hợp cho đám cưới truyền thống',
            'thumbnail_path' => "{$folderPath}/thumbnail.jpg",
            'folder_path' => $folderPath,
            'config' => $config,
            'type' => 'basic',
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }

    private function createElegantGold(): void
    {
        $slug = 'elegant-gold';
        $folderPath = "templates/{$slug}";
        $fullPath = storage_path("app/{$folderPath}");

        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }

        $config = [
            'name' => 'Elegant Gold',
            'version' => '1.0',
            'type' => 'premium',
            'description' => 'Mẫu thiệp sang trọng với điểm nhấn vàng gold, hiệu ứng parallax',
            'author' => 'MoiBan Team',
            'fields' => [
                'groom_name' => [
                    'type' => 'text',
                    'label' => 'Tên chú rể',
                    'default' => 'Minh Anh',
                    'required' => true,
                ],
                'groom_father' => [
                    'type' => 'text',
                    'label' => 'Tên bố chú rể',
                    'default' => '',
                ],
                'groom_mother' => [
                    'type' => 'text',
                    'label' => 'Tên mẹ chú rể',
                    'default' => '',
                ],
                'bride_name' => [
                    'type' => 'text',
                    'label' => 'Tên cô dâu',
                    'default' => 'Thùy Linh',
                    'required' => true,
                ],
                'bride_father' => [
                    'type' => 'text',
                    'label' => 'Tên bố cô dâu',
                    'default' => '',
                ],
                'bride_mother' => [
                    'type' => 'text',
                    'label' => 'Tên mẹ cô dâu',
                    'default' => '',
                ],
                'event_date' => [
                    'type' => 'date',
                    'label' => 'Ngày cưới',
                    'required' => true,
                ],
                'event_time' => [
                    'type' => 'time',
                    'label' => 'Giờ làm lễ',
                    'default' => '10:00',
                ],
                'venue_name' => [
                    'type' => 'text',
                    'label' => 'Tên địa điểm',
                    'default' => 'Trung tâm Tiệc cưới ABC',
                ],
                'venue_address' => [
                    'type' => 'textarea',
                    'label' => 'Địa chỉ chi tiết',
                    'default' => '123 Đường ABC, Quận 1, TP.HCM',
                ],
                'hero_image' => [
                    'type' => 'image',
                    'label' => 'Ảnh bìa',
                    'max_size' => '5MB',
                ],
                'story_text' => [
                    'type' => 'richtext',
                    'label' => 'Câu chuyện tình yêu',
                    'default' => 'Chuyện tình của chúng tôi bắt đầu từ...',
                ],
                'font_family' => [
                    'type' => 'select',
                    'label' => 'Font chữ',
                    'options' => ['Great Vibes', 'Dancing Script', 'Pacifico'],
                    'default' => 'Great Vibes',
                ],
            ],
            'widgets' => ['countdown', 'album', 'maps', 'rsvp', 'guestbook', 'music', 'vietqr'],
        ];

        File::put("{$fullPath}/config.json", json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        Template::create([
            'name' => 'Elegant Gold',
            'slug' => $slug,
            'description' => 'Mẫu thiệp sang trọng với điểm nhấn vàng gold, hiệu ứng parallax',
            'thumbnail_path' => "{$folderPath}/thumbnail.jpg",
            'folder_path' => $folderPath,
            'config' => $config,
            'type' => 'premium',
            'is_active' => true,
            'sort_order' => 2,
        ]);
    }

    private function createModernMinimal(): void
    {
        $slug = 'modern-minimal';
        $folderPath = "templates/{$slug}";
        $fullPath = storage_path("app/{$folderPath}");

        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }

        $config = [
            'name' => 'Modern Minimal',
            'version' => '1.0',
            'type' => 'premium',
            'description' => 'Mẫu thiệp hiện đại, tối giản, animations mượt mà',
            'author' => 'MoiBan Team',
            'fields' => [
                'groom_name' => [
                    'type' => 'text',
                    'label' => 'Tên chú rể',
                    'default' => 'Minh Anh',
                    'required' => true,
                ],
                'bride_name' => [
                    'type' => 'text',
                    'label' => 'Tên cô dâu',
                    'default' => 'Thùy Linh',
                    'required' => true,
                ],
                'event_date' => [
                    'type' => 'date',
                    'label' => 'Ngày cưới',
                    'required' => true,
                ],
                'event_time' => [
                    'type' => 'time',
                    'label' => 'Giờ làm lễ',
                    'default' => '10:00',
                ],
                'venue_name' => [
                    'type' => 'text',
                    'label' => 'Tên địa điểm',
                    'default' => 'Trung tâm Tiệc cưới ABC',
                ],
                'venue_address' => [
                    'type' => 'textarea',
                    'label' => 'Địa chỉ chi tiết',
                    'default' => '123 Đường ABC, Quận 1, TP.HCM',
                ],
                'hero_image' => [
                    'type' => 'image',
                    'label' => 'Ảnh bìa',
                    'max_size' => '5MB',
                ],
                'story_text' => [
                    'type' => 'richtext',
                    'label' => 'Câu chuyện tình yêu',
                    'default' => '',
                ],
                'theme_mode' => [
                    'type' => 'select',
                    'label' => 'Chế độ màu',
                    'options' => ['dark', 'light'],
                    'default' => 'dark',
                ],
            ],
            'widgets' => ['countdown', 'album', 'maps', 'rsvp', 'guestbook', 'music', 'vietqr'],
        ];

        File::put("{$fullPath}/config.json", json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        Template::create([
            'name' => 'Modern Minimal',
            'slug' => $slug,
            'description' => 'Mẫu thiệp hiện đại, tối giản, animations mượt mà',
            'thumbnail_path' => "{$folderPath}/thumbnail.jpg",
            'folder_path' => $folderPath,
            'config' => $config,
            'type' => 'premium',
            'is_active' => true,
            'sort_order' => 3,
        ]);
    }
}
