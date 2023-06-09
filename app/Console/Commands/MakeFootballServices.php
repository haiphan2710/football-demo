<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeFootballServices extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'football:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new football service';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/Stubs/football-service.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Services\Football';
    }
}
