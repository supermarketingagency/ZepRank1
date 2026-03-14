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

    public function testConnection()
    {
        $settings = PlatformSetting::whereIn('key', ['ai_default_provider', 'ai_default_model', 'openai_api_key', 'gemini_api_key', 'groq_api_key'])
            ->get()->pluck('value', 'key');

        $providerName = $settings['ai_default_provider'] ?? 'groq';
        $model = $settings['ai_default_model'] ?? 'llama-3.1-70b-versatile';
        $apiKey = match($providerName) {
            'openai' => $settings['openai_api_key'] ?? '',
            'gemini' => $settings['gemini_api_key'] ?? '',
            'groq'   => $settings['groq_api_key'] ?? '',
            default  => ''
        };

        try {
            $provider = \App\Services\AI\AIProviderFactory::make($providerName, $model, $apiKey);
            if ($provider->isAvailable()) {
                return response()->json(['success' => true, 'message' => "Successfully connected to $providerName! API is responsive."]);
            }
            return response()->json(['success' => false, 'message' => "Provider $providerName is not available. Check your API key."]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => "Connection failed: " . $e->getMessage()]);
        }
    }
}
