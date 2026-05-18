<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeServiceCommand extends Command
{
    protected $signature = ' make:service {name : Service name} {module : Module name} ';
    protected $description = ' Create Service structure ';
    public function handle(): void
    {
        $name = Str::studly($this->argument('name'));
        $module = Str::studly($this->argument('module'));
        $nameLower = Str::camel($name);
        $this->generateFile($name, $module, $nameLower);
    }
    protected function generateFile(string $name, string $module, string $nameLower): void
    {
        /** * Stub */ $stubPath = base_path('stubs/layered/service.stub');
        if (!File::exists($stubPath)) {
            $this->error("Stub not found at {$stubPath}");
            return;
        }
        /** * Stub content */ $stub = File::get($stubPath);
        $content = str_replace(['{{name}}', '{{module}}', '{{nameLower}}',], [$name, $module, $nameLower,], $stub);
        /** * Folder structure * * Services/Transaction/ */ $targetDir = app_path("Services/{$module}");
        File::ensureDirectoryExists($targetDir);
        /** * Service path */ $targetPath = "{$targetDir}/{$name}Service.php";
        /** * Prevent overwrite */ if (File::exists($targetPath)) {
            $this->warn("Service already exists: {$targetPath}");
            return;
        }
        /** * Generate file */ File::put($targetPath, $content);
        $this->info("Created Service: {$targetPath}");
    }
}
