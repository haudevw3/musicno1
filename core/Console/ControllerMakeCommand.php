<?php

namespace Core\Console;

use Core\Console\Traits\Stub;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ControllerMakeCommand extends Command
{
    use Stub;

    /**
     * The name of the controller.
     *
     * @var string
     */
    protected $controller;

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
    protected $signature = 'make:controller {controller} {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller.';

    /**
     * Create a new controller make command instance.
     * 
     * @param  string  $controller
     * @param  string  $module
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     * @return void
     */
    public function __construct(Filesystem $filesystem, $controller = null, $module = null)
    {
        parent::__construct();

        $this->controller = $controller;
        $this->module = $module;
        $this->filesystem = $filesystem;
    }

    /**
     * Create a new controller with the given module name.
     *
     * @param  string  $controller
     * @param  string  $module
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     * @return void
     */
    public static function make($controller, $module, $filesystem)
    {
        (new static($filesystem, $controller, $module))->handle();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->resolve(
            $this->controller ?? $this->argument('controller'),
            $this->module ?? $this->argument('module'),
            $this->module ? true : false
        );
    }

    /**
     * Resolve the console command.
     *
     * @param  string  $controller
     * @param  string  $module
     * @param  bool    $need
     * @return void
     */
    protected function resolve($controller, $module, $need = false)
    {
        $path = "modules/$module/Controllers";

        $module = ucfirst($module);
        $controller = ucfirst($controller);

        if ($need) {
            $this->filesystem->makeDirectory($path);
        }
        
        $this->addContentStubTo('controller', "$path/$controller.php",
        ['namespace' => "Modules\\$module\\Controllers", 'class' => $controller]);
    }
}