<?php

return [

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
