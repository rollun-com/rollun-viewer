<?php
/**
 * Created by PhpStorm.
 * User: victorynox
 * Date: 04.09.17
 * Time: 19:30
 */

namespace rollun\DataManager\Helper;

use Zend\View\Helper\AbstractHelper;

class ExportHelper extends AbstractManagerHelper
{

    const RESOURCE_NAME = "dataManager";

    const OPERATION = "export";

    protected function getBlock($dataStoreName, $serializerName)
    {
        $url = $this->getView()->url(self::RESOURCE_NAME,
            ["operation" => self::OPERATION,
                "dataStore" => $dataStoreName,
                "serializer" => $serializerName
            ]
        );
        $html = "<a href='$url'>Download $dataStoreName</a>";
        return $html;
    }
}