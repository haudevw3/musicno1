<?php

namespace Core\Console\Modules;

class RequestMakeCommand extends AbstractFileMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:request {fileName} {moduleName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new request.';
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
        $path = "{$basePath}/Request";

        if ($needMakeDirectory) {
            $this->filesystem->makeDirectory($path);
        }

        $this->addContentStubTo('request', "{$path}/{$fileName}.php",
        ['namespace' => "Modules\\{$moduleName}\\Request", 'class' => $fileName]);
    }
}