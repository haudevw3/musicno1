<?php

namespace Core\Console\Command;

use ErrorException;
use Core\Console\Command\AbstractMakeCommand;

class ModelMakeCommand extends AbstractMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mk:model {filename} {--module=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model class';

    /**
     * Make stub content.
     * 
     * @throws ErrorException
     */
    protected function make(string $basepath, string $module, string $filename): void
    {
        try {
            $basepath = "{$basepath}/Model";

            $path = "{$basepath}/{$filename}.php";

            if ($this->promptIf($path, $filename)) {
                $this->addStubContentTo('model', $path, [
                    'namespace' => "Modules\\{$module}\\Model",
                    'class' => $filename
                ]);
            }

        } catch (ErrorException $e) {
            $this->error($e->getMessage());
        }
    }
}