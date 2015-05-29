<?php namespace Coreplex\Meta\Eloquent;

use Coreplex\Meta\Contracts\Repository as Contract;

class Repository implements Contract {

    /**
     * Find a meta group by it's identifier
     * 
     * @param  mixed $identifier
     * @return Coreplex\Meta\Contracts\Group
     */
    public function find($identifier);

    /**
     * Get the default meta group
     * 
     * @return Coreplex\Meta\Contracts\Group
     */
    public function default();

}