<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeDomainCommand extends Command
{
    protected $signature = ' make:domain {name : Domain name} {module : Module name} {--detail : Generate master-detail structure} ';
    protected $description = ' Create DTO, Repository, Service, Request, and Controller structure ';

    public function handle(): void
    {
        $name = Str::studly($this->argument('name'));
        $module = Str::studly($this->argument('module'));
        $isDetail = $this->option('detail');
        /** * Detail naming convention */
        $detail = "{$name}Detail";
        /** 
         * ===================================================== 
         * DTO
         * ===================================================== 
         */
        $this->call('make:dto', ['name' => $name, 'module' => $module, '--detail' => $isDetail,]);

        /** * ===================================================== * REPOSITORY * ===================================================== */
        $this->call('make:repository', ['name' => $name, 'module' => $module, '--detail' => $isDetail,]);

        /** * ===================================================== * SERVICE * ===================================================== */
        $this->call('make:service', ['name' => $name, 'module' => $module,]);

        /** * ===================================================== * REQUEST * ===================================================== */
        $this->call('make:api-request', ['name' => $name, 'module' => $module,]);

        /** * ===================================================== * CONTROLLER * ===================================================== */
        $this->call('make:controller', ['name' => "Api/{$module}/{$name}Controller"]);

        /** * Summary */
        $this->showSummary($name, $module, $detail, $isDetail);
    }
    protected function showSummary(string $name, string $module, string $detail, bool $isDetail): void
    {
        $this->newLine();
        $this->info("Domain {$name} generated successfully!");
        $this->newLine();
        $this->line("<comment>Generated structure:</comment>");
        /** * Controller */ $this->line(" app/Http/Controllers/Api/{$module}/{$name}Controller.php");
        /** * DTO */ $this->line(" app/DTOs/{$module}/{$name}/Create{$name}DTO.php");
        $this->line(" app/DTOs/{$module}/{$name}/Update{$name}DTO.php");
        if ($isDetail) {
            $this->line(" app/DTOs/{$module}/{$name}/Create{$detail}DTO.php");
            $this->line(" app/DTOs/{$module}/{$name}/Update{$detail}DTO.php");
        }
        /** * Repository */ $this->line(" app/Repositories/{$module}/{$name}/{$name}Repository.php");
        if ($isDetail) {
            $this->line(" app/Repositories/{$module}/{$name}/{$detail}Repository.php");
        }
        /** * Service */ $this->line(" app/Services/{$module}/{$name}/{$name}Service.php");
        /** * Request */ $this->line(" app/Http/Requests/{$module}/{$name}/Create{$name}Request.php");
        $this->line(" app/Http/Requests/{$module}/{$name}/Update{$name}Request.php");
        $this->newLine();
    }
}
