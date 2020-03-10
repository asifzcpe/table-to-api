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
    }

    public function register()
    {

    }
}
