<?php

namespace rollun\Crud\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class MainMenuHelper
 * @package rollun\Crud\Helper
 */
class MainMenuHelper extends AbstractHelper
{

	protected static $_items = [];

	/**
	 * @param null $items
	 * @return $this
	 */
	public function __invoke($items = null)
	{
		if (is_array($items))
			static::$_items = $items;
		return $this;
	}

	/**
	 * @param $title
	 * @param string $link
	 * @return $this
	 */
	public function addItem($title, $link = '#')
	{
		static::$_items[] = [
			'title' => $title,
			'link' => $link
		];
		return $this;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return "<ul class='nav navbar-nav navbar-left'>" . implode('', array_map(function ($item) {
				return "<li><a href='{$item['link']}'>{$item['title']}</a></li>";
			}, static::$_items)) . "</ul>";
	}
}
