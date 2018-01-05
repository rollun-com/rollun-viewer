<?php

namespace rollun\Crud\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class CrudViewHelper
 * @package rollun\test\Helper
 */
class BootstrapHelper extends AbstractHelper
{

	protected static $_initialized = false;

	public function __invoke()
	{
		$view = $this->getView();

		if (!static::$_initialized) {

			$view->headLink()
				->appendStylesheet('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');

            $view->inlineScript()
                ->appendFile("https://code.jquery.com/jquery-2.1.4.min.js");
			$view->inlineScript()
				->appendFile('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');

			static::$_initialized = true;
		}
	}

}
