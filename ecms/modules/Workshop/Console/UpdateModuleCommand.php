<?php

namespace Modules\Workshop\Console;

use Illuminate\Console\Command;
use Modules\Core\Services\Composer;
use Symfony\Component\Console\Input\InputArgument;

class UpdateModuleCommand extends Command
{
    protected $name = 'encore:module:update';
    protected $description = 'Update a module';

    /**
     * @var Composer
     */
    private Composer $composer;

    public function __construct(Composer $composer)
    {
        parent::__construct();
        $this->composer = $composer;
    }

    public function handle()
    {
        $packageName = $this->getModulePackageName($this->argument('module'));

        $this->composer->enableOutput($this);
        $this->composer->update($packageName);
    }

    /**
     * Make the full package name for the given module name
     * @param string $module
     * @return string
     */
    private function getModulePackageName(string $module): string
    {
        return "tecnodesignc/{$module}-module";
    }

    /**
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['module', InputArgument::REQUIRED, 'The module name'],
        ];
    }
}
