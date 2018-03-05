<?php
/**
 * Created by PhpStorm.
 * User: USER_T
 * Date: 05.03.2018
 * Time: 13:54
 */

namespace rollun\Crud\Helper\Factory;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use rollun\Crud\Helper\JSInitHelper;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class JSInitHelperFactory implements FactoryInterface
{

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
        $config = $container->get('config');
        $isDebug = $config['debug'];
        if (!isset($isDebug)) {
            $isDebug = true;
        };
        return new JSInitHelper($isDebug);
    }
}