<?php
namespace Sosupp\SlimDashboard\Console;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;

class MakePageCommand extends GeneratorCommand
{
    protected $signature = 'make:slim-page
                            {name : The name of the table class to generate}
                            {--model= : The model class to associate with the file}
                            {--service= : The service or repository class to associate with the file}';

    protected $description = 'Create a new slim-dashboard table';
    // protected $type = 'BaseTable';

    protected function getStub()
    {
        return __DIR__ . '/Stubs/make-slim-page.php.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Livewire';
    }

    public function handle()
    {
        parent::handle();


        // Get input arguments
        $name = $this->argument('name');
        $model = $this->option('model') ?: 'YourModel';
        $service = $this->option('service') ?: 'YourService';

        $namespace = $this->qualifyClass($name);
        $className = Str::studly($name);
        $getClassName = str(str($name)->explode('\\')->last())->studly()->value;

        // Load the stub
        $stubPath = $this->getStub();
        $stub = file_get_contents($stubPath);

        $viewPath = 'livewire.'.str($className)->replace('\\', '.')->explode('.')->map(function($item){
            return str($item)->kebab();
        })->implode('.');


        // dd($className, $getClassName);

        // Replace basic placeholders
        $content = str_replace(
            ['{{ namespace }}', '{{ class }}', '{{ model }}', '{{ service }}', '{{ view }}'],
            [$namespace, $getClassName, $model, $service, $viewPath],
            $stub
        );

        $class = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath($class);

         // Write the file
        file_put_contents($path, $content);

        $this->generateViewFile($className);
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name) .'\\', '', $name);
        // $class = parent::replaceClass($stub, $name);

        return str_replace('{{ class }}', $class, $stub);
    }

    protected function generateViewFile($className, $base = 'livewire')
    {
        $viewName = str($className)->replace('\\', '.')->explode('.')->map(function($item){
            return str($item)->kebab();
        })->implode('\\');

        // dd($viewName);

        // Define the default content for the view
        $content = <<<HTML
        {{-- $viewName --}}
        <div>
            <h1>Welcome to $viewName</h1>
        </div>
        HTML;

        $filePath = resource_path("views/$base/$viewName.blade.php");

        // Ensure directory exists
        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }

        // Write the file
        file_put_contents($filePath, $content);
        $this->info("View file created at: $filePath");
        // dd($base, $filePath, $viewName);
    }

}
