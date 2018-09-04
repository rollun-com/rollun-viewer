<?php
/**
 * Created by PhpStorm.
 * User: USER_T
 * Date: 08.08.2018
 * Time: 21:24
 */

namespace rollun\Crud\Helper;


use Zend\View\Helper\AbstractHelper;

class FitScreenHeightHelper extends AbstractHelper
{
    public function __invoke()
    {
        return "
        <script>
	        require(['dojo/dom-style', 'dojo/dom', 'dojo/_base/window'], (domStyle, dom, win) => {
		    const bodyHeight = domStyle.get(win.body(), 'height'),
			    desiredContainerHeight = bodyHeight - domStyle.get(dom.byId('navbar'), 'height');
		    domStyle.set(dom.byId('r-content-column'), 'height', desiredContainerHeight + \"px\");
	        });
        </script>";
    }
}