<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 04.09.17
 * Time: 16:42
 */

namespace rollun\DataManager\Interfaces;

use Zend\Serializer\Adapter\AdapterInterface;

interface DataSerializerInterfaces extends AdapterInterface
{
    /**
     * @return string
     */
    public function getSerializationType();
}
