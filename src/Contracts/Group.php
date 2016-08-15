<?php

namespace Coreplex\Meta\Contracts;

interface Group
{
    /**
     * Retrieve the items from the meta group
     *
     * @return array
     */
    public function meta();

    /**
     * Return the default meta group, if one exists
     *
     * @return Group|null
     */
    public static function defaultGroup();
}