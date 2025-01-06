<?php

namespace Core\Console\Command;

use ErrorException;
use Illuminate\Console\Command;
use Core\Console\Command\AbstractMakeCommand;

class ControllerMakeCommand extends AbstractMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mk:controller {filename} {--module=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller class';

    /**
     * Make stub content.
     * 
     * @throws ErrorException
     */
    protected function make(string $basepath, string $module, string $filename): void
    {
        try {
            $basepath = "{$basepath}/Controller";

            $path = "{$basepath}/{$filename}.php";

            if ($this->promptIf($path, $filename)) {
                $this->addStubContentTo('controller', $path, [
                    'namespace' => "Modules\\{$module}\\Controller",
                    'class' => $filename
                ]);
            }

        } catch (ErrorException $e) {
            $this->error($e->getMessage());
        }
    }
}