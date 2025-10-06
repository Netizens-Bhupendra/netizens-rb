<?php

namespace Netizens\RB\Tests\NT_RB_Testing\Publishing;

use Illuminate\Support\Facades\File;
use Netizens\RB\Tests\RBTestCase;

class PublishTest extends RBTestCase
{
    /** @test */
    public function test_it_can_publish_controllers()
    {
        $targetPath = app_path('Http/Controllers/NtRoleBase');

        // 🧹 Clean before test
        if (File::exists($targetPath)) {
            File::deleteDirectory($targetPath);
        }

        // 🧩 Run publish command
        $this->artisan('vendor:publish', ['--tag' => 'ntrolebase-controllers'])
            ->assertExitCode(0);

        // ✅ Assert file exists
        $this->assertFileExists($targetPath.'/NtRoleBaseController.php');
    }

    /** @test */
    public function test_it_can_publish_routes()
    {
        $targetPath = base_path('routes/ntrolebase/ntrb_routes.php');

        // 🧹 Remove before test
        if (File::exists($targetPath)) {
            File::delete($targetPath);
        }

        // 🧩 Run publish command
        $this->artisan('vendor:publish', ['--tag' => 'ntrolebase-routes'])
            ->assertExitCode(0);

        // ✅ Assert route file exists
        $this->assertFileExists($targetPath);

        // 🧩 (Optional) Check file contains expected route definition
        $content = File::get($targetPath);
        $this->assertStringContainsString('Route::get', $content);
    }

    /** @test */
    public function test_it_can_publish_views()
    {
        $targetPath = resource_path('views/ntrolebase/index.blade.php');

        // 🧹 Clean before test
        $dirPath = resource_path('views/ntrolebase');
        if (File::exists($dirPath)) {
            File::deleteDirectory($dirPath);
        }

        // 🧩 Run publish command
        $this->artisan('vendor:publish', ['--tag' => 'ntrolebase-views'])
            ->assertExitCode(0);

        // ✅ Assert that the view was published correctly
        $this->assertFileExists($targetPath);

        // 🧩 Validate content (match <h1> instead of <html>)
        $content = File::get($targetPath);
        $this->assertStringContainsString('<h1', $content);
    }
}
