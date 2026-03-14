<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class InstallController extends Controller
{
    public function index()
    {
        $checks = [
            'php' => version_compare(PHP_VERSION, '8.2.0', '>='),
            'pdo' => extension_loaded('pdo_mysql') || extension_loaded('pdo_sqlite'),
            'openssl' => extension_loaded('openssl'),
            'mbstring' => extension_loaded('mbstring'),
            'storage' => is_writable(storage_path()),
            'cache' => is_writable(base_path('bootstrap/cache')),
            'env' => is_writable(base_path()) || (File::exists(base_path('.env')) && is_writable(base_path('.env'))),
        ];

        $step = 1;
        return view('install', compact('checks', 'step'));
    }

    public function testConnection(Request $request)
    {
        $request->validate([
            'db_host' => 'required',
            'db_name' => 'required',
            'db_user' => 'required',
            'db_pass' => 'nullable',
        ]);

        try {
            $config = config('database.connections.mysql');
            $config['host'] = $request->db_host;
            $config['database'] = $request->db_name;
            $config['username'] = $request->db_user;
            $config['password'] = $request->db_pass;

            config(['database.connections.install_test' => $config]);

            DB::connection('install_test')->getPdo();

            return response()->json(['success' => true, 'message' => 'Database connection successful!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()]);
        }
    }

    public function setupDatabase(Request $request)
    {
        $request->validate([
            'db_host' => 'required',
            'db_name' => 'required',
            'db_user' => 'required',
            'db_pass' => 'nullable',
        ]);

        $this->updateEnv([
            'DB_HOST' => $request->db_host,
            'DB_DATABASE' => $request->db_name,
            'DB_USERNAME' => $request->db_user,
            'DB_PASSWORD' => $request->db_pass,
        ]);

        return redirect()->route('install.index', ['step' => 3]);
    }

    public function setupApp(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_url' => 'required|url',
        ]);

        $this->updateEnv([
            'APP_NAME' => $request->app_name,
            'APP_URL' => $request->app_url,
        ]);

        if ($request->has('generate_key')) {
            Artisan::call('key:generate', ['--force' => true]);
        }

        return redirect()->route('install.index', ['step' => 4]);
    }

    public function finalize()
    {
        try {
            // Ensure we are using the new DB config from .env
            Artisan::call('config:clear');

            // Run migrations and seeds
            Artisan::call('migrate:fresh', ['--force' => true]);

            // Seed essential data only
            Artisan::call('db:seed', ['--force' => true]);

            // Try to link storage
            try {
                Artisan::call('storage:link');
            } catch (\Exception $e) {
                Log::warning('Storage link failed during installation: ' . $e->getMessage());
            }

            // Mark as installed
            File::put(storage_path('installed'), now()->toDateTimeString());

            // Final cache clear to ensure middleware kicks in
            Artisan::call('config:clear');

            return redirect()->route('dashboard')->with('success', 'Installation completed successfully!');
        } catch (\Exception $e) {
            Log::error('Installation finalization failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Installation failed: ' . $e->getMessage());
        }
    }

    protected function updateEnv(array $data)
    {
        $envPath = base_path('.env');
        if (!File::exists($envPath)) {
            if (File::exists(base_path('.env.example'))) {
                File::copy(base_path('.env.example'), $envPath);
            } else {
                File::put($envPath, '');
            }
        }

        $content = File::get($envPath);

        foreach ($data as $key => $value) {
            // Escape double quotes and wrap in quotes to handle special characters safely
            $safeValue = str_replace('"', '\"', $value);

            if (preg_match("/^{$key}=/m", $content)) {
                $content = preg_replace("/^{$key}=.*/m", "{$key}=\"{$safeValue}\"", $content);
            } else {
                $content .= "\n{$key}=\"{$safeValue}\"";
            }
        }

        File::put($envPath, $content);
    }
}
