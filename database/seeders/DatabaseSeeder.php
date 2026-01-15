<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\SystemSetting;
use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder chính - Tạo dữ liệu mẫu cho hệ thống
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo Admin
        $this->createAdmin();
        
        // Tạo User mẫu
        $this->createSampleUser();
        
        // Tạo Packages
        $this->createPackages();
        
        // Tạo System Settings
        $this->createSystemSettings();
        
        // Tạo Sample Templates
        $this->call(TemplateSeeder::class);
    }

    private function createAdmin(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@moiban.vn',
            'phone' => '0900000000',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }

    private function createSampleUser(): void
    {
        User::create([
            'name' => 'Nguyễn Văn A',
            'email' => 'user@moiban.vn',
            'phone' => '0901234567',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
    }

    private function createPackages(): void
    {
        // Gói Basic
        Package::create([
            'name' => 'Basic 7 ngày',
            'description' => 'Gói cơ bản, phù hợp cho đám cưới nhỏ',
            'type' => 'basic',
            'duration_days' => 7,
            'price' => 99000,
            'features' => ['countdown', 'album', 'maps'],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Package::create([
            'name' => 'Basic 15 ngày',
            'description' => 'Gói cơ bản thời hạn 15 ngày',
            'type' => 'basic',
            'duration_days' => 15,
            'price' => 149000,
            'features' => ['countdown', 'album', 'maps'],
            'is_active' => true,
            'sort_order' => 2,
        ]);

        Package::create([
            'name' => 'Basic 30 ngày',
            'description' => 'Gói cơ bản thời hạn 1 tháng',
            'type' => 'basic',
            'duration_days' => 30,
            'price' => 199000,
            'features' => ['countdown', 'album', 'maps'],
            'is_active' => true,
            'sort_order' => 3,
        ]);

        // Gói Premium
        Package::create([
            'name' => 'Premium 7 ngày',
            'description' => 'Gói cao cấp đầy đủ tính năng',
            'type' => 'premium',
            'duration_days' => 7,
            'price' => 199000,
            'features' => ['countdown', 'album', 'maps', 'rsvp', 'guestbook', 'music', 'vietqr'],
            'is_active' => true,
            'sort_order' => 4,
        ]);

        Package::create([
            'name' => 'Premium 15 ngày',
            'description' => 'Gói cao cấp thời hạn 15 ngày',
            'type' => 'premium',
            'duration_days' => 15,
            'price' => 299000,
            'features' => ['countdown', 'album', 'maps', 'rsvp', 'guestbook', 'music', 'vietqr'],
            'is_active' => true,
            'sort_order' => 5,
        ]);

        Package::create([
            'name' => 'Premium 30 ngày',
            'description' => 'Gói cao cấp thời hạn 1 tháng',
            'type' => 'premium',
            'duration_days' => 30,
            'price' => 399000,
            'features' => ['countdown', 'album', 'maps', 'rsvp', 'guestbook', 'music', 'vietqr'],
            'is_active' => true,
            'sort_order' => 6,
        ]);

        Package::create([
            'name' => 'Premium Vĩnh viễn',
            'description' => 'Gói cao cấp không giới hạn thời gian',
            'type' => 'premium',
            'duration_days' => 0,
            'price' => 799000,
            'features' => ['countdown', 'album', 'maps', 'rsvp', 'guestbook', 'music', 'vietqr'],
            'is_active' => true,
            'sort_order' => 7,
        ]);
    }

    private function createSystemSettings(): void
    {
        // SEO Settings
        SystemSetting::set('site_name', 'Mời Bạn - Thiệp Cưới Online', 'seo');
        SystemSetting::set('site_description', 'Tạo thiệp cưới online miễn phí, đẹp, chuyên nghiệp. Chia sẻ ngày vui của bạn với mọi người.', 'seo');
        SystemSetting::set('site_keywords', 'thiệp cưới online, mời cưới, wedding invitation', 'seo');

        // Payment Settings
        SystemSetting::set('vietqr_bank_code', '970416', 'payment');
        SystemSetting::set('vietqr_account_number', '11183041', 'payment');
        SystemSetting::set('vietqr_account_name', 'DANG TUAN DAT', 'payment');

        // Trial Settings
        SystemSetting::set('trial_duration_days', '2', 'trial');
        SystemSetting::set('watermark_text', 'moiban.vn', 'trial');

        // Upload Settings
        SystemSetting::set('max_file_size', '10240', 'upload'); // KB
        SystemSetting::set('max_album_images', '20', 'upload');
    }
}
