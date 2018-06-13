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
    public function __invoke($url)
    {
        $view = $this->getView();
        $view->bootstrap();
        $this->addDojo($view);
        $this->addDojoStyles($view);
        $dataViewerHtml = "
            <script>
                require([
                    \"dojo/dom\",
                    \"dojo/dom-class\",
                    \"dojo/_base/window\",
                    \"Rscript/DataStoreViewer/widget/AdvDatastoreViewer\",
                    'dstore/Memory',
                ], function (dom,
                             domClass,
                             win,
                             AdvDatastoreViewer,
                             Memory) {
                    
                    domClass.add(win.body(), \"flat\");
                    var myFilterStore = new Memory();
                    var dataStoreViewer = new AdvDatastoreViewer({url: '$url', gridConfig: {filterStore: myFilterStore}});
                    dataStoreViewer.placeAt(dom.byId('data_store_viewer')).startup();
                })
            </script>
            <div id=\"data_store_viewer\" ></div>
        ";

        return $dataViewerHtml;
    }

    protected function addDojoStyles($view)
    {
        $view->headLink()
            ->appendStylesheet('https://ajax.googleapis.com/ajax/libs/dojo/1.11.2/dojo/resources/dojo.css')
            ->appendStylesheet('https://cdn.jsdelivr.net/npm/rgrid@0.0.x/themes/flat/flat.css')
            ->appendStylesheet('https://cdn.jsdelivr.net/npm/dojox@1.x/highlight/resources/highlight.css')
            ->appendStylesheet('https://cdn.jsdelivr.net/npm/dojox@1.x/highlight/resources/pygments/colorful.css')
            ->appendStylesheet('https://cdn.jsdelivr.net/npm/dgrid@1.x/css/dgrid.css')
            ->appendStylesheet('https://cdn.jsdelivr.net/npm/dojox@1.x/grid/enhanced/resources/EnhancedGrid_rtl.css')
            ->appendStylesheet('https://cdn.jsdelivr.net/npm/rgrid@0.0.x/lib/FilterEditor/resources/css/FilterEditor.css')
            ->appendStylesheet('https://cdn.jsdelivr.net/npm/rgrid@0.0.x/lib/DataStoreViewer/resource/bootstrap/css/bootstrap.css')
            ->appendStylesheet('https://cdn.jsdelivr.net/npm/rgrid@0.0.x/lib/DataStoreViewer/resource/bootstrap/css/bootstrap-theme.css')
            ->appendStylesheet('https://ajax.googleapis.com/ajax/libs/dojo/1.11.2/dojo/resources/dnd.css')
            ->appendStylesheet('https://cdn.jsdelivr.net/npm/rgrid@0.0.x/lib/DataStoreViewer/resource/bootstrap/css/dashboard.css');
    }

    protected function addDojo($view)
    {
        $view->inlineScript()->appendScript("
            var dojoConfig = {
                async: true,
                isDebug: true,
                packages: [
                    {
                        name: \"Rscript\",
                        location: 'https://cdn.jsdelivr.net/npm/rgrid@0.0.x/lib'
                    },
                    {
                        name: \"dstore\",
                        location: 'https://cdn.jsdelivr.net/npm/dojo-dstore@1.x'
                    }, 
                    {
                        name: \"dgrid\",
                        location: 'https://cdn.jsdelivr.net/npm/dgrid@1.x'
                    }, 
                    {
                        name: \"dijit\",
                        location: 'https://cdn.jsdelivr.net/npm/dijit@1.x'
                    }, 
                    {
                        name: \"dojox\",
                        location: 'https://cdn.jsdelivr.net/npm/dojox@1.x'
                    }, 
                    {
                        name: \"promised-io\",
                        location: 'https://cdn.jsdelivr.net/npm/promised-io@0.x'
                    }, 
                    {
                        name: \"rql\",
                        location: 'https://cdn.jsdelivr.net/npm/rollun-rql@0.x'
                    }
                ]
            };
        ");
        $view->inlineScript()->appendFile("https://ajax.googleapis.com/ajax/libs/dojo/1.11.2/dojo/dojo.js");
    }
}
