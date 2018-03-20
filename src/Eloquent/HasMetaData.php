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

    /**
     * Check if the meta has been set for the metable item, if a variant is
     * passed then check if it is set for the variant.
     *
     * @param Variant|null $variant
     * @return bool
     */
    public function hasMeta(Variant $variant = null)
    {
        if (! empty($variant)) {
            return $this->meta($variant)->exists();
        }
        
        return $this->meta()->whereNull('variant_type')->whereNull('variant_id')->exists();
    }

    /**
     * Get the meta data for the metable item.
     *
     * @param Variant|null $variant
     * @return mixed
     */
    public function getMeta(Variant $variant = null)
    {
        if ($variant) {
            return $this->meta($variant)->getResults();
        }

        return $this->meta()->whereNull('variant_type')->whereNull('variant_id')->getResults();
    }
}
