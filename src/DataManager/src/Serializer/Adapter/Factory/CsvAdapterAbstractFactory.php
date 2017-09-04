<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 28.08.17
 * Time: 18:36
 */

namespace rollun\DataManager\Serializer\Adapter\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use rollun\DataManager\Serializer\Adapter\CsvAdapter;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class CsvAdapterAbstractFactory implements AbstractFactoryInterface
{

    const KEY = "CsvAdapterAbstractServices";

    const KEY_DELIMITER = "keyDelimiter";
    const KEY_QUOTATION = "keyQuotation";
    const KEY_NEW_LINE_SEPARATOR = "keyNewLineSeparator";

    const DEFAULT_DELIMITER = ",";
    const DEFAULT_QUOTATION = "\"";
    const DEFAULT_NEW_LINE_SEPARATOR = "\n";

    /**
     * Can the factory create an instance for the service?
     * [
     *      'CsvAdapterAbstractServices' => [
     *          "csvAdapter" => [
     *              "keyDelimiter" => ",",
     *              "keyQuotation" => "\"",
     *              "keyNewLineSeparator" => "\n",
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
        $quotation = isset($serviceConfig[static::KEY_QUOTATION])
            ? $serviceConfig[static::KEY_QUOTATION] : static::DEFAULT_QUOTATION;
        $newLineSeparator = isset($serviceConfig[static::KEY_NEW_LINE_SEPARATOR])
            ? $serviceConfig[static::KEY_NEW_LINE_SEPARATOR] : static::DEFAULT_NEW_LINE_SEPARATOR;
        return new CsvAdapter($delimiter, $quotation, $newLineSeparator);
    }
}
