<?php
/**
 * Created by PhpStorm.
 * User: USER_T
 * Date: 20.03.2018
 * Time: 18:48
 */

namespace rollun\Crud\Helper;

use Zend\View\Helper\AbstractHelper;

class RgridHelper extends AbstractHelper
{

    protected $rgridVersion = '0.5.4';
    protected $params;
    protected $startPageNumber;


    public function setParams($params)
    {
        $this->params = $params;
    }

    public function setStartPage($startPageNumber)
    {
        $this->startPageNumber = $startPageNumber;
    }

    public function render()
    {
        $view = $this->getView();
        $this->rgridVersion = $view->dojoLoader()->getVersions()['rgrid'];
        $view->dojoLoader()->render();
        $this->addDojoStyles($view);
        if (isset($this->startPageNumber)) {
            $startPage = $this->startPageNumber;
        }else {
            $startPage = null;
        }
        $targetNodeId = 'r-data-grid-'. mt_rand(1,1000);
        $paramsString = json_encode($this->params);
        $startPageJson = json_encode($startPage);
        $gridScript = "
            require(['rgrid/RCompositeFactory'], function (RCompositeFactory) {
               const composite = new RCompositeFactory(
                    {
                        configString: '$paramsString',
                        startPage: $startPageJson,
                        nodeId: '$targetNodeId'
                    }
               );
               composite.render()
            });
        ";
        $view->inlineScript()->appendScript($gridScript);
        return "<div id='$targetNodeId'></div>";
    }

    protected function addDojoStyles($view)
    {
        $view->headLink()
            ->appendStylesheet('https://ajax.googleapis.com/ajax/libs/dojo/1.11.1/dojo/resources/dnd.css')
            ->appendStylesheet("https://cdn.jsdelivr.net/npm/rgrid@$this->rgridVersion/lib/css/ConditionEditor.css")
            ->appendStylesheet('https://cdn.jsdelivr.net/npm/dojox@1.x/highlight/resources/highlight.css')
            ->appendStylesheet('https://cdn.jsdelivr.net/npm/dojox@1.x/highlight/resources/pygments/colorful.css')
            ->appendStylesheet('https://cdn.jsdelivr.net/npm/dgrid@1.x/css/dgrid.css');
    }
}