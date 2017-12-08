<?php
/**
 * Created by PhpStorm.
 * User: victorsecuring
 * Date: 08.12.17
 * Time: 4:47 PM
 */

namespace rollun\Crud\Helper\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use rollun\Crud\Helper\RootPageHelper;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Uri\Uri;

/**
 * Class RootPageHelperFactory
 * @package rollun\Crud\Helper\Factory
 */
class RootPageHelperFactory implements FactoryInterface
{
    const KEY = RootPageHelperFactory::class;

    const KEY_URI_STRING = "keyUriString";

    /**
     * Create an object
     * RootPageHelperFactory::KEY => [
     *      RootPageHelperFactory::KEY_URI_STRING => "domain.com"
     * ]
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
        try {
            $config = $container->get('config');
        } catch (NotFoundExceptionInterface $e) {
            throw new ServiceNotCreatedException("Not found config", $e->getCode(), $e);
        } catch (ContainerExceptionInterface $e) {
            throw new ServiceNotCreatedException("Container exception.", $e->getCode(), $e);
        }
        if(!isset($config[static::KEY][static::KEY_URI_STRING])) {
            throw new ServiceNotCreatedException("Url string not set.");
        }
        $uriString = $config[static::KEY][static::KEY_URI_STRING];
        $uri = new Uri($uriString);
        if(!$uri->isValid()) {
            throw new ServiceNotCreatedException("Url string - `$uriString` not valid.");
        }
        return new RootPageHelper($uri);
    }
}