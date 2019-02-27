<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Meta Database Connection
    |--------------------------------------------------------------------------
    |
    | Set the database connection to use with Coreplex Meta. Full connections
    | details must be defined in the config/database.php file. If left blank
    | no connection will be specified in the meta models.
    |
    */

    'connection' => env('COREPLEX_META_DATABASE', false),

    /*
    |--------------------------------------------------------------------------
    | Meta Elements
    |--------------------------------------------------------------------------
    |
    | The standard array of meta elements is defined here. Since many different
    | types of elements and attributes are used in meta tags, we have to store
    | a type of dictionary of these elements, which can be easily extended.
    |
    */

    'elements' => [
        'title' => [
            'element' => 'title',
            'empty' => false,
            'content' => ':content | MyWebsite.com',
        ],
        'charset' => [
            'keyAttribute' => false,
            'valueAttribute' => 'charset'
        ]
    ],



    /*
    |--------------------------------------------------------------------------
    | Default Meta Element
    |--------------------------------------------------------------------------
    |
    | When a meta item does not have a definition, the default meta element
    | definition is used.
    |
    */
   
    'default' => [
         'element' => 'meta',
         'keyAttribute' => 'name',
         'valueAttribute' => 'content'
    ],

];
