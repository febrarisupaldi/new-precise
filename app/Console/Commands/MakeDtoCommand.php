<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeDtoCommand extends Command
{
    protected $signature = ' make:dto {name : DTO name} {module : Module name} {--detail : Generate aggregate master-detail DTO} ';
    protected $description = ' Create DTO structure ';
    public function handle(): void
    {
        $name = Str::studly($this->argument('name'));
        $module = Str::studly($this->argument('module'));
        $isDetail = $this->option('detail');
        /** * MASTER DETAIL DTO */
        if ($isDetail) {
            $this->generateMasterDetailDTO($name, $module);
            return;
        }
        /** * NORMAL DTO */
        $this->generateNormalDTO($name, $module);
    }

    protected function generateNormalDTO(string $name, string $module): void
    {
        $this->generateFile("Create{$name}", $module, $name);
        $this->generateFile("Update{$name}", $module, $name);
    }

    /** * Generate aggregate + master + detail DTO */
    protected function generateMasterDetailDTO(string $name, string $module): void
    {
        /** * Create */
        $this->generateFile("Create{$name}", $module, $name, true);
        $this->generateFile("Create{$name}Master", $module, $name);
        $this->generateFile("Create{$name}Detail", $module, $name);
        /** * Update */
        $this->generateFile("Update{$name}", $module, $name, true);
        $this->generateFile("Update{$name}Master", $module, $name);
        $this->generateFile("Update{$name}Detail", $module, $name);
    }

    protected function generateFile(string $name, string $module, string $menuName, bool $isAggregate = false): void
    {
        /** * Stub */ $stubPath = base_path('stubs/layered/dto.stub');
        if (!File::exists($stubPath)) {
            $this->error("Stub not found at {$stubPath}");
            return;
        }
        $stub = File::get($stubPath);
        /** * Aggregate DTO */ if ($isAggregate) {
            $baseName = preg_replace('/^(Create|Update)/', '', $name);
            $aggregateFields = " public {$name}MasterDTO \$master;\n\n" . " /**\n" . " * @var array<{$name}DetailDTO>\n" . " */\n" . " public array \$details = [];\n";
            $stub = str_replace('// public $property;', $aggregateFields, $stub);
        }
        /** * Update DTO */
        elseif (Str::startsWith($name, 'Update')) {
            $auditFields = " public string \$updated_by;\n" . " public string \$reason;\n";
            $auditMapping = " \$dto->updated_by = \$request->input('updated_by');\n" . " \$dto->reason = \$request->input('reason');\n";
            $stub = str_replace('// public $property;', $auditFields, $stub);
            $stub = str_replace('// $dto->property = $request->input(\'property\');', $auditMapping, $stub);
        }
        /** * Namespace */
        $namespace = "{$module}\\{$menuName}";
        /** * Stub content */
        $content = str_replace(['{{name}}', '{{module}}',], [$name, $namespace,], $stub);
        /** * DTO folder */
        $targetDir = app_path("DTOs/{$module}/{$menuName}");
        File::ensureDirectoryExists($targetDir);
        /** * DTO path */
        $targetPath = "{$targetDir}/{$name}DTO.php";
        /** * Prevent overwrite */
        if (File::exists($targetPath)) {
            $this->warn("DTO already exists: {$targetPath}");
            return;
        }
        /** * Generate file */ File::put($targetPath, $content);
        $this->info("Created DTO: {$targetPath}");
    }
}
