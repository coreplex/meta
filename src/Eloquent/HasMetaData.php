<?php

namespace Coreplex\Meta\Eloquent;

use Coreplex\Meta\Contracts\Determiner;
use Coreplex\Meta\Contracts\Variant;

trait HasMetaData
{
    /**
     * The current determiner.
     *
     * @var Determiner
     */
    protected $determiner;

    /**
     * Retrieve the meta data for this model
     *
     * @param Variant $variant
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function meta(Variant $variant = null)
    {
        if ( ! $this->hasDeterminer()) {
            if ( ! $variant) {
                return $this->morphOne('Coreplex\Meta\Eloquent\Meta', 'metable');
            }

            return $this->morphOne('Coreplex\Meta\Eloquent\Meta', 'metable')
                        ->where('variant_id', $variant->getKey())
                        ->where('variant_type', $variant->getType());
        }

        return $this->getDeterminer()->determine($this);
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
     * Check if a determiner has been set.
     *
     * @return bool
     */
    public function hasDeterminer()
    {
        return ! is_null($this->determiner);
    }

    /**
     * Get the current determiner.
     *
     * @return Determiner|null
     */
    public function getDeterminer()
    {
        return $this->determiner;
    }

    /**
     * Set the current determiner.
     *
     * @param Determiner $determiner
     * @return $this
     */
    public function setDeterminer(Determiner $determiner)
    {
        $this->determiner = $determiner;

        return $this;
    }

    /**
     * Alias for the set determiner method.
     *
     * @param Determiner $determiner
     * @return $this
     */
    public function determiner(Determiner $determiner)
    {
        return $this->setDeterminer($determiner);
    }
}