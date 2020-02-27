<?php

namespace Wovosoft\Crud\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\Engines\PhpEngine;
use Wovosoft\Crud\Commands\Traits\InteractsWithUser;

class RemoveController extends Command
{
    use InteractsWithUser;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:remove_controller
                            {vendor? : The vendor part of the namespace}
                            {package? : The name of package for the namespace}
                            {controller? : Name of the Controller}
                            {--i|interactive : Interactive mode}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to Remove Controller and Route in Wovosoft\'s Packages';

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
        $controller = $this->getController('controller');


        $vendorFolderName = $this->getVendorFolderName($vendor);
        $packageFolderName = $this->getPackageFolderName($package);


        $target = base_path("packages/$vendorFolderName/$packageFolderName/src/Http/Controllers/$controller.php");

        if (!File::exists($target)) {
            $this->warn("Controller Doesn't Exists");
            return;
        }

        try {
            $this->info('Trying to delete the controller file...');
            if (File::delete($target)) {
                $this->info("$target Controller Deleted Successfully.");
                $route_file = base_path("packages/$vendorFolderName/$packageFolderName" . "/src/routes.php");
                $this->info("Trying to delete $target reference from $route_file");
                if (File::exists($route_file) && File::put($route_file, Str::replaceLast(
                        $vendor . "\\" . $package . "\\" . "Http\Controllers" . "\\" . $controller . "::routes();",
                        "",
                        File::get($route_file))
                    )) {
                    $this->info("Controller routes successfully deleted from $route_file");
                } else {
                    $this->error("Unable to delete Controller routes from $route_file.\nPlease Check Manually.");
                }
            } else {
                $this->error("Unable to delete $target Controller.");
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
