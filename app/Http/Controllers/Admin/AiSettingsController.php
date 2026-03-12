<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformSetting;
use Illuminate\Http\Request;

class AiSettingsController extends Controller
{
    public function index()
    {
        $settings = PlatformSetting::whereIn('key', [
            'ai_default_provider',
            'ai_default_model',
            'openai_api_key',
            'gemini_api_key',
            'groq_api_key'
        ])->get()->pluck('value', 'key');

        return view('admin.ai-settings', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            PlatformSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'type' => str_contains($key, 'key') ? 'encrypted' : 'string']
            );
        }

        return redirect()->back()->with('success', 'AI settings updated successfully.');
    }
}
