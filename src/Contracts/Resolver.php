<?php

namespace Coreplex\Meta\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

interface Resolver
{
    /**
     * Resolve which meta variant should be used and then scope
     * the meta relationship to it.
     *
     * @param Model $model
     * @return MorphOne
     */
    public function resolve(Model $model);
}