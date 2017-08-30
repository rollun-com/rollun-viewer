<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 28.08.17
 * Time: 18:33
 */

namespace rollun\dataFormat\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use rollun\dataFormat\DataStoreImportExport;
use RuntimeException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class DataStoreImportExportAbstractFactory implements AbstractFactoryInterface
{
    const KEY = "DataStoreImportExportServices";

    const KEY_DATASTORE = "keyDataStoreService";

    const KEY_DATA_CONVERTER = "keyDataConverterService";

    /**
     * Can the factory create an instance for the service?
     * [
     *      'DataStoreImportExportServices' => [
     *          "userDataStoreImportExport" => [
     *              "keyDataStoreService" => "userDataStore",
     *              "keyDataConverterService" => "csvConverter",
     *          ]
     *      ]
     * ]
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $config = $container->get("config");
        return (isset($config[static::KEY][$requestedName]));
    }

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        if (empty($options)) {
            $config = $container->get("config");
            $serviceConfig = $config[static::KEY][$requestedName];
        } else {
            $serviceConfig = $options;
        }
        if (!$container->has($serviceConfig[static::KEY_DATASTORE])) {
            throw new ServiceNotFoundException("Service " . $serviceConfig[static::KEY_DATASTORE] . " not found.");
        }
        $dataStore = $container->get($serviceConfig[static::KEY_DATASTORE]);
        if (!$container->has($serviceConfig[static::KEY_DATA_CONVERTER])) {
            throw new ServiceNotFoundException("Service " . $serviceConfig[static::KEY_DATA_CONVERTER] . " not found.");
        }
        $dataConverter = $container->get($serviceConfig[static::KEY_DATA_CONVERTER]);
        return new DataStoreImportExport($dataStore, $dataConverter);
    }
}
