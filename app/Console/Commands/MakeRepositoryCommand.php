<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeRepositoryCommand extends Command
{
    protected $signature = ' make:repository {name : Master repository name} {module : Module name}{--detail : Generate master-detail structure} ';
    protected $description = ' Create repository structure ';
    public function handle(): void
    {
        $master = Str::studly($this->argument('name'));
        $module = Str::studly($this->argument('module'));
        $isDetail = $this->option('detail');
        /** * Master repository */ $this->generateRepository(repositoryName: $master, module: $module, master: $master, isDetail: false);
        /** * Detail repository */ if ($isDetail) {
            $detail = "{$master}Detail";
            $this->generateRepository(repositoryName: $detail, module: $module, master: $master, isDetail: true);
        }
        $this->newLine();
        $this->info('Repository generated successfully.');
    }
    protected function generateRepository(string $repositoryName, string $module, string $master, bool $isDetail = false): void
    {
        /** * Stub */ $stubName = $isDetail ? 'repository-detail.stub' : 'repository.stub';
        $stubPath = base_path("stubs/layered/{$stubName}");
        if (!File::exists($stubPath)) {
            $this->error("Stub not found at {$stubPath}");
            return;
        }
        /** * Namespace */ $namespace = "{$module}\\{$master}";
        /** * Table */ $table = Str::snake(Str::pluralStudly($repositoryName));
        /** * Stub content */ $stub = File::get($stubPath);
        $content = str_replace(['{{name}}', '{{module}}', '{{table}}',], [$repositoryName, $namespace, $table,], $stub);
        /** * Folder structure * * Repositories/Transaction/SalesOrder/ */ $targetDir = app_path("Repositories/{$module}/{$master}");
        File::ensureDirectoryExists($targetDir);
        /** * Repository path */ $targetPath = "{$targetDir}/{$repositoryName}Repository.php";
        /** * Prevent overwrite */ if (File::exists($targetPath)) {
            $this->warn("Repository already exists: {$targetPath}");
            return;
        }
        /** * Generate file */ File::put($targetPath, $content);
        $this->info("Created Repository: {$targetPath}");
    }
}
