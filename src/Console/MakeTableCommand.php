<?php
namespace Sosupp\SlimDashboard\Console;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;

class MakeTableCommand extends GeneratorCommand
{
    protected $signature = 'make:slim-table
                            {name : The name of the table class to generate}
                            {--model= : The model class to associate with the file}
                            {--service= : The service or repository class to associate with the file}
                            {--crud : Include form for inline editing and creating}';

    protected $description = 'Create a new slim-dashboard table';
    // protected $type = 'BaseTable';

    protected function getStub()
    {
        return __DIR__ . '/Stubs/make-slim-table.php.stub';
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
        $service = $this->option('service') ?: 'YourService';
        $crud = $this->option('crud')?: false;

        $emptyReplacer = '';

        $namespace = 'App\\Livewire\\'. $this->getNamespace($name);
        $getClassName = str(str($name)->explode('\\')->last())->studly()->value;

        // dd($namespace, $crud);

        // Load the stub
        $stubPath = $this->getStub();
        $stub = file_get_contents($stubPath);

        // if()
        // Replace basic placeholders
        $content = str_replace(
            ['{{ namespace }}', '{{ class }}', '{{ model }}', '{{ service }}', '// {{if:inlineForm}}'],
            [$namespace, $getClassName, $model, $service, $crud ? $emptyReplacer : '// {{if:inlineForm}}'],
            $stub
        );

        if(!$crud){
            // Remove the entire conditional section
            $content = preg_replace('/\s*\/\/ {{if:inlineForm}}.*?\/\/ {{if:inlineForm}}/s', '', $content);
        }


        $class = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath($class);

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
