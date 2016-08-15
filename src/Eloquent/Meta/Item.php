<?php

namespace Coreplex\Meta\Eloquent\Meta;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Item extends Eloquent
{
    /**
     * Define the database table used for the model
     *
     * @var string
     */
    protected $table = 'meta_items';

    /**
     * Define what columns are fillable on the model
     *
     * @var array
     */
    protected $fillable = [
        'meta_id',
        'key',
        'data'
    ];

    /**
     * The meta object this belongs to
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meta()
    {
        return $this->belongsTo('Coreplex\Meta\Eloquent\Meta');
    }
}