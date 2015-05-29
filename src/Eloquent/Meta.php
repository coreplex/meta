<?php namespace Coreplex\Meta\Eloquent;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Coreplex\Meta\Contracts\Group;

class Meta extends Eloquent implements Group {

    /**
     * The refined meta, so that it doesn't refine it twice
     * 
     * @var null|array
     */
    protected $refinedMeta;

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

    /**
     * Returns the meta items from the container
     * 
     * @return array
     */
    public function meta()
    {
        $items = $this->items->toArray();
        $refined = [];

        foreach ($items as $item) {
            // Check if the item data is in JSON format. If so, we store it as
            // an array
            if ($jsonItem = $this->determineJson($item['data'])) {
                $item['data'] = (array) $jsonItem;
            }

            // Assign the data to the key in the refined array
            $refined[$item['key']] = $item['data'];
        }

        return $refined;
    }

    /**
     * Determines whether a given string is JSON or not, returns false if found
     * to be something else, returns the decoded object if not
     * 
     * @return void|array
     */
    private function determineJson($string)
    {
        $json = json_decode($string, true);

        if (is_array($json)) {
            return $json;
        }

        return false;
    }

    /**
     * Return the default meta group, if one exists
     * 
     * @return Coreplex\Meta\Contracts\Group|null
     */
    public static function defaultGroup()   
    {
        $defaultGroup = static::where('default', true)->first();

        return $defaultGroup;
    }

}