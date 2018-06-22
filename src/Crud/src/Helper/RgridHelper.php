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
    public function __invoke($params)
    {
        $view = $this->getView();
        $view->bootstrap();
        $this->addDojo($view);
        $this->addDojoStyles($view);
        $paramsString = json_encode($params);
        $dataViewerHtml = "
            <script>
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
                        'dojo/text!rgrid/testTemplate.html'
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
                        template                   
                        ) {
                        domClass.add(win.body(), 'flat');
                        const factory = new WidgetFactory(),
                        placer = new WidgetPlacer(),
                        configStore = new Memory({data: JSON.parse('$paramsString')}),
                        composite = new RComposite({
                            widgetFactory: factory, 
                            widgetPlacer: placer, 
                            configStore: configStore,
                            templateString: template
                        }),
                        prefabs = [
                        	new RgridPrefab(),
                        	new ConditionsInMenu(),
                        	new PaginationPrefab(),
                        	new SearchPrefab()
                        	];
                        composite.addComponents(prefabs);
                        composite.placeAt(dom.byId('data_store_viewer'));
                        composite.startup();
                        }
);
                      
            </script>
            <div id=\"data_store_viewer\"></div>
        ";

        return $dataViewerHtml;
    }

    protected function addDojoStyles($view)
    {
        $view->headLink()
            ->appendStylesheet('https://ajax.googleapis.com/ajax/libs/dojo/1.11.1/dojo/resources/dojo.css')
            ->appendStylesheet('https://ajax.googleapis.com/ajax/libs/dojo/1.11.1/dojo/resources/dnd.css')
            ->appendStylesheet('https://cdn.jsdelivr.net/npm/rgrid@0.x/themes/flat/flat.css')
            ->appendStylesheet('https://cdn.jsdelivr.net/npm/rgrid@0.x/lib/css/rgrid.css')
            ->appendStylesheet('https://cdn.jsdelivr.net/npm/rgrid@0.x/lib/css/ConditionEditor.css')
            ->appendStylesheet('https://cdn.jsdelivr.net/npm/dojox@1.x/highlight/resources/highlight.css')
            ->appendStylesheet('https://cdn.jsdelivr.net/npm/dojox@1.x/highlight/resources/pygments/colorful.css')
            ->appendStylesheet('https://cdn.jsdelivr.net/npm/dgrid@1.x/css/dgrid.css');
    }

    protected function addDojo($view)
    {
        $view->inlineScript()->appendScript("
            var dojoConfig = {
                async: true,
                isDebug: true,
                packages: [
                    {
                        name: 'rgrid',
                        location: 'https://cdn.jsdelivr.net/npm/rgrid@0.x/lib'
                    },
                    {
                        name: 'dstore',
                        location: 'https://cdn.jsdelivr.net/npm/dojo-dstore@1.x'
                    }, 
                    {
                        name: 'dgrid',
                        location: 'https://cdn.jsdelivr.net/npm/dgrid@1.x'
                    }, 
                    {
                        name: 'dijit',
                        location: 'https://cdn.jsdelivr.net/npm/dijit@1.x'
                    }, 
                    {
                        name: 'dojox',
                        location: 'https://cdn.jsdelivr.net/npm/dojox@1.x'
                    }, 
                    {
                        name: 'promised-io',
                        location: 'https://cdn.jsdelivr.net/npm/promised-io@0.x'
                    }, 
                    {
                        name: 'rql',
                        location: 'https://cdn.jsdelivr.net/npm/rollun-rql@0.x'
                    }
                ]
            };
        ");
        $view->inlineScript()->appendFile("https://ajax.googleapis.com/ajax/libs/dojo/1.11.1/dojo/dojo.js");
    }
}