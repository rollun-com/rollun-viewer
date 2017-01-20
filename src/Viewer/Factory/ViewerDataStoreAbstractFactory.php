<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18.01.17
 * Time: 18:10
 */

namespace rollun\viewer\Viewer\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use rollun\datastore\DataStore\Interfaces\DataStoresInterface;
use rollun\viewer\Pipe\Factory\ViewerDirectFactory;
use rollun\viewer\Viewer\DataStoreViewer;
use rollun\viewer\Viewer\ViewerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class ViewerDataStoreAbstractFactory implements AbstractFactoryInterface
{

    /** @var  string */

    protected $dataStoreName;
    /**
     * Can the factory create an instance for the service?
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $match = [];
        if (preg_match('/^' . ViewerDirectFactory::SERVICE_PREFIX . '([\w-]+)/', $requestedName, $match)) {
            $this->dataStoreName = $match[1];
            $service = $container->has($this->dataStoreName) ? $container->get($this->dataStoreName) : null;
            return ($service != null && $service instanceof DataStoresInterface);
        }
        return false;
    }

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return ViewerInterface
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config')['ViewerDataStore'];
        if (isset($config[$requestedName])) {
            //TODO add create another ds viewer
        } else {
            $viewer = new DataStoreViewer($requestedName, $container->get(TemplateRendererInterface::class));
        }
        return $viewer;
    }
}
