<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Example Package
    |--------------------------------------------------------------------------
    |
    | Configuration files provide a great way to customize your package.
    |
    | In most cases, you should provide sane defaults and publishing the config
    | should be optional.
    |
    | Here, we'll define a few inspirational quotes for use in our component
    | and console command.
    |
    */
   'paths' => [
       [
           'namespace' => 'App\\Blocks\\',
           'directory' => 'app/Blocks',
       ],
   ],

   'output_path' => base_path('docs/blocks'),
];
