<?php

namespace Asif\TableToApi\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use File;
use Str;
class TableToApiGeneratorCommand extends Command
{
    public $signature="table2api:generate {tableName}";

    public $description="Generates api using tables";

    private $tableName;

    private $apiPath="api/v1/";

    private $apiFolders=[
        'Controllers',
        'Models',
        'Requests',
        'Routes'
    ];

    public function handle()
    {
        $this->tableName=$this->argument('tableName');

        if(Schema::hasTable($this->tableName))
        {
            $this->generateSkeleton($this->tableName);
        }
        else
        {
            $this->error("Sorry table name does not exist");
        }
    }

    private function generateSkeleton($tableName)
    {
        $this->apiPath.=$this->formatTableName($tableName);
        foreach ($this->apiFolders as $folder) {
            $folderPath = $this->apiPath.'/'.$folder;
            if (!file_exists($folderPath)) {
                File::makeDirectory($folderPath, $mode = 0777, true, true);
            }
        }
        $this->generateModel($this->apiPath,$tableName,$tableName);
        $this->generateController($this->apiPath, Str::studly($tableName));
        $this->generateRequest($this->apiPath,Str::studly($tableName));
    }

    /**
     * This method is used to format a table name as api url
     * @param string $tableName
     * @return string
     */
    private function formatTableName($tableName)
    {
        $dashedTableName=str_replace("_","-",$tableName);
        return Str::plural($dashedTableName);
    }

    private function getStub($stubName)
	{
		return file_get_contents(base_path('vendor/asif/table-to-api/src/stubs/'. $stubName.'.stub'));
	}

	/**
     * This method is used to generate model stub
     * using selected table schemas
     */
	private function generateModel($apiPath,$modelName,$tableName)
    {
        $modelClassName = Str::studly(Str::singular(ucfirst($modelName)));
        $modelTemplate = str_replace(
            [
                '{ApiPath}',
                '{FolderName}',
                '{ModelClassName}',
                '{TableName}',
                '{TableColumnsArray}'
            ],
            [
                str_replace('/', '\\', $this->generateFQNS($apiPath)),
                Str::plural(Str::studly($modelName)),
                $modelClassName,
                $tableName,
                $this->generateModelFillable($tableName)

            ],
            $this->getStub('Model')
        );

        file_put_contents($apiPath . '/Models/' . $modelClassName . '.php', $modelTemplate);
    }

    private function generateFQNS($namespace)
    {
        $namespaceArray=explode("/","api/v1");
        $mapped=array_map(function($data){
            return Str::studly($data);
        }, $namespaceArray);

        return implode("/",$mapped);
    }

    private function generateModelFillable($tableName)
    {
        $columnsArray=Schema::getColumnListing($tableName);
        $mapped=array_map(function($data){
            return "'".$data."'";
        },$columnsArray);
        $fillable=implode(",",$mapped);
        return $fillable;
    }

    public function generateController($apiPath, $modelName)
    {

        $controllerStub = $this->getStub('Controller');
        $controllerTemplate = str_replace(
            [
                '{ApiPath}',
                '{FolderName}',
                '{ApiClass}',
                '{ApiVariablePlural}',
                '{ModelName}',
                '{ApiVariableSingular}',
            ],
            [
                str_replace('/', '\\', $this->generateFQNS($apiPath)),
                Str::plural(Str::studly($modelName)),
                Str::singular($modelName),
                Str::plural(strtolower($modelName)),
                Str::singular($modelName),
                Str::singular(strtolower($modelName)),
            ],
            $controllerStub
        );

        file_put_contents($apiPath . '/Controllers/' . Str::singular($modelName) . 'Controller.php', $controllerTemplate);
    }

    public function generateRequest($apiPath, $modelName)
    {
        $apiClass = Str::singular(ucfirst($modelName));
        $formRequestTemplate = str_replace(
            [
                '{ApiClass}',
                '{ApiPath}',
                '{FolderName}'
            ],
            [
                $apiClass,
                str_replace('/', '\\', $this->generateFQNS($apiPath)),
                Str::studly($modelName)
            ],
            $this->getStub('Request')
        );

        file_put_contents($apiPath . '/Requests/' . $apiClass . 'Request.php', $formRequestTemplate);
    }
}
