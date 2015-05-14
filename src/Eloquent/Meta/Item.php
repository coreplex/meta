<?php namespace Coreplex\Meta\Eloquent\Meta;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Item extends Eloquent {

    /**
     * The meta object this belongs to
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meta()   
    {
        $this->belongsTo('Coreplex\Meta\Eloquent\Meta');
    }

}