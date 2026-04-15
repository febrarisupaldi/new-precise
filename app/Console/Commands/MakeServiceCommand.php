<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeServiceCommand extends Command
{
    protected $signature = 'make:service {name} {module}';
    protected $description = 'Create a Service for a specific module/menu (e.g., make:service Product Master)';

    public function handle()
    {
        $name      = Str::studly($this->argument('name'));
        $module    = Str::studly($this->argument('module'));
        $menuName  = $name;  // Service name IS the menu name
        $nameLower = Str::camel($name);

        $this->generateFile($name, $module, $menuName, $nameLower);
    }

    protected function generateFile($name, $module, $menuName, $nameLower)
    {
        $stubPath = base_path("stubs/layered/service.stub");
        if (!File::exists($stubPath)) {
            $this->error("Stub not found at $stubPath");
            return;
        }

        $stub    = File::get($stubPath);
        $content = str_replace(
            ['{{name}}', '{{module}}', '{{nameLower}}'],
            [$name, "{$module}\\{$menuName}", $nameLower],
            $stub
        );

        $targetDir = base_path("app/Services/{$module}/{$menuName}");
        if (!File::isDirectory($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        $targetPath = "{$targetDir}/{$name}Service.php";

        if (File::exists($targetPath)) {
            $this->warn("Service already exists at $targetPath. Skipping...");
            return;
        }

        File::put($targetPath, $content);
        $this->info("Created Service: $targetPath");
    }
}
