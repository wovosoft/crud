<?php

namespace Wovosoft\Crud\Commands;

use Exception;
use Illuminate\Console\Command;
use Wovosoft\Crud\Commands\Traits\CopiesSkeleton;
use Wovosoft\Crud\Commands\Traits\InteractsWithGit;
use Wovosoft\Crud\Commands\Traits\ChangesComposerJson;
use Wovosoft\Crud\Commands\Traits\InteractsWithComposer;
use Wovosoft\Crud\Commands\Traits\ManipulatesPackageFolder;

class PackageNew extends Command
{
    use ChangesComposerJson;
    use ManipulatesPackageFolder;
    use InteractsWithComposer;
    use CopiesSkeleton;
    use InteractsWithGit;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:make_package
                            {vendor? : The vendor part of the namespace}
                            {package? : The name of package for the namespace}
                            {--i|interactive : Interactive mode}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new package.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $vendor = $this->getVendor();
        $package = $this->getPackage();

        $vendorFolderName = $this->getVendorFolderName($vendor);
        $packageFolderName = $this->getPackageFolderName($package);

        $relPackagePath = "packages/$vendorFolderName/$packageFolderName";
        $packagePath = base_path($relPackagePath);

        try {
            if (!$vendor && !$package) {
                $this->warn("Vendor and Package name is required");
                return false;
            }
            $this->createPackageFolder($packagePath);
            if (config('wovosoft-crud.register_package_to_composer_dot_json')) {
                $this->registerPackage($vendorFolderName, $packageFolderName, $relPackagePath);
            }

            $this->copySkeleton($packagePath, $vendor, $package, $vendorFolderName, $packageFolderName);

            if (config('wovosoft-crud.init_git_onCreate')) {
                $this->initRepo($packagePath);
            }
            if (config('wovosoft-crud.composer_update_onCreate')) {
                $this->composerUpdatePackage($vendorFolderName, $packageFolderName);
            }
            if (config('wovosoft-crud.composer_dumpAutoload_onCreate')) {
                $this->composerDumpAutoload();
            }


            $this->info('Finished. Are you ready to write awesome package?');

            return 0;
        } catch (Exception $e) {
            $this->error($e->getMessage());

            return -1;
        }
    }
}
