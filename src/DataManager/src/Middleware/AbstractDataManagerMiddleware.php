<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 04.09.17
 * Time: 16:01
 */

namespace rollun\DataManager\Middleware;

use Interop\Http\ServerMiddleware\MiddlewareInterface;
use rollun\DataManager\Interfaces\DataSerializerInterfaces;
use rollun\datastore\DataStore\Interfaces\DataStoresInterface;
use Zend\Serializer\Adapter\AdapterInterface;
use Zend\Serializer\Serializer;

abstract class AbstractDataManagerMiddleware implements MiddlewareInterface
{
    /** @var  DataStoresInterface */
    protected $dataStore;

    /** @var  DataSerializerInterfaces */
    protected $serializer;

    /**
     * DataStoreManager constructor.
     * @param DataStoresInterface $dataStore
     * @param DataSerializerInterfaces $serializer
     */
    protected function __construct(DataStoresInterface $dataStore, DataSerializerInterfaces $serializer)
    {
        $this->dataStore = $dataStore;
        $this->serializer = $serializer;
    }
}
