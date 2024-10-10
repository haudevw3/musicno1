<?php

namespace Core\Console;

use Core\Console\Traits\Stub;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ServiceMakeCommand extends Command
{
    use Stub;

    /**
     * The name of the service.
     *
     * @var string
     */
    protected $service;

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
    protected $signature = 'make:service {service} {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service.';

    /**
     * Create a new service make command instance.
     * 
     * @param  string  $service
     * @param  string  $module
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     * @return void
     */
    public function __construct(Filesystem $filesystem, $service = null, $module = null)
    {
        parent::__construct();

        $this->service = $service;
        $this->module = $module;
        $this->filesystem = $filesystem;
    }

    /**
     * Create a new service with the given module name.
     *
     * @param  string  $service
     * @param  string  $module
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     * @return void
     */
    public static function make($service, $module, $filesystem)
    {
        (new static($filesystem, $service, $module))->handle();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->resolve(
            $this->service ?? $this->argument('service'),
            $this->module ?? $this->argument('module'),
            $this->module ? true : false
        );
    }

    /**
     * Resolve the console command.
     *
     * @param  string  $service
     * @param  string  $module
     * @param  bool    $need
     * @return void
     */
    protected function resolve($service, $module, $need = false)
    {
        $path = "modules/$module/Service";

        $module = ucfirst($module);
        $service = ucfirst($service);

        if ($need) {
            $this->filesystem->makeDirectory($path);
            $this->filesystem->makeDirectory("$path/Contracts");
        }

        $this->addContentStubTo('contract', "$path/Contracts/$service.php",
        ['namespace' => "Modules\\$module\\Service\\Contracts", 'interface' => $service]);

        $this->addContentStubTo('repository', "$path/$service.php",
        ['namespace' => "Modules\\$module\\Service", 'interface' => $service.'Contract',
         'use' => "Modules\\$module\\Service\\Contracts\\".$service, 'class' => $service]);
    }
}