<?php

namespace Wovosoft\Crud\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\View\Engines\PhpEngine;
use Wovosoft\Crud\Commands\Traits\InteractsWithUser;

class MakeModel extends Command
{
    use InteractsWithUser;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:make_model
                            {vendor? : The vendor part of the namespace}
                            {package? : The name of package for the namespace}
                            {model? : The name of Model}
                            {--i|interactive : Interactive mode}
                            {--table= : Name of the table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to make Model for specific package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $vendor = $this->getVendor('vendor');
        $package = $this->getPackage('package');
        $model = $this->getModel('model');
        $table = $this->getTable('table');

        $vendorFolderName = $this->getVendorFolderName($vendor);
        $packageFolderName = $this->getPackageFolderName($package);

        $relPackagePath = base_path("packages/$vendorFolderName/$packageFolderName/src/Models/$model.php.tpl");
        $target = base_path("packages/$vendorFolderName/$packageFolderName/src/Models/$model.php");
        if (File::exists($target)) {
            $this->warn('Model Already Exits. Exiting...');
            return;
        }
        if (!File::exists(dirname($relPackagePath))) {
            File::makeDirectory(dirname($relPackagePath), 0755, true);
        }
        if (!File::exists($relPackagePath)) {
            File::copy(__DIR__ . '/../../stubs/Model.php.tpl', $relPackagePath);
            $this->info("Model Stub copied to $relPackagePath");
        }
        $this->info('Trying to parse the stub');

        $phpEngine = app()->make(PhpEngine::class);
        try {
            $newFileContent = $phpEngine->get($relPackagePath, [
                "vendor" => $vendor,
                "package" => $package,
                "model" => $model,
                "table" => $table
            ]);
        } catch (\Exception $e) {
            $this->error("Template [$relPackagePath] contains syntax errors");
            $this->error($e->getMessage());
            $this->error("LINE # " . $e->getLine());
        }
        $this->info("Stub Parsing Successful. Putting Parsed content to Model file");
        File::put($target, $newFileContent);
        File::delete($relPackagePath);
        $this->info("Stub File Deleted Successfully");
        $this->info("Model Created Successfully");

    }
}
