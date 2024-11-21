<?php

namespace Core\Console\Modules;

use Core\Console\Modules\StubHelpers;
use ErrorException;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ModuleMakeCommand extends Command
{
    use StubHelpers;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module.';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * Create a new "module make command" instance.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->resolve(
            $this->argument('name')
        );
    }

    /**
     * Create a new module with the given name.
     *
     * @param  string  $name
     * @return void
     * 
     * @throws \ErrorException
     */
    protected function resolve($name)
    {
        try {
            $path = "modules/{$name}";
            $this->filesystem->makeDirectory($path);
            $this->filesystem->makeDirectory($viewPath = "{$path}/Views");
            $this->filesystem->makeDirectory($assetPath = "{$viewPath}/assets");
            $this->filesystem->makeDirectory("{$assetPath}/css");
            $this->filesystem->makeDirectory("{$assetPath}/js");
            $this->filesystem->makeDirectory("{$assetPath}/scss");
            $this->filesystem->makeDirectory($desktopPath = "{$viewPath}/desktop");
            $this->filesystem->makeDirectory("{$desktopPath}/components");
            $this->filesystem->makeDirectory($mobilePath = "{$viewPath}/mobile");
            $this->filesystem->makeDirectory("{$mobilePath}/components");

            ControllerMakeCommand::make("{$name}Controller", $name, $this->filesystem);
            ModelMakeCommand::make($name, $name, $this->filesystem);
            RequestMakeCommand::make("{$name}Request", $name, $this->filesystem);
            RepositoryMakeCommand::make("{$name}Repository", $name, $this->filesystem);
            ServiceMakeCommand::make("{$name}Service", $name, $this->filesystem);

            $name = ucfirst($name);

            $this->addContentStubTo('provider', "{$path}/{$name}ServiceProvider.php",
            ['namespace' => "Modules\\{$name}", 'class' => "{$name}ServiceProvider"]);
            $this->addContentStubTo('config', "{$path}/config.php");
            $this->addContentStubTo('routes', "{$path}/routes.php");

            $this->info('Create module success.');
        } catch (ErrorException $e) {
            $this->error("The [$name] module already exists.");
        }
    }
}