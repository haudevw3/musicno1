<?php

namespace Core\Console\Modules;

use Illuminate\Contracts\Filesystem\FileNotFoundException;

trait StubHelpers
{
    /**
     * Get content with the given stub name.
     *
     * @param  string  $name
     * @return string
     * 
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getContentStub($name)
    {
        try {
            return $this->filesystem->get(
                $path = "core/Console/stubs/{$name}.stub"
            );
        } catch (FileNotFoundException $e) {
            $this->error("File [$name.stub] not found.");
        }
    }

    /**
     * Change content with the given stub name.
     *
     * @param  string  $name
     * @param  array   $contextuals
     * @return string
     */
    protected function changeContentStub($name, array $contextuals)
    {
        $contentStub = $this->getContentStub($name);

        foreach ($contextuals as $contextual => $content) {
            $contentStub = preg_replace(
                '!{{ '.preg_quote($contextual).' }}!', $content, $contentStub
            );
        }

        return $contentStub;
    }

    /**
     * Write the content stub in a file.
     *
     * @param  string  $path
     * @param  string  $content
     * @param  mixed   $options
     * @return bool
     */
    protected function putContentStub($path, $content, $options = [])
    {
        return $this->filesystem->put($path, $content, $options);
    }

    /**
     * Add the content stub to the given path.
     *
     * @param  string  $name
     * @param  string  $path
     * @param  array   $contextuals
     * @return void
     */
    protected function addContentStubTo($name, $path, array $contextuals = [])
    {
        if (empty($contextuals)) {
            $this->putContentStub($path,
            $this->getContentStub($name));
        } else {
            $this->putContentStub($path,
            $this->changeContentStub($name, $contextuals));
        }
    }
}