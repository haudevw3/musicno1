<?php

namespace Core\Console;

use Core\Console\Traits\Stub;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class RepositoryMakeCommand extends Command
{
    use Stub;

    /**
     * The name of the repository.
     *
     * @var string
     */
    protected $repository;

    /**
     * The name of the module.
     *
     * @var string
     */
    protected $module;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {repository} {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository.';

    /**
     * Create a new repository make command instance.
     * 
     * @param  string  $repository
     * @param  string  $module
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     * @return void
     */
    public function __construct(Filesystem $filesystem, $repository = null, $module = null)
    {
        parent::__construct();

        $this->repository = $repository;
        $this->module = $module;
        $this->filesystem = $filesystem;
    }

    /**
     * Create a new repository with the given module name.
     *
     * @param  string  $repository
     * @param  string  $module
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     * @return void
     */
    public static function make($repository, $module, $filesystem)
    {
        (new static($filesystem, $repository, $module))->handle();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->resolve(
            $this->repository ?? $this->argument('repository'),
            $this->module ?? $this->argument('module'),
            $this->module ? true : false
        );
    }

    /**
     * Resolve the console command.
     *
     * @param  string  $repository
     * @param  string  $module
     * @param  bool    $need
     * @return void
     */
    protected function resolve($repository, $module, $need = false)
    {
        $path = "modules/$module/Repository";

        $module = ucfirst($module);
        $repository = ucfirst($repository);

        if ($need) {
            $this->filesystem->makeDirectory($path);
            $this->filesystem->makeDirectory("$path/Contracts");
        }

        $this->addContentStubTo('contract', "$path/Contracts/$repository.php",
        ['namespace' => "Modules\\$module\\Repository\\Contracts", 'interface' => $repository]);
        
        $this->addContentStubTo('repository', "$path/$repository.php",
        ['namespace' => "Modules\\$module\\Repository", 'interface' => $repository.'Contract',
         'use' => "Modules\\$module\\Repository\\Contracts\\".$repository, 'class' => $repository]);
    }
}