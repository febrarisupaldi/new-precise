<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeDtoCommand extends Command
{
    protected $signature = 'make:dto {name} {module}';
    protected $description = 'Create a DTO for a specific module/menu (e.g., make:dto CreateProduct Master)';

    public function handle()
    {
        $name   = Str::studly($this->argument('name'));
        $module = Str::studly($this->argument('module'));

        // Determine menu name from the DTO name
        // e.g. "CreateProduct" → menu folder = "Product"
        // We strip common prefixes: Create, Update, Delete, Store, Show
        $menuName = preg_replace('/^(Create|Update|Delete|Store|Show)/i', '', $name);
        if (empty($menuName)) {
            $menuName = $name;
        }

        $this->generateFile($name, $module, $menuName);
    }

    protected function generateFile($name, $module, $menuName)
    {
        $stubPath = base_path("stubs/layered/dto.stub");
        if (!File::exists($stubPath)) {
            $this->error("Stub not found at $stubPath");
            return;
        }

        $stub    = File::get($stubPath);
        $content = str_replace(
            ['{{name}}', '{{module}}'],
            [$name, "{$module}\\{$menuName}"],
            $stub
        );

        $targetDir = base_path("app/DTOs/{$module}/{$menuName}");
        if (!File::isDirectory($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        $targetPath = "{$targetDir}/{$name}DTO.php";

        if (File::exists($targetPath)) {
            $this->warn("DTO already exists at $targetPath. Skipping...");
            return;
        }

        File::put($targetPath, $content);
        $this->info("Created DTO: $targetPath");
    }
}
