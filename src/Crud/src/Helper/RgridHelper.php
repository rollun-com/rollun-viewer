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

    protected $rgridVersion = '0.5.0';
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
        $paramsString = json_encode($this->params);
        $gridScript = "
            require(
                [
                    'dojo/dom',
                    'dojo/dom-class',
                    'dojo/_base/window',
                    'rgrid/Composite/RComposite',
                    'rgrid/Composite/WidgetFactory',
                    'rgrid/Composite/TemplateWidgetPlacer',
                    'rgrid/prefabs/ConditionsInMenu',
                    'rgrid/prefabs/Pagination',
                    'rgrid/prefabs/Rgrid',
                    'rgrid/prefabs/Search',
                    'dstore/Memory',
                    'dojo/text!rgrid-examples/testTemplate.html',
                    'config/RgridConfig'
                ], function (
                    dom,
                    domClass,
                    win,
                    RComposite,
                    WidgetFactory,
                    WidgetPlacer,
                    ConditionsInMenu,
                    PaginationPrefab,
                    RgridPrefab,
                    SearchPrefab,
                    Memory,
                    template,
                    config                   
                    ) {
                    domClass.add(win.body(), 'flat');
                    const factory = new WidgetFactory(),
                    placer = new WidgetPlacer(),
                    parsedParams = JSON.parse('$paramsString');
                    config.push(...parsedParams);
                    const configStore = new Memory({data: config}),
                    composite = new RComposite({
                        widgetFactory: factory, 
                        widgetPlacer: placer, 
                        configStore: configStore,
                        templateString: template
                    }),
                    prefabs = [
                    	new RgridPrefab(),
                    	new ConditionsInMenu(),
                    	new PaginationPrefab({startingPage: '$startPage'}),
                    	new SearchPrefab()
                    	];
                    composite.addComponents(prefabs);
                    composite.placeAt(dom.byId('r-data-grid'));
                    composite.startup();
                    }
            );       
        ";
        $view->inlineScript()->appendScript($gridScript);
        return "<div id='r-data-grid'></div>";
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