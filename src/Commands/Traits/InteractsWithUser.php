<?php

namespace Wovosoft\Crud\Commands\Traits;

use Illuminate\Support\Str;

trait InteractsWithUser
{
    /**
     * Get vendor part of the namespace part.
     *
     * @param string $default
     *
     * @return string
     */
    protected function getVendor($default = '')
    {
        $vendor = $this->argument('vendor') ?: $default;

        return $this->askUser('The vendor name?', $vendor);
    }

    /**
     * Get Model Name
     * @param string $default
     * @return string
     */
    protected function getModel($default = '')
    {
        $vendor = $this->argument('model') ?: $default;

        return $this->askUser('The Model name?', $vendor);
    }

    /**
     * Getting Controller Name
     * @param string $default
     * @return string
     */
    protected function getController($default = '')
    {
        $vendor = $this->argument('controller') ?: $default;

        return $this->askUser('The Controller name?', $vendor);
    }

    /**
     * Getting table name
     * @param string $default
     * @return string
     */
    protected function getTable($default = '')
    {
        $vendor = $this->option('table') ?: $default;

        return $this->askUser('The Table name?', $vendor);
    }


    /**
     * Get the name of package for the namespace.
     *
     * @param string $default
     *
     * @return string
     */
    protected function getPackage($default = '')
    {
        $package = $this->argument('package') ?: $default;

        return $this->askUser('The package name?', $package);
    }

    /**
     * Get vendor folder name.
     *
     * @param string $vendor
     *
     * @return string
     */
    protected function getVendorFolderName($vendor)
    {
        $vendorFolderName = Str::kebab($vendor);

        return $this->askUser('The vendor folder name?', $vendorFolderName);
    }

    /**
     * Get package folder name.
     *
     * @param string $package
     *
     * @return string
     */
    protected function getPackageFolderName($package)
    {
        $packageFolderName = Str::kebab($package);

        return $this->askUser('The package folder name?', $packageFolderName);
    }

    /**
     * Ask user.
     *
     * @param $question
     * @param $defaultValue
     *
     * @return string
     */
    protected function askUser($question, $defaultValue = '')
    {
        if ($this->option('interactive') || $defaultValue == "") {
            return $this->ask($question, $defaultValue);
        }

        return trim($defaultValue);
    }
}
