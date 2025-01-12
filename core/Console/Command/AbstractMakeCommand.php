<?php

namespace Core\Console\Command;

use Closure;
use ErrorException;
use Illuminate\Support\Arr;
use Core\Console\StubHelper;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

abstract class AbstractMakeCommand extends Command
{
    use StubHelper;

    /**
     * Mode initialized manually.
     */
    public const MANUALLY = 0;

    /**
     * Mode initialized by command.
     */
    public const COMMAND = 1;

    /**
     * Mode initialized.
     *
     * @var int
     */
    protected $mode;

    /**
     * Arguments of command or passed while initializing manually.
     *
     * @var array
     */
    protected $arguments;

    /**
     * Options of command or passed while initializing manually.
     *
     * @var array
     */
    protected $options;
    
    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Create a new command instance.
     */
    public function __construct(
        Filesystem $filesystem, ?array $arguments = null,
        ?array $options = null, int $mode = self::COMMAND
    ) {
        parent::__construct();

        $this->mode = $mode;
        $this->arguments = $arguments;
        $this->options = $options;
        $this->filesystem = $filesystem;
    }

    /**
     * Make the command manual way.
     */
    public static function make(array $arguments, ?array $options = null, int $mode = self::MANUALLY): void
    {
        (new static(app(Filesystem::class), $arguments, $options, $mode))->handle();
    }

    /**
     * Touch file with all anything.
     *
     * @throws ErrorException
     */
    protected function touch(Closure $callback): void
    {
        try {
            if (($this->isModeCommand() && $this->overriding()) ||
                ($this->isModeCommand() && $this->missing()) || $this->isNotModeCommand()) {
                $callback();
            }

        } catch (ErrorException $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * Determine if the mode is by command.
     */
    protected function isModeCommand(): bool
    {
        return $this->mode === static::COMMAND;
    }

    /**
     * Determine if the mode is not by command.
     */
    protected function isNotModeCommand(): bool
    {
        return ! $this->isModeCommand();
    } 

    /**
     * Get the module name.
     */
    protected function module(): string
    {
        return $this->options['module'] ?? $this->option('module');
    }

    /**
     * Get the base path.
     */
    protected function basepath(): string
    {
        return base_path("modules/{$this->module()}");
    }

    /**
     * Get the base name of the signature.
     */
    protected function basename(): string
    {
        return Arr::last(explode(':', $this->getName()));
    }

    /**
     * Get the namespace.
     */
    protected function namespace(): string
    {
        return "Modules\\{$this->ucfirst('module')}\\{$this->ucfirst('basename')}\\{$this->filename()}";
    }

    /**
     * Get filename.
     */
    protected function filename(): string
    {
        return $this->arguments['filename'] ?? $this->argument('filename');
    }

    /**
     * Get the full path to the directory file.
     */
    protected function path(): string
    {
        return "{$this->basepath()}/{$this->ucfirst('basename')}/{$this->filename()}.php";
    }

    /**
     * Make a string's first character uppercase with the given method.
     */
    protected function ucfirst(string $method): string
    {
        if (in_array($method, ['module', 'basename', 'name'])) {
            $value = ucfirst($this->{$method}());
        }

        return $value ?? $method;
    }

    /**
     * Determine if the given file name existed and overriding.
     */
    protected function overriding(): bool
    {
        return $this->filesystem->exists($this->path()) &&
                $this->confirm("File {$this->filename()}.php existed. Do you want it's override?");
    }

    /**
     * Determine if the given file name does not exist.
     */
    protected function missing(): bool
    {
        return $this->filesystem->missing($this->path());
    }

    /**
     * Put content to the file path specified.
     */
    protected function putContent(array $contextuals = []): void
    {
        $contextuals = ! empty($contextuals) ? $contextuals : [
            'class' => $this->filename(),
            'namespace' => $this->namespace()
        ];
        
        $this->addStubContentTo(
            $this->basename(), $this->path(), $contextuals
        );
    }
}