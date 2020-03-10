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
}
