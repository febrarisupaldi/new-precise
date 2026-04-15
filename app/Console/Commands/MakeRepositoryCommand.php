<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeRepositoryCommand extends Command
{
    protected $signature = 'make:repository {name} {module}';
    protected $description = 'Create a Repository for a specific module/menu (e.g., make:repository Product Master)';

    public function handle()
    {
        $name      = Str::studly($this->argument('name'));
        $module    = Str::studly($this->argument('module'));
        $menuName  = $name; // Repository name IS the menu name (e.g., "Country")

        $this->generateFile($name, $module, $menuName);
    }

    protected function generateFile($name, $module, $menuName)
    {
        $stubPath = base_path("stubs/layered/repository.stub");
        if (!File::exists($stubPath)) {
            $this->error("Stub not found at $stubPath");
            return;
        }

        $stub    = File::get($stubPath);
        $content = str_replace(
            ['{{name}}', '{{module}}', '{{table}}'],
            [$name, "{$module}\\{$menuName}", Str::snake(Str::pluralStudly($name))],
            $stub
        );

        $targetDir = base_path("app/Repositories/{$module}/{$menuName}");
        if (!File::isDirectory($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        $targetPath = "{$targetDir}/{$name}Repository.php";

        if (File::exists($targetPath)) {
            $this->warn("Repository already exists at $targetPath. Skipping...");
            return;
        }

        File::put($targetPath, $content);
        $this->info("Created Repository: $targetPath");
    }
}
