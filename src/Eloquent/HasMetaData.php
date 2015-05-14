<?php namespace Coreplex\Meta\Eloquent;

trait HasMetaData {

    /**
     * Retrieve the meta data for this model
     * 
     * @return Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function meta()
    {
        return $this->morphOne('Coreplex\Meta\Eloquent\Meta', 'metable');
    }

}