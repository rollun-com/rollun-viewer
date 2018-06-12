<?php

namespace rollun\Crud\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class CrudViewHelper
 * @package rollun\test\Helper
 */
class CrudViewHelper extends AbstractHelper
{


	protected static $_initialized = false;

	/**
	 * @param $url
	 * @param null $title
	 * @param array $options
	 * @return string
	 */
	public function __invoke($url, $title = null, $options = [])
	{
	    $view = $this->getView();
	    $view->jsInit();
	    if (count($options) === 0 )
        {
            $options["foo"] = "bar";
        }
		$options = json_encode($options);
		return "<w-crud-app ref='crud' title='{$title}' url='{$url}'  v-bind:options=$options>\n</w-crud-app>";
	}
}
