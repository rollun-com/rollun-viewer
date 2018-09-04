<?php
/**
 * Created by PhpStorm.
 * User: USER_T
 * Date: 06.08.2018
 * Time: 16:12
 */

namespace rollun\Crud\Helper;

use Zend\View\Helper\AbstractHelper;

class LeftSideBarHelper extends AbstractHelper
{
    const KEY_PARAMS = 'lsbParams';
    /**
     * @param $lsbConfig {array}
     */
    public function __invoke($lsbConfig)
    {
        $view = $this->getView();
        $leftSideBarConfigJson = json_encode($lsbConfig);
        $script =
            "require(['dojo/dom','rgrid/NavPanes'], (dom,NavPanes) => {
                const lsbConfig = JSON.parse('$leftSideBarConfigJson'),
                navPanes = new NavPanes({layoutConfig: lsbConfig});
	            navPanes.placeAt(dom.byId('r-nav-list'));
	        });
	    ";
        $view->headScript()->appendScript($script);

    }
}