<?php

namespace Coreplex\Meta;

use Coreplex\Meta\Contracts\Container;
use Coreplex\Meta\Contracts\TemplateRenderer;

class MetaRenderer implements Contracts\Renderer
{
    /**
     * The element templates.
     *
     * @var array
     */
    protected $templates;

    /**
     * The fallback element template.
     *
     * @var array
     */
    protected $default;

    /**
     * Make a new renderer instance
     *
     * @param array            $templates       An array of element templates
     * @param array            $defaultTemplate The default element template to be used if
     *                                          a custom one is not present
     * @param TemplateRenderer $templateRenderer
     */
    public function __construct(array $templates, array $defaultTemplate, TemplateRenderer $templateRenderer)
    {
        $this->templates = $templates;
        $this->default = $defaultTemplate;
        $this->templateRenderer = $templateRenderer;
    }

    /**
     * Returns the rendered string based on the provided meta container or
     * singular item array
     *
     * @param \Coreplex\Meta\Contracts\Container|array $renderable
     * @param mixed                                    $key
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
        return $this->renderWithTemplate($key, $renderable);
    }

    /**
     * Renders an individual meta element with the correct template
     *
     * @param  mixed $key
     * @param  array $data
     * @return string
     */
    protected function renderWithTemplate($key, $data)
    {
        $template = $this->findTemplate($key);

        return $this->templateRenderer->render($key, $data, $template);
    }

    /**
     * Find the correct template for the provided key.
     *
     * @param  mixed $key
     * @return array
     */
    protected function findTemplate($key)
    {
        return ! empty($this->templates[$key]) ? ! empty($this->templates[$key]['use']) ? new $this->templates[$key]['use'] : $this->templates[$key] : $this->default;
    }
}