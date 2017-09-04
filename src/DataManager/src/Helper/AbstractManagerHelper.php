<?php
/**
 * Created by PhpStorm.
 * User: victorynox
 * Date: 04.09.17
 * Time: 19:36
 */

namespace rollun\DataManager\Helper;


use Zend\View\Helper\AbstractHelper;

abstract class AbstractManagerHelper extends AbstractHelper
{
    /**
     * @param string $dataStoreName
     * @param string $serializerName
     * @return string
     */
    public function __invoke($dataStoreName, $serializerName)
    {
        $data = "<div>";
        $data .= $this->getBlock($dataStoreName, $serializerName);
        $data .= "</div>";
        return $data;
    }

    /**
     * @param string $dataStoreName
     * @param string $serializerName
     * @return string
     */
    abstract protected function getBlock($dataStoreName, $serializerName);
}