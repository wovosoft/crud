<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Custom skeleton directory path
    |--------------------------------------------------------------------------
    |
    | This value allows to override default package skeleton.
    | Relative to base project path. Example: storage/skeleton.
    |
    */

    'skeleton_dir_path' => null,
    'init_git_onCreate' => false,
    'register_package_to_composer_dot_json' => true,
    'composer_update_onCreate' => true,
    'composer_dumpAutoload_onCreate' => true,
    'directories_to_create' => [
        "database/migrations",
        "database/factories",
        "database/seeds",
        "src/Traits",
        "src/Models",
        "src/Http/Controllers",
        "resources/js",
        "resources/lang",
        "resources/views",
    ]

];
