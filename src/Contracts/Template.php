<?php namespace Coreplex\Meta\Contracts;

interface Template {

    /**
     * Render a given meta item using this template
     * 
     * @param  mixed $key
     * @param  array $data
     * @return string
     */
    public function render($key, $data);

}