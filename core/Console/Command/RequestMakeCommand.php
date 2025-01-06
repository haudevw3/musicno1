<?php

namespace Core\Console\Command;

use ErrorException;
use Core\Console\Command\AbstractMakeCommand;

class RequestMakeCommand extends AbstractMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mk:request {filename} {--module=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new request class';

    /**
     * Make stub content.
     * 
     * @throws ErrorException
     */
    protected function make(string $basepath, string $module, string $filename): void
    {
        try {
            $basepath = "{$basepath}/Request";

            $path = "{$basepath}/{$filename}.php";

            if ($this->promptIf($path, $filename)) {
                $this->addStubContentTo('request', $path, [
                    'namespace' => "Modules\\{$module}\\Request",
                    'class' => $filename
                ]);
            }

        } catch (ErrorException $e) {
            $this->error($e->getMessage());
        }
    }
}