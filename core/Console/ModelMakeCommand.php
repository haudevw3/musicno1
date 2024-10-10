<?php

namespace Core\Console;

use Core\Console\Traits\Stub;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ModelMakeCommand extends Command
{
    use Stub;

    /**
     * The name of the model.
     *
     * @var string
     */
    protected $model;

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
    protected $signature = 'make:model {model} {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model.';

    /**
     * Create a new model make command instance.
     * 
     * @param  string  $model
     * @param  string  $module
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     * @return void
     */
    public function __construct(Filesystem $filesystem, $model = null, $module = null)
    {
        parent::__construct();

        $this->model = $model;
        $this->module = $module;
        $this->filesystem = $filesystem;
    }

    /**
     * Create a new model with the given module name.
     *
     * @param  string  $model
     * @param  string  $module
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     * @return void
     */
    public static function make($model, $module, $filesystem)
    {
        (new static($filesystem, $model, $module))->handle();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->resolve(
            $this->model ?? $this->argument('model'),
            $this->module ?? $this->argument('module'),
            $this->module ? true : false
        );
    }

    /**
     * Resolve the console command.
     *
     * @param  string  $model
     * @param  string  $module
     * @param  bool    $need
     * @return void
     */
    protected function resolve($model, $module, $need = false)
    {
        $path = "modules/$module/Models";

        $module = ucfirst($module);
        $model = ucfirst($model);

        if ($need) {
            $this->filesystem->makeDirectory($path);
        }

        $this->addContentStubTo('model', "$path/$model.php",
        ['namespace' => "Modules\\$module\\Models", 'class' => $model]);
    }
}