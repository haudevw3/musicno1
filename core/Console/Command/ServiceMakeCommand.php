<?php

namespace Core\Console\Command;

use ErrorException;
use Illuminate\Support\Facades\Artisan;
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
     * Make stub content.
     * 
     * @throws ErrorException
     */
    protected function make(string $basepath, string $module, string $filename): void
    {
        try {
            $basepath = "{$basepath}/Service";

            $path = "{$basepath}/{$filename}.php";

            if ($this->promptIf($path, $filename)) {
                $this->addStubContentTo('service', $path, [
                    'namespace' => "Modules\\{$module}\\Service",
                    'interface' => "{$filename}Contract",
                    'use' => "Modules\\{$module}\\Contract\\Service\\{$filename}",
                    'class' => $filename
                ]);

                Artisan::call(ContractMakeCommand::class, [
                    'filename' => $filename,
                    '--module' => $module,
                    '--dirname' => 'service',
                    '--confirm' => 'yes'
                ]);
            }

        } catch (ErrorException $e) {
            $this->error($e->getMessage());
        }
    }
}