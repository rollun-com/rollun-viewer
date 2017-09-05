<?php
/**
 * Created by PhpStorm.
 * User: victorynox
 * Date: 04.09.17
 * Time: 18:38
 */

namespace rollun\DataManager\Middleware\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ExporterFileRenderAbstractFactory implements AbstractFactoryInterface
{
    const KEY = "keyDataManagerServices";
    const KEY_SERIALIZER = "keySerializer";
    const KEY_CLASS = "class";

    /**
     * Create an object
     *  [
     *      "class" => ExporterMiddleware::class,
     *      "keySerializer" => "csvAdapter",
     *  ]
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

        if (!isset($serviceConfig[static::KEY_SERIALIZER])) {
            throw new ServiceNotFoundException("Not set serializer.");
        }
        if (!$container->has($serviceConfig[static::KEY_SERIALIZER])) {
            throw new ServiceNotFoundException("Not found serializer " . $serviceConfig[static::KEY_SERIALIZER]);
        }
        $serializer = $container->get($serviceConfig[static::KEY_SERIALIZER]);
        $class = $serviceConfig[static::KEY_CLASS];
        return new $class($serializer);
    }

    /**
     * Can the factory create an instance for the service?
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $config = $container->get("config");
        return isset($config[static::KEY][$requestedName]);
    }
}