<?php

namespace Core\Console\Command;

use ErrorException;
use Illuminate\Support\Facades\Artisan;
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
     * Make stub content.
     * 
     * @throws ErrorException
     */
    protected function make(string $basepath, string $module, string $filename): void
    {
        try {
            $basepath = "{$basepath}/Repository";

            $path = "{$basepath}/{$filename}.php";

            if ($this->promptIf($path, $filename)) {
                $this->addStubContentTo('repository', $path, [
                    'namespace' => "Modules\\{$module}\\Repository",
                    'interface' => "{$filename}Contract",
                    'use' => "Modules\\{$module}\\Contract\\Repository\\{$filename}",
                    'class' => $filename
                ]);

                Artisan::call(ContractMakeCommand::class, [
                    'filename' => $filename,
                    '--module' => $module,
                    '--dirname' => 'repository',
                    '--confirm' => 'yes'
                ]);
            }

        } catch (ErrorException $e) {
            $this->error($e->getMessage());
        }
    }
}