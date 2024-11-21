<?php

namespace Core\Console\Modules;

class RepositoryMakeCommand extends AbstractFileMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {fileName} {moduleName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository.';

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
        $path = "{$basePath}/Repository";

        if ($needMakeDirectory) {
            $this->filesystem->makeDirectory($path);
            $this->filesystem->makeDirectory("{$path}/Contracts");
        }

        $this->addContentStubTo('contract', "{$path}/Contracts/{$fileName}.php",
        ['namespace' => "Modules\\{$moduleName}\\Repository\\Contracts", 'interface' => $fileName]);
        
        $this->addContentStubTo('repository', "{$path}/{$fileName}.php",
        ['namespace' => "Modules\\{$moduleName}\\Repository", 'interface' => "{$fileName}Contract",
         'use' => "Modules\\{$moduleName}\\Repository\\Contracts\\{$fileName}", 'class' => $fileName]);
    }
}