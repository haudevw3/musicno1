<?php

namespace Core\Console\Command;

use ErrorException;
use Core\Console\Command\AbstractMakeCommand;
use Core\Console\Command\ContractMakeCommand;

class ServiceMakeCommand extends AbstractMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mk:service {filename} {--module=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

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
                'namespaced' => "Modules\\{$this->ucfirst('module')}\\Contract\\Service\\{$this->filename()}",
            ]);

            ContractMakeCommand::make(
                ['filename' => $this->filename()],
                ['module' => $this->module(), 'dirname' => 'Service']
            );
        });
    }
}