<?php namespace Coreplex\Meta;

use Coreplex\Meta\Contracts\Container;

class MetaRenderer implements Contracts\Renderer {

    /**
     * Make a new renderer instance
     *
     * @param array $templates An array of element templates
     * @param array $defaultTemplate The default element template to be used if
     *                               a custom one is not present
     * @return void
     */
    public function __construct(array $templates, array $defaultTemplate)
    {
        $this->templates = $templates;
        $this->default = $defaultTemplate;
    }

    /**
     * Returns the rendered string based on the provided meta container or
     * singular item array
     *
     * @param Coreplex\Meta\Contracts\Container|array $renderable
     * @param mixed $key
     * @return string
     */
    public function render($renderable, $key = false)
    {
        // If we are rendering a container, we need to recursively render
        // each item from the container and place it into an array which we
        // can then glue together with new lines and return the final string
        if ($renderable instanceof Container) {
            $renderedItems = [];

            foreach ($renderable->items() as $key => $item) {
                $renderedItems[] = $this->render($item, $key);
            }

            return implode("\n", $renderedItems);
        }

        // Otherwise, just render the single item. The below logic is executed
        // when a single meta item is rendered
        if ( ! is_array($renderable)) {
            return "<meta name=\"$key\" content=\"$renderable\">";
        } else {
            $meta = "<meta name=\"$key\"";

            foreach ($renderable as $itemKey => $itemValue) {
                $meta .= $itemKey . "=\"$itemValue\"";
            }

            return $meta . ">";
        }
    }

}