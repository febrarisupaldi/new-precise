<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeControllerCommand extends Command
{
    protected $signature = 'make:api-controller
                            {name : Controller name}
                            {module : Module name}';

    protected $description = 'Create API Controller structure';

    public function handle(): void
    {
        $name = Str::studly($this->argument('name'));
        $module = Str::studly($this->argument('module'));

        $nameLower = Str::camel($name);
        $namePlural = Str::plural($name);
        $routeName = Str::kebab(Str::plural($name));
        $moduleLower = Str::kebab($module);

        $stubPath = base_path('stubs/layered/controller.stub');

        if (!File::exists($stubPath)) {
            $this->error("Stub not found at {$stubPath}");

            return;
        }

        $stub = File::get($stubPath);

        $content = str_replace(
            [
                '{{name}}',
                '{{module}}',
                '{{moduleLower}}',
                '{{nameLower}}',
                '{{namePlural}}',
                '{{routeName}}',
            ],
            [
                $name,
                $module,
                $moduleLower,
                $nameLower,
                $namePlural,
                $routeName,
            ],
            $stub
        );

        $targetDir = app_path(
            "Http/Controllers/Api/{$module}"
        );

        File::ensureDirectoryExists($targetDir);

        $targetPath = "{$targetDir}/{$name}Controller.php";

        if (File::exists($targetPath)) {
            $this->warn(
                "Controller already exists: {$targetPath}"
            );

            return;
        }

        File::put($targetPath, $content);

        $this->info(
            "Created Controller: {$targetPath}"
        );
    }
}
