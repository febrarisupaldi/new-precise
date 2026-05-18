<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeRequestCommand extends Command
{
    protected $signature = ' make:api-request {name : Domain name} {module : Module name} {--detail : Generate master-detail request} ';
    protected $description = ' Create API Request structure ';
    public function handle(): void
    {
        $name = Str::studly($this->argument('name'));
        $module = Str::studly($this->argument('module'));
        $isDetail = $this->option('detail');
        /** * MASTER REQUEST */ $this->generateRequest(type: 'create', name: $name, module: $module, injectDetailRules: $isDetail);
        $this->generateRequest(type: 'update', name: $name, module: $module, injectDetailRules: $isDetail);
        /** * DETAIL REQUEST */
        if ($isDetail) {
            $detail = "{$name}Detail";
            $this->generateRequest(type: 'create', name: $detail, module: $module);
            $this->generateRequest(type: 'update', name: $detail, module: $module);
        }
        $this->newLine();
        $this->info('Request generated successfully.');
    }
    protected function resolveMenuName(string $name): string
    {
        /** * Remove suffix Detail */
        return preg_replace('/Detail$/', '', $name);
    }
    protected function generateRequest(string $type, string $name, string $module, bool $injectDetailRules = false): void
    {
        /** * Resolve master folder */
        $menuName = $this->resolveMenuName($name);
        /** * Stub */
        $stubPath = base_path("stubs/layered/{$type}-request.stub");
        if (!File::exists($stubPath)) {
            $this->error("Stub not found at {$stubPath}");
            return;
        }
        /** * Stub content */ $stub = File::get($stubPath);
        /** * Inject detail rules */ $detailRules = '';
        if ($injectDetailRules) {
            $detailRules = " /** * Details */ 'details' => ['required', 'array'], // 'details.*.item_id' => ['required'], // 'details.*.qty' => ['required'], ";
        }
        $content = str_replace(['{{name}}', '{{module}}', '{{detail_rules}}',], [$name, "{$module}\\{$menuName}", $detailRules,], $stub);
        /** * Folder structure * * Requests/Transaction/SalesOrder/ */ $targetDir = app_path("Http/Requests/{$module}/{$menuName}");
        File::ensureDirectoryExists($targetDir);
        /** * Request path */
        $prefix = ucfirst($type);
        $targetPath = "{$targetDir}/{$prefix}{$name}Request.php";
        /** * Prevent overwrite */
        if (File::exists($targetPath)) {
            $this->warn("{$prefix}{$name}Request already exists: {$targetPath}");
            return;
        }
        /** * Generate file */ File::put($targetPath, $content);
        $this->info("Created Request: {$targetPath}");
    }
}
