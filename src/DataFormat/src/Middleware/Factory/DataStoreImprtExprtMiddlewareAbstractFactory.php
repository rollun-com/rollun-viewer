<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.08.17
 * Time: 11:09
 */

namespace rollun\dataFormat\Middleware\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use rollun\dataFormat\Middleware\AbstractDataStoreImprtExprtMiddleware;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class DataStoreImprtExprtMiddlewareAbstractFactory implements AbstractFactoryInterface
{

    const KEY = 'DataStoreImprtExprtMiddleware';

    const KEY_DATASTORE_IMPRT_EXPRT_SERVICE = "DataStoreImprtExprt";
    const KEY_CLASS = "class";
    const DEFAULT_CLASS = AbstractDataStoreImprtExprtMiddleware::class;
    /**
     * Can the factory create an instance for the service?
     * [
     *      "CsvUserDSImprtExprtMiddleware" => [
     *          "DataStoreImprtExprt" => "CsvUserDSImprtExprt"
     *          "class" => DataStoreExporter::class
     *      ]
     * ]
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $config = $container->get("config");
        return isset($config[static::KEY][$requestedName]);
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
        $class = $serviceConfig[static::KEY_CLASS];
        if (!is_a($class, static::DEFAULT_CLASS, true)) {
            throw new ServiceNotCreatedException("Class in not instanceof " . static::DEFAULT_CLASS);
        }
        if (!$container->has($serviceConfig[static::KEY_DATASTORE_IMPRT_EXPRT_SERVICE])) {
            throw new ServiceNotCreatedException("Service " .
                $serviceConfig[static::KEY_DATASTORE_IMPRT_EXPRT_SERVICE]." not exist.");
        }
        $dataStoreImprtExprt = $container->get($serviceConfig[static::KEY_DATASTORE_IMPRT_EXPRT_SERVICE]);
        return new $class($dataStoreImprtExprt);
    }
}
