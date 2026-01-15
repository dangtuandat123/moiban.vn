<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

/**
 * Controller: Tạo Dynamic OG Image cho thiệp
 * Dùng HTML to Image approach (pure PHP, không cần Node.js)
 */
class OgImageController extends Controller
{
    /**
     * Render OG Image cho thiệp
     * GET /og-image/{slug}
     */
    public function show(string $slug)
    {
        $invitation = Invitation::where('slug', $slug)
            ->with('template')
            ->firstOrFail();

        // Cache image cho 1 giờ
        $cacheKey = "og_image_{$slug}_" . $invitation->updated_at->timestamp;
        
        $html = Cache::remember($cacheKey, 3600, function () use ($invitation) {
            return $this->generateHtml($invitation);
        });

        // Trả về HTML với styling (OG Image providers sẽ render)
        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Generate HTML cho OG Image
     */
    private function generateHtml(Invitation $invitation): string
    {
        $groomName = $invitation->content['groom_name'] ?? 'Chú rể';
        $brideName = $invitation->content['bride_name'] ?? 'Cô dâu';
        $eventDate = $invitation->content['event_date'] ?? '';
        $formattedDate = $eventDate ? date('d/m/Y', strtotime($eventDate)) : '';
        $primaryColor = $invitation->content['primary_color'] ?? '#b76e79';

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1200, height=630">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&family=Be+Vietnam+Pro:wght@400;600&display=swap');
        
        body {
            width: 1200px;
            height: 630px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
            font-family: 'Be Vietnam Pro', sans-serif;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
        }
        .orb-1 {
            width: 400px;
            height: 400px;
            background: {$primaryColor};
            opacity: 0.3;
            top: -100px;
            left: -100px;
        }
        .orb-2 {
            width: 500px;
            height: 500px;
            background: #9333ea;
            opacity: 0.2;
            bottom: -150px;
            right: -100px;
        }
        
        .content {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 60px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 30px;
            backdrop-filter: blur(20px);
            width: 900px;
        }
        
        .subtitle {
            font-size: 20px;
            color: rgba(255,255,255,0.6);
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        
        .names {
            font-family: 'Great Vibes', cursive;
            font-size: 80px;
            background: linear-gradient(135deg, #f7e7ce, {$primaryColor});
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.2;
            margin-bottom: 30px;
        }
        
        .date {
            font-size: 28px;
            font-weight: 600;
            color: {$primaryColor};
        }
        
        .logo {
            position: absolute;
            bottom: 30px;
            right: 40px;
            font-family: 'Great Vibes', cursive;
            font-size: 28px;
            color: rgba(255,255,255,0.4);
        }
    </style>
</head>
<body>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    
    <div class="content">
        <p class="subtitle">Thiệp Cưới</p>
        <h1 class="names">{$groomName} & {$brideName}</h1>
        <p class="date">{$formattedDate}</p>
    </div>
    
    <div class="logo">moiban.vn</div>
</body>
</html>
HTML;
    }

    /**
     * Generate PNG Image (sử dụng khi có GD/Imagick)
     * Fallback khi không có headless browser
     */
    public function generatePng(string $slug)
    {
        $invitation = Invitation::where('slug', $slug)
            ->firstOrFail();

        // Tạo image với GD
        $width = 1200;
        $height = 630;
        
        $image = imagecreatetruecolor($width, $height);
        
        // Background gradient (dark)
        $bgColor = imagecolorallocate($image, 15, 23, 42);
        imagefill($image, 0, 0, $bgColor);
        
        // Primary color
        $primaryColor = $invitation->content['primary_color'] ?? '#b76e79';
        $rgb = $this->hexToRgb($primaryColor);
        $textColor = imagecolorallocate($image, $rgb['r'], $rgb['g'], $rgb['b']);
        $whiteColor = imagecolorallocate($image, 255, 255, 255);
        $grayColor = imagecolorallocate($image, 200, 200, 200);
        
        // Text
        $groomName = $invitation->content['groom_name'] ?? 'Chú rể';
        $brideName = $invitation->content['bride_name'] ?? 'Cô dâu';
        $coupleText = $groomName . ' & ' . $brideName;
        
        // Center text (basic - font không đẹp như browser)
        $fontSize = 5; // GD font size
        $textWidth = imagefontwidth($fontSize) * strlen($coupleText);
        $x = ($width - $textWidth) / 2;
        imagestring($image, $fontSize, $x, 280, $coupleText, $whiteColor);
        
        // Subtitle
        $subtitle = "Thiep Cuoi";
        $subtitleWidth = imagefontwidth(3) * strlen($subtitle);
        imagestring($image, 3, ($width - $subtitleWidth) / 2, 250, $subtitle, $grayColor);
        
        // Event date
        $eventDate = $invitation->content['event_date'] ?? '';
        if ($eventDate) {
            $formattedDate = date('d/m/Y', strtotime($eventDate));
            $dateWidth = imagefontwidth(4) * strlen($formattedDate);
            imagestring($image, 4, ($width - $dateWidth) / 2, 350, $formattedDate, $textColor);
        }
        
        // Logo
        imagestring($image, 2, $width - 100, $height - 30, "moiban.vn", $grayColor);
        
        // Output
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);
        
        return response($imageData)
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Hex to RGB
     */
    private function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');
        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2)),
        ];
    }
}
