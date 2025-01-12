<?php

namespace Core\Console\Command;

use ErrorException;
use Core\Console\Command\AbstractMakeCommand;

class ContractMakeCommand extends AbstractMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mk:contract {filename} {--module=} {--dirname=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new contract class';

    /**
     * Get the sub-directory name in the parent directory if any.
     */
    protected function dirname(): ?string
    {
        return $this->options['dirname'] ?? $this->option('dirname');
    }

    /**
     * Get the namespace.
     * 
     * @override
     */
    protected function namespace(): string
    {
        return "Modules\\{$this->ucfirst('module')}\\{$this->ucfirst('basename')}".(
            $this->dirname() ? "\\{$this->dirname()}\\" : "\\"
        )."{$this->filename()}";
    }

    /**
     * Get the full path to the directory file.
     * 
     * @override
     */
    protected function path(): string
    {
        return "{$this->basepath()}/{$this->ucfirst('basename')}".(
            $this->dirname() ? "/{$this->dirname()}/" : "/"
        )."{$this->filename()}.php";
    }

    /**
     * Execute the console command.
     * 
     * @throws ErrorException
     */
    public function handle(): void
    {
        $this->touch(function() {
            $this->putContent([
                'interface' => $this->filename(),
                'namespace' => $this->namespace()
            ]);
        });
    }
}