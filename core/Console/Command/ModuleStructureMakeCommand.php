<?php

namespace Core\Console\Command;

use ErrorException;
use Core\Console\Command\AbstractMakeCommand;

class ModuleStructureMakeCommand extends AbstractMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mk:module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module structure';

    /**
     * Get the module name.
     */
    protected function name(): string
    {
        return $this->argument('name');
    }

    /**
     * Get the base path.
     * 
     * @override
     */
    protected function basepath(): string
    {
        return base_path("modules/{$this->name()}");
    }

    /**
     * Get the namespace.
     * 
     * @override
     */
    protected function namespace(): string
    {
        return "Modules\\{$this->ucfirst('name')}";
    }

    /**
     * Execute the console command.
     *
     * @throws ErrorException
     */
    public function handle(): void
    {
        try {
            $this->filesystem->makeDirectory($basepath = $this->basepath());
            $this->filesystem->makeDirectory($contractPath = "{$basepath}/Contract");
            $this->filesystem->makeDirectory("{$contractPath}/Repository");
            $this->filesystem->makeDirectory("{$contractPath}/Service");
            $this->filesystem->makeDirectory("{$basepath}/Controller");
            $this->filesystem->makeDirectory("{$basepath}/Model");
            $this->filesystem->makeDirectory("{$basepath}/Request");
            $this->filesystem->makeDirectory("{$basepath}/Repository");
            $this->filesystem->makeDirectory("{$basepath}/Service");
            $this->filesystem->makeDirectory($viewPath = "{$basepath}/View");
            $this->filesystem->makeDirectory($assetPath = "{$viewPath}/assets");
            $this->filesystem->makeDirectory("{$assetPath}/css");
            $this->filesystem->makeDirectory("{$assetPath}/js");
            $this->filesystem->makeDirectory("{$assetPath}/scss");
            $this->filesystem->makeDirectory($desktopPath = "{$viewPath}/desktop");
            $this->filesystem->makeDirectory("{$desktopPath}/components");
            $this->filesystem->makeDirectory($mobilePath = "{$viewPath}/mobile");
            $this->filesystem->makeDirectory("{$mobilePath}/components");

            $this->addStubContentTo('route', "{$basepath}/route.php");
            $this->addStubContentTo('config', "{$basepath}/config.php");
            $this->addStubContentTo('provider', "{$basepath}/{$this->ucfirst('name')}ServiceProvider.php", [
                'namespace' => $this->namespace(),
                'class' => "{$this->ucfirst('name')}ServiceProvider"
            ]);

        } catch (ErrorException $e) {
            $this->error($e->getMessage());
        }
    }
}