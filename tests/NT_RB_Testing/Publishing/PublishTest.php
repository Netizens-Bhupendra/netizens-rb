<?php

namespace Netizens\RB\Tests\NT_RB_Testing\Publishing;

use Illuminate\Support\Facades\File;
use Netizens\RB\Tests\RBTestCase;

class PublishTest extends RBTestCase
{
    // /** @test */
    // public function test_it_can_publish_controllers()
    // {
    //     $targetPath = app_path('Http/Controllers/NtRoleBase');

    //     // 🧹 Clean before test
    //     if (File::exists($targetPath)) {
    //         File::deleteDirectory($targetPath);
    //     }

    //     // 🧩 Run publish command
    //     $this->artisan('vendor:publish', ['--tag' => 'ntrolebase-controllers'])
    //         ->assertExitCode(0);

    //     // ✅ Assert file exists
    //     $this->assertFileExists($targetPath.'/NtRoleBaseController.php');
    // }

    // /** @test */
    // public function test_it_can_publish_routes()
    // {
    //     $targetPath = base_path('routes/ntrolebase/ntrb_routes.php');

    //     // 🧹 Remove before test
    //     if (File::exists($targetPath)) {
    //         File::delete($targetPath);
    //     }

    //     // 🧩 Run publish command
    //     $this->artisan('vendor:publish', ['--tag' => 'ntrolebase-routes'])
    //         ->assertExitCode(0);

    //     // ✅ Assert route file exists
    //     $this->assertFileExists($targetPath);

    //     // 🧩 (Optional) Check file contains expected route definition
    //     $content = File::get($targetPath);
    //     $this->assertStringContainsString('Route::get', $content);
    // }

    // /** @test */
    // public function test_it_can_publish_views()
    // {
    //     $targetPath = resource_path('views/ntrolebase/index.blade.php');

    //     // 🧹 Clean before test
    //     $dirPath = resource_path('views/ntrolebase');
    //     if (File::exists($dirPath)) {
    //         File::deleteDirectory($dirPath);
    //     }

    //     // 🧩 Run publish command
    //     $this->artisan('vendor:publish', ['--tag' => 'ntrolebase-views'])
    //         ->assertExitCode(0);

    //     // ✅ Assert that the view was published correctly
    //     $this->assertFileExists($targetPath);

    //     // 🧩 Validate content (match <h1> instead of <html>)
    //     $content = File::get($targetPath);
    //     $this->assertStringContainsString('<h1', $content);
    // }

    // /** @test */
    // public function test_it_can_publish_migrations()
    // {
    //     // point to testbench Laravel app path
    //     $targetDir = base_path('vendor/orchestra/testbench-core/laravel/database/migrations/ntrolebase');

    //     // 🧹 Clean previously published migrations
    //     $publishedFiles = glob($targetDir.'/*_create_migration_table_name_table.php');
    //     foreach ($publishedFiles as $file) {
    //         File::delete($file);
    //     }

    //     // 🧩 Run vendor publish
    //     $this->artisan('vendor:publish', ['--tag' => 'ntrolebase-migrations'])
    //         ->assertExitCode(0);

    //     // ✅ Verify migration copied
    //     // $files = glob($targetDir . '/*_create_migration_table_name_table.php');
    //     // $this->assertNotEmpty($files, 'Migration file was not published.');

    //     // // 🧩 Optional: Validate migration content
    //     // $content = File::get($files[0]);
    //     // $this->assertStringContainsString('Schema::create', $content);
    // }

    /** @test */
    public function test_it_can_publish_all_assets_dynamically()
    {
        $packageRoot = __DIR__.'/../../../'; // adjust if your tests folder is deeper

        $publishMap = [
            'routes' => [
                'source' => $packageRoot.'routes/ntrolebase',
                'target' => base_path('routes/ntrolebase'),
            ],
            'controllers' => [
                'source' => $packageRoot.'src/Http/Controllers/NtRoleBase',
                'target' => app_path('Http/Controllers/NtRoleBase'),
            ],
            'views' => [
                'source' => $packageRoot.'resources/views/ntrolebase',
                'target' => resource_path('views/ntrolebase'),
            ],
            'migrations' => [
                'source' => $packageRoot.'database/migrations/ntrolebase',
                'target' => database_path('migrations/ntrolebase'),
            ],
        ];

        // Ensure parent directories exist before publishing
        foreach ($publishMap as $map) {
            if (! File::exists($map['target'])) {
                File::makeDirectory($map['target'], 0755, true);
            }
        }

        // Run publish command
        $this->artisan('vendor:publish', ['--tag' => 'ntrolebase-all'])
            ->assertExitCode(0);

        // Check each file dynamically
        foreach ($publishMap as $map) {
            $sourceFiles = File::allFiles($map['source']);
            foreach ($sourceFiles as $file) {
                $relativePath = $file->getRelativePathname();
                $targetFile = $map['target'].'/'.$relativePath;

                $this->assertFileExists($targetFile, "Failed asserting published file exists: $targetFile");
            }
        }
    }
}
