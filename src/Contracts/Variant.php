<?php

namespace Coreplex\Meta\Contracts;

interface Variant
{
    /**
     * Get the primary key for the variant.
     *
     * @return mixed
     */
    public function getKey();

    /**
     * Get the variant type.
     *
     * @return string
     */
    public function getType();
}