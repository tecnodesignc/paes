<?php

namespace Modules\Workshop\Console;

use Illuminate\Console\Command;
use Modules\Workshop\Scaffold\Module\Generators\EntityGenerator;
use Symfony\Component\Console\Input\InputArgument;

final class EntityScaffoldCommand extends Command
{
    protected $name = 'encore:entity:scaffold';
    protected $description = 'Scaffold a new entity with all its resources.';
    /**
     * @var EntityGenerator
     */
    private EntityGenerator $entityGenerator;

    public function __construct(EntityGenerator $entityGenerator)
    {
        parent::__construct();

        $this->entityGenerator = $entityGenerator;
    }

    /**
     * @return void
     */
    public function handle()
    {
        $this->entityGenerator
            ->forModule($this->argument('module'))
            ->type('Eloquent')
            ->generate([$this->argument('entity')], false);

        $this->info('Entity files generated.');
    }

    /**
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['entity', InputArgument::REQUIRED, 'The name of the entity.'],
            ['module', InputArgument::REQUIRED, 'The name of module will be used.'],
        ];
    }
}
