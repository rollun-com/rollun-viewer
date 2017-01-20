<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18.01.17
 * Time: 18:46
 */

namespace rollun\viewer\Viewer;

use Zend\Expressive\Template\TemplateRendererInterface;

class DataStoreViewer implements ViewerInterface
{
    /**
     * @var string
     */
    protected $resourceName;

    /** @var  TemplateRendererInterface */
    protected $templateRenderrer;

    public function __construct($resourceName, TemplateRendererInterface $templateRenderer)
    {
        $this->resourceName = $resourceName;
        $this->templateRenderrer = $templateRenderer;
    }

    /**
     * Return Widget with
     * @return string
     */
    public function getWidget()
    {
        // TODO: Implement getWidget() method.
    }

    /**
     * Return Page
     * @return string
     */
    public function getPage()
    {
        return $this->templateRenderrer->render('viewer::data-store-body', [
            'url' => '/api/rest/' . $this->resourceName,
            'title' => $this->resourceName,
        ]);
    }
}
