<?php

namespace Core\Console\Command;

use ErrorException;
use Core\Console\Command\AbstractMakeCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class ContractMakeCommand extends AbstractMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mk:contract {filename} {--module=} {--dirname=} {--confirm=no}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new contract class';

    /**
     * Make stub content.
     * 
     * @throws ErrorException
     */
    public function make(string $basepath, string $module, string $filename): void
    {
        try {
            $basepath = "{$basepath}/Contract";

            $dirname = ucfirst($this->option('dirname'));
            
            $path = "{$basepath}/{$dirname}/{$filename}.php";

            if ($this->option('confirm') === 'yes' || $this->promptIf($path, $filename)) {
                $this->addStubContentTo('contract', $path, [
                    'namespace' => "Modules\\{$module}\\Contract\\{$dirname}",
                    'interface' => $filename
                ]);
            }

        } catch (ErrorException $e) {
            $this->error($e->getMessage());
        }
    }
}