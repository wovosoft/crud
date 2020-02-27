<?php

namespace Wovosoft\Crud\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\Engines\PhpEngine;
use Wovosoft\Crud\Commands\Traits\InteractsWithUser;

class MakeController extends Command
{
    use InteractsWithUser;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:make_controller
                            {vendor? : The vendor part of the namespace}
                            {package? : The name of package for the namespace}
                            {controller? : Name of the Controller}
                            {model? : Name of the Model with namespace}
                            {--i|interactive : Interactive mode}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to make controller';

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
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle()
    {

        $vendor = $this->getVendor('vendor');
        $package = $this->getPackage('package');
        $model = $this->getModel('model');
        $controller = $this->getController('controller');


        $vendorFolderName = $this->getVendorFolderName($vendor);
        $packageFolderName = $this->getPackageFolderName($package);


        $relPackagePath = base_path("packages/$vendorFolderName/$packageFolderName/src/Http/Controllers/$controller.php.tpl");
        $target = base_path("packages/$vendorFolderName/$packageFolderName/src/Http/Controllers/$controller.php");

        if (File::exists($target)) {
            $this->warn('Controller Already Exits. Exiting...');
            return;
        }
        if (!File::exists(dirname($relPackagePath))) {
            File::makeDirectory(dirname($relPackagePath), 0755, true);
        }
        if (!File::exists($relPackagePath)) {
            File::copy(__DIR__ . '/../../stubs/Controller.php.tpl', $relPackagePath);
            $this->info("Controller Stub copied to $relPackagePath");
        }

        $this->info('Trying to parse the stub');

        $phpEngine = app()->make(PhpEngine::class);
        try {
            $newFileContent = $phpEngine->get($relPackagePath, [
                "vendor" => $vendor,
                "package" => $package,
                "controller" => $controller,
                "model" => $model,
            ]);
        } catch (\Exception $e) {
            $this->error("Template [$relPackagePath] contains syntax errors");
            $this->error($e->getMessage());
            $this->error("LINE # " . $e->getLine());
        }
        $this->info("Stub Parsing Successful. Putting Parsed content to Controller File");
        File::put($target, $newFileContent);
        File::delete($relPackagePath);

        $route_file = base_path("packages/$vendorFolderName/$packageFolderName" . "/src/routes.php");
        if (File::exists($target) && File::exists($route_file)) {
            File::put($route_file, Str::replaceLast(
                "//MAPPING_AREA_FOR_CRUD_DO_NOT_REMOVE_OR_EDIT_THIS_LINE//",
                $vendor . "\\" . $package . "\\" . "Http\Controllers" . "\\" . $controller . "::routes();\n" .
                "\t\t//MAPPING_AREA_FOR_CRUD_DO_NOT_REMOVE_OR_EDIT_THIS_LINE//",
                File::get(base_path("packages/$vendorFolderName/$packageFolderName" . "/src/routes.php"))
            ));
        }
        $this->info("Stub File Deleted Successfully");
        $this->info("Controller Created Successfully");

    }
}
