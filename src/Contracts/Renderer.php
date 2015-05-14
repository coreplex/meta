<?php namespace Coreplex\Meta\Contracts;

interface Renderer {

    /**
     * Returns the rendered string based on the provided meta container or
     * singular item array
     *
     * @param Coreplex\Meta\Contracts\Container|array $renderable
     * @param mixed $key
     * @return string
     */
    public function render($renderable, $key = false);

}