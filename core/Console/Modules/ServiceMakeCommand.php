<?php

namespace Core\Console\Modules;

class ServiceMakeCommand extends AbstractFileMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {fileName} {moduleName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service.';
    /**
     * Resolve the console command.
     *
     * @param  string  $basePath
     * @param  string  $fileName
     * @param  string  $moduleName
     * @param  bool    $needMakeDirectory
     * @return void
     */
    public function resolve($basePath, $fileName, $moduleName, $needMakeDirectory = false)
    {
        $path = "{$basePath}/Service";

        if ($needMakeDirectory) {
            $this->filesystem->makeDirectory($path);
            $this->filesystem->makeDirectory("{$path}/Contracts");
        }

        $this->addContentStubTo('contract', "$path/Contracts/{$fileName}.php",
        ['namespace' => "Modules\\{$moduleName}\\Service\\Contracts", 'interface' => $fileName]);

        $this->addContentStubTo('service', "{$path}/{$fileName}.php",
        ['namespace' => "Modules\\{$moduleName}\\Service", 'interface' => "{$fileName}Contract",
         'use' => "Modules\\{$moduleName}\\Service\\Contracts\\{$fileName}", 'class' => $fileName]);
    }
}