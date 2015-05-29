<?php namespace Coreplex\Meta;

class TemplateRenderer implements Contracts\TemplateRenderer {

    /**
     * The array of meta templates
     * 
     * @var array
     */
    protected $templates;

    /**
     * Create a new TemplateRenderer instance.
     * 
     * @param array $templates
     */
    public function __construct(array &$templates)
    {
        $this->templates = $templates;
    }

    /**
     * Render a meta item using the provided template.
     * 
     * @param  mixed $key
     * @param  string|array $data
     * @param  array $template
     * @return string
     */
    public function render($key, $data, $template)
    {
        if (! empty($template['extends']) && $template['extends']) {
            $template = $this->extend($template, $template['extends']);
        }

        $element = "<{$template['element']}";

        if (isset($template['empty']) && ! $template['empty']) {
            // If the element is one which contains inner HTML
            if ( ! is_array($data)) {
                // And it is a single item
                $element .= ">";
                $element .= isset($template['content']) ? $this->replaceKeysInText(['content' => $data], $template['content']) : $data;
            } else {
                // Or it is an array of 'key' => 'value'
                if (isset($template['attributes'])) {
                    foreach ($template['attributes'] as $attribute) {
                        if (isset($data['attribute'])) {
                            $element .= ' ' . $attribute . "=\"{$data['attribute']}\"";
                        }
                    }
                }
                $element .= ">";

                $element .= isset($template['content']) ? $this->replaceKeysInText($data, $template['content']) : $data['content'];
            }

            $element .= "</{$template['element']}>";
        } else {
            // If the element is on that doesn't contain inner HTML
            if (isset($template['keyAttribute']) && $template['keyAttribute']) {
                $element .= " {$template['keyAttribute']}=\"$key\"";
            }

            if ( ! is_array($data)) {
                $valueAttribute = 'content';
                // And it is a single item
                if (isset($template['valueAttribute']) && $template['valueAttribute']) {
                    $valueAttribute = $template['valueAttribute'];
                }

                if ( ! isset($template['valueAttribute']) || $template['valueAttribute'] !== false) {
                    $element .= " $valueAttribute=\"$data\"";
                }
            } else {
                // Or it is an array of 'key' => 'value'

                foreach ($data as $itemKey => $itemValue) {
                    $element .= ' ' . $itemKey . "=\"$itemValue\"";
                }
            }

            $element .= ">";
        }

        return $element;
    }

    /**
     * Extend the initial template with the template found using the extends
     * key.
     * 
     * @param  array $template
     * @param  string $extends
     * @return array
     */
    protected function extend($template, $extends)
    {
        return array_merge($this->templates[$extends], $template);
    }

    /**
     * Replace the items in the array by their key prefixed with a colon (:).
     * 
     * @param  array $replace
     * @param  string $searchText
     * @return string
     */
    protected function replaceKeysInText($replace, $searchText)
    {
        foreach ($replace as $key => $content) {
            $searchText = str_replace(':' . $key, $content, $searchText);
        }

        return $searchText;
    }

}