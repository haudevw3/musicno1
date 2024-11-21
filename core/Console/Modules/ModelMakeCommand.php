<?php

namespace Core\Console\Modules;

class ModelMakeCommand extends AbstractFileMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:model {fileName} {moduleName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model.';

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
        $path = "{$basePath}/Models";

        if ($needMakeDirectory) {
            $this->filesystem->makeDirectory($path);
        }

        $this->addContentStubTo('model', "$path/{$fileName}.php",
        ['namespace' => "Modules\\{$moduleName}\\Models", 'class' => $fileName]);
    }
}