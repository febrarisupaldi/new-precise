<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeDomainCommand extends Command
{
    protected $signature = 'make:domain {name} {module}';
    protected $description = 'Create DTO (Create+Update), Repository, Service, and Request files for a domain menu (e.g., make:domain Country Master)';

    public function handle()
    {
        $name   = $this->argument('name');
        $module = $this->argument('module');

        // Create DTOs for Create and Update
        $this->call('make:dto', ['name' => "Create{$name}", 'module' => $module]);
        $this->call('make:dto', ['name' => "Update{$name}", 'module' => $module]);

        // Create Repository and Service
        $this->call('make:repository', ['name' => $name, 'module' => $module]);
        $this->call('make:service', ['name' => $name, 'module' => $module]);

        // Create Request files
        $this->call('make:api-request', ['name' => $name, 'module' => $module]);

        $studlyName   = \Illuminate\Support\Str::studly($name);
        $studlyModule = \Illuminate\Support\Str::studly($module);

        $this->info("");
        $this->info("Domain files for {$studlyName} in {$studlyModule} created successfully!");
        $this->line("");
        $this->line("  <comment>Folder structure:</comment>");
        $this->line("  app/DTOs/{$studlyModule}/{$studlyName}/Create{$studlyName}DTO.php");
        $this->line("  app/DTOs/{$studlyModule}/{$studlyName}/Update{$studlyName}DTO.php");
        $this->line("  app/Repositories/{$studlyModule}/{$studlyName}/{$studlyName}Repository.php");
        $this->line("  app/Services/{$studlyModule}/{$studlyName}/{$studlyName}Service.php");
        $this->line("  app/Http/Requests/{$studlyModule}/{$studlyName}/Create{$studlyName}Request.php");
        $this->line("  app/Http/Requests/{$studlyModule}/{$studlyName}/Update{$studlyName}Request.php");
    }
}
