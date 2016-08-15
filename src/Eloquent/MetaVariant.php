<?php

namespace Coreplex\Meta\Eloquent;

trait MetaVariant
{
    /**
     * Get the variant type.
     *
     * @return string
     */
    public function getType()
    {
        return get_class($this);
    }
}