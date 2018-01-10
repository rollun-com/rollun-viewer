<?php
/**
 * Created by PhpStorm.
 * User: USER_T
 * Date: 29.12.2017
 * Time: 15:32
 */

namespace rollun\Crud\Helper;

use Zend\View\Helper\AbstractHelper;

class ImporterViewHelper extends AbstractHelper
{
    /**
     * @param array $options
     * @return string
     */
    function __invoke($options)
    {
        $importFields = (isset($options["importFields"]) ? json_encode($options["importFields"]) : json_encode(null));
        $noIdMode = (isset($options["noId"]) ? json_encode($options["noId"]) : json_encode(false));
        $inputSeparator = (isset($options["inputSeparator"]) ? $options["inputSeparator"] : "   ");
        $popupButtonLabel = (isset($options["popupButtonLabel"]) ? $options["popupButtonLabel"] : "Add items");
        $popupTitle = (isset($options["popupTitle"]) ? $options["popupTitle"] : "Add new items");
        $placeholderText = (isset($options["placeholderText"]) ? $options["placeholderText"] : "Enter new items here");

        $view = $this->getView();
        $view->bootstrap();
        $view->inlineScript()->appendScript("$(function () {importerApp = RollunJs.app({el: '#crud_importer'});});");

        return "<div id=\"crud_importer\">
                    <w-crud-import
                        importfields='{$importFields}' 
                        label='{$popupButtonLabel}' 
                        noid='{$noIdMode}' 
                        inputSeparator='{$inputSeparator}'
                        popuptitle='{$popupTitle}' 
                        placeholder='{$placeholderText}'></w-crud-import>
                </div>";
    }
}