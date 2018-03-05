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
	public function __invoke($url, $title = null, array $options = ["foo" => "bar"])
	{
	    $view = $this->getView();
	    $view->jsInit();
		$options = json_encode($options);
		return "<w-crud-app ref='crud' title='{$title}' url='{$url}'  v-bind:options=$options>\n</w-crud-app>";
	}
}
