<?php

namespace Coreplex\Meta\Eloquent;

use Coreplex\Meta\Contracts\Variant;

trait HasMetaData
{
    /**
     * Retrieve the meta data for this model
     *
     * @param Variant $variant
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function meta(Variant $variant = null)
    {
        if ( ! $variant) {
            return $this->morphOne('Coreplex\Meta\Eloquent\Meta', 'metable');
        }

        return $this->morphOne('Coreplex\Meta\Eloquent\Meta', 'metable')
                    ->where('variant_id', $variant->getKey())
                    ->where('variant_type', $variant->getType());
    }
}