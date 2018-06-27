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
    protected $rgridVersion = '0.4';

    public function __invoke($params, $startPage = null)
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
                        composite.placeAt(dom.byId('data_store_viewer'));
                        composite.startup();
                        }
);
                      
            </script>
            <div id='data_store_viewer'></div>
        ";

        return $dataViewerHtml;
    }

    protected function addDojoStyles($view)
    {
        $view->headLink()
            ->appendStylesheet('https://ajax.googleapis.com/ajax/libs/dojo/1.11.1/dojo/resources/dojo.css')
            ->appendStylesheet('https://ajax.googleapis.com/ajax/libs/dojo/1.11.1/dojo/resources/dnd.css')
            ->appendStylesheet("https://cdn.jsdelivr.net/npm/rgrid@$this->rgridVersion/themes/flat/flat.css")
            ->appendStylesheet("https://cdn.jsdelivr.net/npm/rgrid@$this->rgridVersion/lib/css/rgrid.css")
            ->appendStylesheet("https://cdn.jsdelivr.net/npm/rgrid@$this->rgridVersion/lib/css/ConditionEditor.css")
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
                        location: 'https://cdn.jsdelivr.net/npm/rgrid@$this->rgridVersion/lib'
                    },
                    {
                        name: 'config',
                        location: `\${window.origin}/`
                    },
                    {
                        name: 'rgrid-examples',
                        location: 'https://cdn.jsdelivr.net/npm/rgrid@$this->rgridVersion/example'
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
                        location: 'https://cdn.jsdelivr.net/npm/rollun-rql@^0.3'
                    }
                ]
            };
        ");
        $view->inlineScript()->appendFile("https://ajax.googleapis.com/ajax/libs/dojo/1.11.1/dojo/dojo.js");
    }
}