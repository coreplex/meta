<?php namespace Coreplex\Meta\Eloquent;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Meta extends Eloquent {

    /**
     * The meta items for this object
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()   
    {
        return $this->hasMany('Coreplex\Meta\Eloquent\Meta\Item');
    }

    /**
     * Morph to the relation
     * 
     * @return Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function metable()   
    {
        return $this->morphTo();
    }

}