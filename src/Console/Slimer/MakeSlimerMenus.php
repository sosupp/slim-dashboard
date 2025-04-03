<?php
namespace Sosupp\SlimDashboard\Console\Slimer;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeSlimerMenus extends Command
{

    protected $signature = 'slimer:menus';
    protected $description = 'Publish a menu class used to add navigation menus 
                            to slim-dashboard navigations';

    protected Filesystem $files;

    public function handle()
    {
        $componentClassPath = app_path("View/Components/Slimer/Menus.php");

        // Ensure directories exist
        $this->makeDirectory($componentClassPath);

        // Publish the Component Class
        if (!$this->files->exists($componentClassPath)) {
            $this->files->put($componentClassPath, $this->getComponentClassTemplate());
            $this->info("View Component Class published: {$componentClassPath}");
        } else {
            $this->warn("View Component Class already exists: {$componentClassPath}");
        }

    }

    protected function makeDirectory($path)
    {
        $directory = dirname($path);
        if (!$this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }
    }

    protected function getComponentClassTemplate()
    {
        return <<<PHP
        <?php

        namespace App\View\Components\Slimer;

        use Sosupp\SlimDashboard\Html\MenuNav;

        class Menus
        {
            public static function items()
            {
                // Add more menus here
                return MenuNav::item(
                    name: 'dashboard', url: null, key: 'dashboard', isCurrent: true,
                    authorize: true, icon: view('slim-dashboard::components.icons.dashboard-custom', ['color' => 'purple'])
                )
                ->item(
                    name: 'Menu 2', url: null, key: 'menu-2',
                    icon: view('slim-dashboard::components.icons.group', ['color' => 'purple'])
                )
                ->logo(
                    name: 'susu', key: '', route: null,
                    view: 'logo name or pass a view
                )
                ->globalActions(
                    name: 'Action 1', key: 'action-1'
                )
                ->globalActions(
                    name: 'Action 2', key: 'action-2'
                )
                ->extraView(
                    key: 'custom-actions', view: 'Some extra stuff...pass a view'
                )
                ->styles(wrapperCss: '', navsBg: '')
                ->logout(key: 'logout', route: route('logout'))
                ->make();
            }
        }
        PHP;
    }
    

}