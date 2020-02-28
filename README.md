Laravel Package Generator for WovoCMS  
=========================  
  
[![Build Status](https://travis-ci.org/wovosoft/crud.svg?branch=master)](https://travis-ci.org/wovosoft/crud)  [![styleci](https://styleci.io/repos/96041272/shield)](https://styleci.io/repos/96041272)  [![Packagist](https://img.shields.io/packagist/v/melihovv/laravel-package-generator.svg)](https://packagist.org/packages/wovosoft/crud)  [![Packagist](https://poser.pugx.org/melihovv/laravel-package-generator/d/total.svg)](https://packagist.org/packages/wovosoft/crud)  [![Packagist](https://img.shields.io/packagist/l/wovosoft/crud.svg)](https://packagist.org/packages/wovosoft/crud)  
  
Simple package to quickly generate basic structure for other WovoCMS laravel packages.  
  
## Install  
  
Install via composer  
```bash  
composer require --dev wovosoft/crud  
```  
  
Publish package config if you want customize default values  
```bash  
php artisan vendor:publish --provider="Wovosoft\Crud\ServiceProvider" --tag="config"  
```  
  
## Available commands  for Packages
  
### Make A New Package 
`php artisan crud:make_package {vendor} {package}` \
or, with inraction\
`php artisan crud:make_package -i`
 
  
Example: `php artisan crud:make_package Wovosoft SomeAwesomePackage`  
  
This command will:  
  
* Create `packages/wovosoft/some-awesome-package` folder  
* Register package in app composer.json  
* Copy package skeleton from skeleton folder to created folder (you can provide  
your custom skeleton path in config)  
* Run `git init packages/wovosoft/some-awesome-package`  
* Run `composer update wovosoft/some-awesome-package`  
* Run `composer dump-autoload`  
  
With interactive `-i` flag you will be prompted for every needed value from you.  

  ### Remove A Package
`php artisan crud:remove_package {vendor} {package}  `  

Example: `php artisan crud:remove_package Wovosoft SomeAwesomePackage`  
  
This command will:  
  
* Run `composer remove wovosoft/some-awesome-package`  
* Remove `packages/wovosoft/some-awesome-package` folder  
* Unregister package in app composer.json  
* Run `composer dump-autoload`  
  
**Interactive mode also possible.**  
## Available Commands For Controller Generation
### Make a Controller
`php artisan crud:make_controller {vendor} {package} {controller} {model}` \

#### With Interaction Mode
`php artisan crud:make_controller -i`
  
### Remove A Controller
`php artisan crud:remove_controller {vendor} {package} {controller}`
#### With Interaction Mode
`php artisan crud:remove_controller -i`
  
## Available Commands for Model Generation
### Make a Model
`php artisan crud:make_model {vendor} {package} {model}`
#### With Interaction Mode
`php artisan crud:make_model -i`
### Remove a Model
`php artisan crud:remove_model {vendor} {package} {model}`
#### With Interaction Model
`php artisan crud:remove_model -i`
  
## CRUD Console Application 
> There is a Console Application available. To run all above Artisan Commands from a single terminal with less commands, please run `php artisan crud -i` or `php artisan crud`. Then you can see the all available commands in a multiple choice form. Just select an option and that command will start executing immediately in interaction mode. You can then follow the rest of the ongoing processes. 

## Custom skeleton  
> This package will copy all folders and files from specified skeleton path to  package folder. You can use templates in your skeleton. All files with `tpl`  extension will be provided with some variables available to use in them. `tpl`  extension will be stripped.  
  
### Available variables to use in templates:  
  
* vendor (e.g. Wovosoft)  
* package (e.g. SomeAwesomePackage)  
* vendorFolderName (e.g. wovosoft)  
* packageFolderName (e.g. some-awesome-package)  
* packageHumanName (e.g. Some awesome package)  
* composerName (e.g. wovosoft/some-awesome-package)  
* composerDesc (e.g. A some awesome package)  
* composerKeywords (e.g. some,awesome,package)  
* licence (e.g. MIT)  
* phpVersion (e.g. >=7.0)  
* aliasName (e.g. some-awesome-package)  
* configFileName (e.g. some-awesome-package)  
* year (e.g. 2017)  
* name (e.g. Narayan Adhikary)  
* email (e.g. narayanadhikary24@gmail.com)  
* githubPackageUrl (e.g. https://github.com/wovosoft/some-awesome-package)  
* controller (Name of the Controller for Controller Generation)
* model (Name of the Model for Model Generation)
  
## Things you need to do manually:  
  
* Service provider and alias registration (if you use laravel <5.5)  
* In README.md:  
  * StyleCI repository identifier  
  * Package description  
  * Usage section  
  
## Security  
  
If you discover any security related issues, please email narayanadhikary24@gmail.com instead of using the issue tracker.  
  
## Credits  
  
- [Narayan Adhikary](https://github.com/narai420)
- [Wovo Soft](https://gitlab.com/wovosoft)

## Special Thanks
- Special Thanks to https://github.com/melihovv/laravel-package-generator . We have just made an extended version of this package. A Console Application is integrated to perform all operations. Few more commands like Controller, Models with adding and removing features for certain packages are added. 
