<?php
/**
 * Created by PhpStorm.
 * User: USER_T
 * Date: 10.01.2018
 * Time: 11:18
 */

namespace rollun\Crud\Helper;


use Zend\View\Helper\AbstractHelper;

class AdvCrudViewHelper extends AbstractHelper
{
    protected static $_initialized = false;

    /**
     * @param $url
     * @param null $title
     * @param array $options
     * @return string
     */
    public function __invoke($url, $title = null, array $options = ["widget_type" => []])
    {
        $view = $this->getView();
        $view->jsInit();
        $options = json_encode($options);
        return "<w-crud-app-plus ref='crud' title='{$title}' url='{$url}'  v-bind:options=$options>\n</w-crud-app-plus>";
    }
}