<?php

namespace Core\Console;

use Illuminate\Contracts\Filesystem\FileNotFoundException;

trait StubHelper
{ 
    /**
     * Get stub content with the given name.
     * 
     * @throws FileNotFoundException
     */
    protected function getStubContent(string $name): string
    {
        try {
            return $this->filesystem->get(
                __DIR__."/stubs/{$name}.stub"
            );
        } catch (FileNotFoundException $e) {
            $this->error("Not found [$name.stub] file.");
        }
    }

    /**
     * Change stub content with the given name.
     */
    protected function changeStubContent(string $name, array $contextuals): string
    {
        $stubContent = $this->getStubContent($name);

        foreach ($contextuals as $contextual => $value) {
            $stubContent = preg_replace(
                '!{{ '.preg_quote($contextual).' }}!', $value, $stubContent
            );
        }
    
        return $stubContent;
    }

    /**
     * Put content into the stub file.
     */
    protected function putStubContent(string $path, string $content, mixed $options = []): bool
    {
        return $this->filesystem->put($path, $content, $options);
    }

    /**
     * Add the content stub to the given path.
     */
    protected function addStubContentTo(string $name, string $path, array $contextuals = []): void
    {
        if (empty($contextuals)) {
            $this->putStubContent(
                $path, $this->getStubContent($name)
            );
        }
        
        else {
            $this->putStubContent(
                $path, $this->changeStubContent($name, $contextuals)
            );
        }
    }
}