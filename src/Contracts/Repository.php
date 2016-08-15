<?php

namespace Coreplex\Meta\Contracts;

interface Repository
{
    /**
     * Find a meta group by it's identifier
     *
     * @param  mixed $identifier
     * @return Group
     */
    public function find($identifier);

    /**
     * Get the default meta group if one exists
     *
     * @return Group|null
     */
    public function defaultGroup();
}