<?php

namespace Modules\Workshop\Scaffold\Module\Generators;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;

class FilesGenerator extends Generator
{
    /**
     * Generate the given files
     *
     * @param array $files
     * @return void
     * @throws FileNotFoundException
     */
    public function generate(array $files)
    {
        foreach ($files as $stub => $file) {
            $this->writeFile(
                $this->getModulesPath($file),
                $this->getContentFor($stub)
            );
        }
    }

    /**
     * Generate the base module service provider
     * @return $this
     * @throws FileNotFoundException
     */
    public function generateModuleProvider(): static
    {
        $this->writeFile(
            $this->getModulesPath("Providers/{$this->name}ServiceProvider"),
            $this->getContentFor('module-service-provider.stub')
        );

        return $this;
    }

    /**
     * Get the content for the given file
     *
     * @param $stub
     * @return string
     * @throws FileNotFoundException
     */
    private function getContentFor($stub): string
    {
        $stub = $this->finder->get($this->getStubPath($stub));

        return str_replace(
            [
                '$MODULE$',
                '$LOWERCASE_MODULE$',
                '$PLURAL_MODULE$',
                '$UPPERCASE_PLURAL_MODULE$',
                '$SIDEBAR_LISTENER_NAME$',
            ],
            [
                $this->name,
                strtolower($this->name),
                strtolower(Str::plural($this->name)),
                Str::plural($this->name),
                "Register{$this->name}Sidebar",
            ],
            $stub
        );
    }
}
