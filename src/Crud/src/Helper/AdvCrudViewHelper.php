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
        $crud_uid = isset($options['crud_uid']) ? $options['crud_uid'] : 'crud_' . rand(1, 10000);
        $options = json_encode($options);
        $this->assets($crud_uid);
        return "<div id='{$crud_uid}'>\n<w-crud-app-plus ref='crud' title='{$title}' url='{$url}'  v-bind:options=$options>\n</w-crud-app-plus>\n</div>";
    }

    public function assets($crud_uid)
    {
        $view = $this->getView();
        if (!static::$_initialized) {
            $view->bootstrap();
            $view->inlineScript()->appendScript("dojoConfig = {async: true,isDebug: true,packages: [{name: 'dstore', location: '/assets/js/dojo-dstore/'}, {name: 'rql',location: '/assets/js/rollun-rql/'}]};");
            $view->inlineScript()
                ->appendFile("/assets/js/dojo/dojo.js")
                ->appendFile("/assets/js/rollun-js/index.js");
            static::$_initialized = true;
        }
        $view->inlineScript()->appendScript("$(function () {require(['dojo/_base/declare','dstore/Rest','dstore/extensions/RqlQuery','rql/query'], function (declare, Rest, RqlQuery, query) {window.RqlStore = declare([Rest, RqlQuery]);Query = query.Query;app = RollunJs.app({el: '#{$crud_uid}'});});});");
    }
}