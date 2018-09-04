<?php
/**
 * Created by PhpStorm.
 * User: USER_T
 * Date: 09.08.2018
 * Time: 13:58
 */

namespace rollun\Crud\Helper;


use Zend\View\Helper\AbstractHelper;

class NavbarHelper extends AbstractHelper
{
    protected $navbarMenuLayoutConfig;

    public function __construct($navbarMenuLayoutConfig)
    {
        $this->navbarMenuLayoutConfig = $navbarMenuLayoutConfig;
    }

    public function __invoke()
    {
        $view = $this->getView();
        $navbarConfigJson = json_encode($this->navbarMenuLayoutConfig);
        $script =
            "require(['dojo/dom', 'rgrid/NavMenu'], (dom,NavMenu) => {
                const navbarConfig = JSON.parse('$navbarConfigJson'),
                navMenu = new NavMenu({menuConfig: navbarConfig});
                navMenu.placeAt(dom.byId('r-nav-dropdowns'));
	        });
	    ";
        $view->headScript()->appendScript($script);
    }
}