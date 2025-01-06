<?php

namespace Core\Console\Command;

use Closure;
use Core\Console\StubHelper;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

abstract class AbstractMakeCommand extends Command
{
    use StubHelper;
    
    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Create a new command instance.
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->make(
            $this->basepath(),
            ucfirst($this->option('module')),
            $this->argument('filename')
        );
    }

    /**
     * Get the base path to any directory in the modules directory.
     */
    protected function basepath(): string
    {
        return 'modules/'.strtolower($this->option('module'));
    }

    /**
     * Make stub content.
     */
    abstract protected function make(string $basepath, string $module, string $filename): void;

    /**
     * Prompt if the given file name existed.
     */
    protected function promptIf(string $path, string $filename): bool
    {
        if ($this->filesystem->missing($path) ||
            ($this->filesystem->exists($path) && $this->confirm("File {$filename}.php existed. Do you want it's override?"))) {
            return true;
        }

        return false;
    }
}