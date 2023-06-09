<?php

namespace HaiPG\LaravelCore\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeResponse extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hpg:response {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new response';


    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Response';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/response.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Responses';
    }
}
