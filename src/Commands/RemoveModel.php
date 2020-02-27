<?php

namespace Wovosoft\Crud\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Wovosoft\Crud\Commands\Traits\InteractsWithUser;

class RemoveModel extends Command
{
    use InteractsWithUser;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:remove_model
                            {vendor? : The vendor part of the namespace}
                            {package? : The name of the package for the namespace}
                            {model? : Name of the Model}
                            {--i|interactive : Interactive mode}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to remove Model from a package of Wovosoft CMS packages';

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


        $vendorFolderName = $this->getVendorFolderName($vendor);
        $packageFolderName = $this->getPackageFolderName($package);


        $target = base_path("packages/$vendorFolderName/$packageFolderName/src/Models/$model.php");

        if (!File::exists($target)) {
            $this->warn("Model Doesn't Exists");
            return;
        }

        try {
            $this->info('Trying to delete the model file...');
            if (File::delete($target)) {
                $this->info("$target Model Deleted Successfully.");
            } else {
                $this->error("Unable to delete $target Model.");
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
