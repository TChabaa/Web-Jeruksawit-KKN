<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class WebsiteSettingController extends Controller
{
    public function index()
    {
        $settings = WebsiteSetting::all()->keyBy('key');
        return view('components.pages.dashboard.admin.website-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_youtube_url' => 'required|url',
            'hero_youtube_title' => 'required|string|max:255'
        ]);

        try {
            WebsiteSetting::setValue('hero_youtube_url', $request->hero_youtube_url, 'url', 'YouTube URL for hero section video');
            WebsiteSetting::setValue('hero_youtube_title', $request->hero_youtube_title, 'text', 'Title for hero section YouTube video');

            Alert::success('Success', 'Website settings updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update website settings: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
