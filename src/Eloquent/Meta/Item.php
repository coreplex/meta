<?php

namespace Coreplex\Meta\Eloquent\Meta;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Config;

class Item extends Eloquent
{

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // If the connection config has been set then use that for the model connection
        if ($coreplexConnection = Config::get('meta.connection', false)) {
            $this->connection = $coreplexConnection;
        }
    }

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