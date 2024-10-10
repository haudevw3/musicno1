<?php

namespace Core\Console;

use Core\Console\Traits\Stub;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class RequestMakeCommand extends Command
{
    use Stub;

    /**
     * The name of the request.
     *
     * @var string
     */
    protected $request;

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
    protected $signature = 'make:request {request} {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new request.';

    /**
     * Create a new request make command instance.
     * 
     * @param  string  $request
     * @param  string  $module
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     * @return void
     */
    public function __construct(Filesystem $filesystem, $request = null, $module = null)
    {
        parent::__construct();

        $this->request = $request;
        $this->module = $module;
        $this->filesystem = $filesystem;
    }

    /**
     * Create a new request with the given module name.
     *
     * @param  string  $request
     * @param  string  $module
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     * @return void
     */
    public static function make($request, $module, $filesystem)
    {
        (new static($filesystem, $request, $module))->handle();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->resolve(
            $this->request ?? $this->argument('request'),
            $this->module ?? $this->argument('module'),
            $this->module ? true : false
        );
    }

    /**
     * Resolve the console command.
     *
     * @param  string  $request
     * @param  string  $module
     * @param  bool    $need
     * @return void
     */
    protected function resolve($request, $module, $need = false)
    {
        $path = "modules/$module/Request";

        $module = ucfirst($module);
        $request = ucfirst($request);

        if ($need) {
            $this->filesystem->makeDirectory($path);
        }

        $this->addContentStubTo('request', "$path/$request.php",
        ['namespace' => "Modules\\$module\\Request", 'class' => $request]);
    }
}