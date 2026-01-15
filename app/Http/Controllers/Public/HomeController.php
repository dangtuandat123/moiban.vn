<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Template;

/**
 * Controller: Trang chủ công cộng
 */
class HomeController extends Controller
{
    public function index()
    {
        $templates = Template::active()->ordered()->take(6)->get();
        $packages = Package::active()->ordered()->get();

        return view('public.home', compact('templates', 'packages'));
    }

    public function templates()
    {
        $templates = Template::active()->ordered()->get();
        $basicTemplates = $templates->where('type', 'basic');
        $premiumTemplates = $templates->where('type', 'premium');

        return view('public.templates', compact('templates', 'basicTemplates', 'premiumTemplates'));
    }

    public function pricing()
    {
        $packages = Package::active()->ordered()->get();
        $basicPackages = $packages->where('type', 'basic');
        $premiumPackages = $packages->where('type', 'premium');

        return view('public.pricing', compact('packages', 'basicPackages', 'premiumPackages'));
    }
}
