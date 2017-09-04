<?php
/**
 * Created by PhpStorm.
 * User: victorynox
 * Date: 04.09.17
 * Time: 19:31
 */

namespace rollun\DataManager\Helper;


class ImportHelper extends AbstractManagerHelper
{

    const RESOURCE_NAME = "dataManager";

    const OPERATION = "export";

    /**
     * @param string $dataStoreName
     * @param string $serializerName
     * @return string
     */
    protected function getBlock($dataStoreName, $serializerName)
    {
        $url = $this->getView()->url(self::RESOURCE_NAME,
            ["operation" => self::OPERATION,
                "dataStore" => $dataStoreName,
                "serializer" => $serializerName
            ]
        );
        $html =
            "<div class=\"row\">" .
                "<div class=\"col-md-offset-4 col-md-4\">" .
                    "<h2>Загрузить таблицу $dataStoreName</h2>" .
                    "<form enctype=\"multipart/form-data\" action=\"$url\" method=\"POST\">" .
                        "Отправить этот файл: <input name=\"userfile\" type=\"file\"/>" .
                        "<input type=\"submit\" value=\"Загрузить файл\"/>" .
                    "</form>" .
                "</div>" .
            "</div>"
        ;
        return $html;
    }
}