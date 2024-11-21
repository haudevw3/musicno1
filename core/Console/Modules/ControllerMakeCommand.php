<?php

namespace Core\Console\Modules;

class ControllerMakeCommand extends AbstractFileMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:controller {fileName} {moduleName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller.';

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
        $path = "{$basePath}/Controllers";

        if ($needMakeDirectory) {
            $this->filesystem->makeDirectory($path);
        }
        
        $this->addContentStubTo('controller', "{$path}/{$fileName}.php",
        ['namespace' => "Modules\\{$moduleName}\\Controllers", 'class' => $fileName]);
    }
}