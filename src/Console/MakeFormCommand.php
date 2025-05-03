<?php
namespace Sosupp\SlimDashboard\Console;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;

class MakeFormCommand extends GeneratorCommand
{
    protected $signature = 'make:slim-form
                            {name : The name of the table class to generate}
                            {--model= : The model class to associate with the file}
                            {--service= : The service or repository class to associate with the file}';

    protected $description = 'Create a new slim-dashboard table';
    // protected $type = 'BaseTable';

    protected function getStub()
    {
        return __DIR__ . '/Stubs/make-slim-form.php.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Livewire';
    }

    public function handle()
    {
        // parent::handle();
        // Get input arguments
        $name = $this->argument('name');
        $model = $this->option('model') ?: 'YourModel';
        $modelLower = str($this->option('model'))->lower()->value ?: str('YourModel')->lower()->value;
        $service = $this->option('service') ?: 'YourService';

        $namespace = 'App\\Livewire\\'. $this->getNamespace($name);
        $getClassName = str(str($name)->explode('\\')->last())->studly()->value;


        // Load the stub
        $stubPath = $this->getStub();
        $stub = file_get_contents($stubPath);

        // Replace basic placeholders
        $content = str_replace(
            ['{{ namespace }}', '{{ class }}', '{{ model }}', '{{ modelLower }}', '{{ service }}', '// {{if:model}}'],
            [$namespace, $getClassName, $model, $modelLower, $service, ''],
            $stub
        );


        $class = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath($class);

        // $exists = file_exists($path);
        // dd($path, $exists, $class);

        if(file_exists($path)){
            $this->error($path.' exist');
            return;
        }
         // Write the file
        file_put_contents($path, $content);

        $info = $this->type;
        $this->components->info(sprintf('%s [%s] created successfully.', $info, $path));
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name) .'\\', '', $name);
        // $class = parent::replaceClass($stub, $name);

        return str_replace('{{ class }}', $class, $stub);
    }

}
