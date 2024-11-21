<?php

namespace Core\Console\Modules;

use Core\Console\Modules\StubHelpers;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

abstract class AbstractFileMakeCommand extends Command
{
    use StubHelpers;
    
    /**
     * The contextual file name.
     *
     * @var string
     */
    protected $fileName;

    /**
     * The module name was created.
     *
     * @var string
     */
    protected $moduleName;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * Create a new "file make command" instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     * @param  string|null                        $fileName
     * @param  string|null                        $moduleName
     * @return void
     */
    public function __construct(Filesystem $filesystem, $fileName = null, $moduleName = null)
    {
        parent::__construct();

        $this->fileName = $fileName;
        $this->moduleName = $moduleName;
        $this->filesystem = $filesystem;
    }

    /**
     * Create a new file with the given arguments.
     *
     * @param  string                             $fileName
     * @param  string                             $moduleName
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     * @return void
     */
    public static function make($fileName, $moduleName, Filesystem $filesystem)
    {
        (new static($filesystem, $fileName, $moduleName))->handle();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $fileName = $this->fileName ?? $this->argument('fileName');
        $moduleName = $this->moduleName ?? $this->argument('moduleName');
        $needMakeDirectory = $this->moduleName ? true : false;
        $basePath = "modules/{$moduleName}";

        $this->resolve(
            $basePath, ucfirst($fileName), ucfirst($moduleName), $needMakeDirectory
        );
    }

    /**
     * Resolve the console command.
     *
     * @param  string  $basePath
     * @param  string  $fileName
     * @param  string  $moduleName
     * @param  bool    $needMakeDirectory
     * @return void
     */
    abstract public function resolve($basePath, $fileName, $moduleName, $needMakeDirectory = false);
}