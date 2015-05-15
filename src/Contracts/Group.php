<?php namespace Coreplex\Meta\Contracts;

interface Group {

    /**
     * Retrieve the items from the meta group
     * 
     * @return array
     */
    public function meta();

    /**
     * Return the default meta group, if one exists
     * 
     * @return Coreplex\Meta\Contracts\Group|null
     */
    public static function defaultGroup();

}