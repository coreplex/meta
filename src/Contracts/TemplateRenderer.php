<?php namespace Coreplex\Meta\Contracts;

interface TemplateRenderer {

    /**
     * Render a meta item using the provided template
     * 
     * @param  mixed $key
     * @param  string|array $data
     * @param  array|Coreplex\Meta\Contracts\Template $template
     * @return string
     */
    public function render($key, $data, $template);

}