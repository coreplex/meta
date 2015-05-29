<?php namespace Coreplex\Meta\Eloquent;

use Coreplex\Meta\Contracts\Repository as Contract;
use Coreplex\Meta\Exceptions\MetaGroupNotFoundException;

class Repository implements Contract {

    /**
     * Find a meta group by it's identifier
     * 
     * @param  mixed $identifier
     * @return Coreplex\Meta\Contracts\Group
     */
    public function find($identifier)
    {
        if ($meta = Meta::where('identifier', $identifier)->first()) {
            return $meta;
        }

        throw new MetaGroupNotFoundException('A meta group with the identifier "' . $identifier . '" could not be found.');
    }

    /**
     * Get the default meta group if one exists
     * 
     * @return Coreplex\Meta\Contracts\Group|null
     */
    public function defaultGroup()
    {
        return Meta::defaultGroup();
    }

}