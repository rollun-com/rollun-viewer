<?php
/**
 * Created by PhpStorm.
 * User: USER_T
 * Date: 05.03.2018
 * Time: 13:32
 */

namespace rollun\Crud\Helper;

use Zend\View\Helper\AbstractHelper;

class JSInitHelper extends AbstractHelper
{
    protected static $_initialized = false;
    protected $isDebug;

    /**
     * JSInitHelper constructor.
     * @param bool $isDebug
     */
    public function __construct($isDebug)
    {
        $this->isDebug = $isDebug;
    }


    public function __invoke()
    {
        $view = $this->getView();
        if (!static::$_initialized) {
            $stringIsDebug = 'true';
            if ($this->isDebug = false) {
                $stringIsDebug = 'false';
            }
            $view->bootstrap();

            $view->inlineScript()
                ->appendScript("
                dojoConfig = {
                    async: true,
                    isDebug: $stringIsDebug,
                    packages: [
                        {
                            name: 'dstore', 
                            location: 'https://cdn.jsdelivr.net/npm/dojo-dstore@1.x/'
                        },
                        {
                            name: 'rql',
                            location: 'https://cdn.jsdelivr.net/npm/rollun-rql@0.x/'
                        }
                    ]
                };");

            $view->inlineScript()
                ->appendFile("https://ajax.googleapis.com/ajax/libs/dojo/1.11.1/dojo/dojo.js")
                ->appendFile("https://cdn.jsdelivr.net/npm/rollun-js@latest/index.js");
            $view->inlineScript()
                ->appendScript("
                $(function () {
                    require(['dojo/_base/declare','dstore/Rest','dstore/extensions/RqlQuery','rql/query'], function (declare, Rest, RqlQuery, query) {
                         window.RqlStore = declare([Rest, RqlQuery]);
                         Query = query.Query;
                         app = RollunJs.app({
                             el: '#vue-mount'
                         });
                    });
                });");
            static::$_initialized = true;
        }
    }
}
