<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class InstallationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Ensure the installed file doesn't exist during tests
        if (File::exists(storage_path('installed'))) {
            File::delete(storage_path('installed'));
        }
    }

    public function test_uninstalled_app_redirects_to_install()
    {
        $response = $this->withHeader('X-Testing-Installation', '1')->get('/');
        $response->assertRedirect('/install');
    }

    public function test_install_index_shows_checks()
    {
        $response = $this->withHeader('X-Testing-Installation', '1')->get('/install');
        $response->assertStatus(200);
        $response->assertSee('Environment Checks');
        $response->assertSee('PHP Version');
    }

    public function test_can_navigate_to_database_setup()
    {
        $response = $this->withHeader('X-Testing-Installation', '1')->get('/install?step=2');
        $response->assertStatus(200);
        $response->assertSee('Database Setup');
    }

    public function test_installed_app_blocks_install_route()
    {
        File::put(storage_path('installed'), 'test');

        $response = $this->withHeader('X-Testing-Installation', '1')->get('/install');
        $response->assertRedirect('/dashboard');

        File::delete(storage_path('installed'));
    }
}
