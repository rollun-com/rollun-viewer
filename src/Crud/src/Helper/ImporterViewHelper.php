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
     * @param bool $noIdMode
     * @param string $popupButtonLabel
     * @param string $popupTitle
     * @param string $placeholderText
     * @return string
     */
    function __invoke($noIdMode = false,
                      $popupButtonLabel = "Добавить записи",
                      $popupTitle = "Добавление записей",
                      $placeholderText = "Введите новые данные")
    {
        $view = $this->getView();
        $view->inlineScript()->appendScript("$(function () {importerApp = RollunJs.app({el: '#crud_importer'});});");
        return "<div id=\"crud_importer\">
                    <w-crud-import label='{$popupButtonLabel}' noid='{$noIdMode}' popuptitle='{$popupTitle}' placeholder='{$placeholderText}'></w-crud-import>
                </div>";
    }
}