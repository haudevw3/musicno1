<?php

namespace Core\Console\Command;

use ErrorException;
use Core\Console\Command\ContractMakeCommand;

class RepositoryMakeCommand extends AbstractMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mk:repository {filename} {--module=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * Execute the console command.
     * 
     * @throws ErrorException
     */
    public function handle(): void
    {
        $this->touch(function() {
            $this->putContent([
                'class' => $this->filename(),
                'interface' => "{$this->filename()}Contract",
                'namespace' => $this->namespace(),
                'namespaced' => "Modules\\{$this->ucfirst('module')}\\Contract\\Repository\\{$this->filename()}",
            ]);

            ContractMakeCommand::make(
                ['filename' => $this->filename()],
                ['module' => $this->module(), 'dirname' => 'Repository']
            );
        });
    }
}