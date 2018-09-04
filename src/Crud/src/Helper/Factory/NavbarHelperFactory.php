<?php
/**
 * Created by PhpStorm.
 * User: USER_T
 * Date: 09.08.2018
 * Time: 14:08
 */

namespace rollun\webUI\Helper\Factory;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use rollun\webUI\Helper\NavbarHelper;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class NavbarHelperFactory implements FactoryInterface
{
    const KEY = 'navbar';

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
        $navbarConfig = $container->get('config')[NavbarHelperFactory::KEY];
        if (isset($navbarConfig)) {
            return new NavbarHelper($navbarConfig);
        }
        throw new ServiceNotCreatedException('navbar config is missing');
    }
}