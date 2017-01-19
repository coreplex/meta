<?php

namespace Coreplex\Meta\Eloquent;

use Coreplex\Meta\Contracts\Resolver;
use Coreplex\Meta\Contracts\Variant;

trait HasMetaData
{
    /**
     * The current resolver.
     *
     * @var Resolver
     */
    protected $resolver;

    /**
     * Retrieve the meta data for this model
     *
     * @param Variant $variant
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function meta(Variant $variant = null)
    {
        if ( ! $this->hasResolver()) {
            if ( ! $variant) {
                return $this->morphOne('Coreplex\Meta\Eloquent\Meta', 'metable');
            }

            return $this->morphOne('Coreplex\Meta\Eloquent\Meta', 'metable')
                        ->where('variant_id', $variant->getKey())
                        ->where('variant_type', $variant->getType());
        }

        return $this->getResolver()->resolve($this);
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
        return $this->meta($variant)->exists();
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

        return $this->meta;
    }

    /**
     * Check if a resolver has been set.
     *
     * @return bool
     */
    public function hasResolver()
    {
        return ! is_null($this->resolver);
    }

    /**
     * Get the current resolver.
     *
     * @return Resolver|null
     */
    public function getResolver()
    {
        return $this->resolver;
    }

    /**
     * Set the current resolver.
     *
     * @param Resolver $resolver
     * @return $this
     */
    public function setResolver(Resolver $resolver)
    {
        $this->resolver = $resolver;

        return $this;
    }

    /**
     * Alias for the set resolver method.
     *
     * @param Resolver $resolver
     * @return $this
     */
    public function resolver(Resolver $resolver)
    {
        return $this->setResolver($resolver);
    }
}