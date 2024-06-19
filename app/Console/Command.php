<?php

namespace App\Console;

class Command
{
    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name;

    /**
     * The action to be performed by the command.
     *
     * @var string
     */
    protected $action;

    /**
     * The list of available commands.
     *
     * @var array
     */
    protected $commands = [
        'make:modules'
    ];

    /**
     * Get the name of the command.
     *
     * @return string
     */
    protected function getName()
    {
        return $this->name;
    }

    /**
     * Set the name of the command.
     *
     * @param string $name
     * @return void
     */
    protected function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the action of the command.
     *
     * @return string
     */
    protected function getAction()
    {
        return $this->action;
    }

    /**
     * Set the action of the command.
     *
     * @param string $action
     * @return void
     */
    protected function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Get the list of available commands.
     *
     * @return array
     */
    protected function getCommands()
    {
        return $this->commands;
    }

    /**
     * Display an error message.
     *
     * @param string $message
     * @return void
     */
    protected function error($message)
    {
        echo "\033[31m$message \033[0m\n";
    }

    /**
     * Display a success message.
     *
     * @param string $message
     * @return void
     */
    protected function success($message)
    {
        echo "\033[32m$message \033[0m\n";
    }

    /**
     * Display a warning message.
     *
     * @param string $message
     * @return void
     */
    protected function warning($message)
    {
        echo "\033[33m$message \033[0m\n";
    }

    /**
     * Display an info message.
     *
     * @param string $message
     * @return void
     */
    protected function info($message)
    {
        echo "\033[36m$message \033[0m\n";
    }

    /**
     * Execute the make command.
     *
     * @return void
     */
    public function make()
    {
        $subject = 'php '.implode(' ', $_SERVER['argv']);

        foreach ($this->getCommands() as $command) {
            if (preg_match('/'.$command.'\s+(\w+)/', $subject, $matches)) {
                $this->setName($matches[1]);

                $this->setAction($command);
            } else {
                $this->error('Command does not exists.');
            }
        }
        
        switch ($this->getAction()) {
            case 'make:modules':
                $this->module();
                
                break;
        }
    }

    /**
     * Create a module with the specified name.
     *
     * @return void
     */
    public function module()
    {
        $path = 'modules/'.$this->getName();

        if (is_dir($path)) {
            $this->error('Module already exists.');
        } else {
            mkdir($path, 0777, true);

            mkdir($path.'/Controller', 0777, true);

            mkdir($path.'/Model', 0777, true);

            mkdir($path.'/Repository', 0777, true);

            mkdir($path.'/Repository/Impl', 0777, true);

            mkdir($path.'/Request', 0777, true);

            mkdir($path.'/Service', 0777, true);

            mkdir($path.'/Service/Impl', 0777, true);

            mkdir($path.'/View', 0777, true);

            mkdir($path.'/View/assets', 0777, true);

            mkdir($path.'/View/assets/css', 0777, true);

            mkdir($path.'/View/assets/js', 0777, true);

            mkdir($path.'/View/desktop', 0777, true);

            mkdir($path.'/View/desktop/components', 0777, true);

            file_put_contents($path.'/config.php', '<?php');

            file_put_contents($path.'/Provider.php', '<?php');

            file_put_contents($path.'/routes.php', '<?php');

            $this->info('Module created successfully.');
        }
    }
}