<?php
namespace Asif\TableToApi;
use Asif\TableToApi\Commands\TableToApiGeneratorCommand;
use Illuminate\Support\ServiceProvider;
class TableToApiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            TableToApiGeneratorCommand::class,
        ]);
        $this->loadTableToApi();
    }

    public function register()
    {

    }

    private function loadTableToApi()
    {
        $basePath=base_path("api/v1");
        if(file_exists($basePath))
        {
            $moduleFolders=scandir($basePath);
            $modules=array_diff($moduleFolders,['.','..']);

            foreach($modules as $module)
            {
                $this->loadTableToApiRoutes($module);
            }
        }
    }

    private function loadTableToApiRoutes($module)
    {
        $routesApiPath=base_path('api/v1/'.$module.'/Routes/'.'api.php');

        if(file_exists($routesApiPath))
        {
            include $routesApiPath;
        }

    }
}
