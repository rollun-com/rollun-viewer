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
        $inputSeparator = (isset($options["inputSeparator"]) ? $options["inputSeparator"] : "\t");
        $popupButtonLabel = (isset($options["popupButtonLabel"]) ? $options["popupButtonLabel"] : "Add items");
        $popupTitle = (isset($options["popupTitle"]) ? $options["popupTitle"] : "Add new items");
        $placeholderText = (isset($options["placeholderText"]) ? $options["placeholderText"] : "Enter new items here");
        $formName = (isset($options["formName"]) ? $options["formName"] : 'file2ds');
        $uploadUrl = (isset($options["uploadUrl"]) ? $options["uploadUrl"] : '');
        $uploadAccept = (isset($options["uploadAccept"]) ? json_encode($options["uploadAccept"]) : '.csv');
        $uploadHeaders = (isset($options["uploadHeaders"]) ? json_encode($options["uploadHeaders"]) : '');
        $validatorName = (isset($options["validatorName"]) ? $options["validatorName"] : "");

        $view = $this->getView();
        $view->bootstrap();
        $view->jsInit();

        return "<div id=\"crud_importer\">
                    <w-crud-import
                        importfields='$importFields' 
                        label='$popupButtonLabel' 
                        noid='$noIdMode' 
                        inputSeparator='$inputSeparator'
                        placeholder='$placeholderText'
                        popuptitle='$popupTitle' 
                        formname='$formName'
                        uploadurl='$uploadUrl'
                        uploadaccept='$uploadAccept'
                        uploadheaders='$uploadHeaders'
                        validatorname='$validatorName'>
                    </w-crud-import>
                </div>";
    }
}
