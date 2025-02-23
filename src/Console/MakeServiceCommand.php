<?php
namespace Sosupp\SlimDashboard\Console;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;

class MakeTabWrapperCommand extends GeneratorCommand
{
    protected $signature = 'make:slim-service
                            {name : The name of the service class to generate}
                            {--model= : The model class to associate with the service class}
                            {--respository= : The repository class to associate with the service class}';

    protected $description = 'Create a new slim-dashboard table';
    // protected $type = 'BaseTable';

    protected function getStub()
    {
        return __DIR__ . '/Stubs/make-slim-service.php.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Services';
    }

    public function handle()
    {
        parent::handle();


        // Get input arguments
        $name = $this->argument('name');
        $model = $this->option('model') ?: 'YourModel';
        $service = $this->option('service') ?: 'YourService';

        $namespace = $this->qualifyClass($name);
        $getClassName = str(str($name)->explode('\\')->last())->studly()->value;

        // Load the stub
        $stubPath = $this->getStub();
        $stub = file_get_contents($stubPath);

        // Replace basic placeholders
        $content = str_replace(
            ['{{ namespace }}', '{{ class }}', '{{ model }}', '{{ service }}'],
            [$namespace, $getClassName, $model, $service],
            $stub
        );

        $class = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath($class);

         // Write the file
        file_put_contents($path, $content);
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name) .'\\', '', $name);
        // $class = parent::replaceClass($stub, $name);

        return str_replace('{{ class }}', $class, $stub);
    }

}
