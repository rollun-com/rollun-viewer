<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 28.08.17
 * Time: 18:36
 */

namespace rollun\dataFormat\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use rollun\dataFormat\CsvDataConverter;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class CsvDataConverterAbstractFactory implements AbstractFactoryInterface
{

    const KEY = "DataConverterServices";

    const KEY_DELIMITER = "keyDelimiter";

    const DEFAULT_DELIMITER = ",";

    /**
     * Can the factory create an instance for the service?
     * [
     *      'DataStoreImportExportServices' => [
     *          "csvConverter" => [
     *              "keyDelimiter" => ",",
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
        $delimiter = isset($serviceConfig[static::KEY_DELIMITER])
            ? $serviceConfig[static::KEY_DELIMITER] : static::DEFAULT_DELIMITER;
        return new CsvDataConverter($delimiter);
    }
}
