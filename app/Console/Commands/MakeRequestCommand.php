<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeRequestCommand extends Command
{
    protected $signature = 'make:api-request {name} {module}';
    protected $description = 'Create Create and Update FormRequests for a specific module/menu (e.g., make:api-request Country Master)';

    public function handle()
    {
        $name   = Str::studly($this->argument('name'));
        $module = Str::studly($this->argument('module'));

        $this->generateRequest('create', $name, $module);
        $this->generateRequest('update', $name, $module);
    }

    protected function generateRequest(string $type, string $name, string $module): void
    {
        $stubPath = base_path("stubs/layered/{$type}-request.stub");

        if (!File::exists($stubPath)) {
            $this->error("Stub not found at $stubPath");
            return;
        }

        $stub    = File::get($stubPath);
        $content = str_replace(
            ['{{name}}', '{{module}}'],
            [$name, $module],
            $stub
        );

        $targetDir = base_path("app/Http/Requests/{$module}/{$name}");
        if (!File::isDirectory($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        $prefix     = ucfirst($type);
        $targetPath = "{$targetDir}/{$prefix}{$name}Request.php";

        if (File::exists($targetPath)) {
            $this->warn("{$prefix}{$name}Request already exists at $targetPath. Skipping...");
            return;
        }

        File::put($targetPath, $content);
        $this->info("Created {$prefix}Request: $targetPath");
    }
}
