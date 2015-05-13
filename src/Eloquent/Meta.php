<?php namespace Coreplex\Meta\Eloquent;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Meta extends Eloquent {

    /**
     * The meta items for this object
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meta()   
    {
        $this->belongsTo('Coreplex\Meta\Eloquent\Meta\Item');
    }

    /**
     * Morph to the relation
     * 
     * @return Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function metable()   
    {
        $this->morphTo();
    }

}