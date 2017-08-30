<?php

namespace rollun\Crud;

use rollun\Crud\Helper;
use Zend\ServiceManager\Factory\InvokableFactory;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'templates' => $this->getTemplates(),
            'view_helpers' => $this->getViewHelpers(),
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates()
    {
        return [
            'paths' => [
                'crud-app' => [__DIR__ . '/../templates/crud-app'],
                'crud-error' => [__DIR__ . '/../templates/crud-error'],
                'crud-layout' => [__DIR__ . '/../templates/crud-layout']
            ],
            'layout' => 'crud-layout::admin-layout',
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getViewHelpers()
    {
        return [
            'aliases' => [
                'crudTable' => Helper\CrudViewHelper::class,
                'bootstrap' => Helper\BootstrapHelper::class,
                'lsb' => Helper\LeftSideBarHelper::class,
                'mainMenu' => Helper\MainMenuHelper::class
            ],
            'invokables' => [],
            'factories' => [
                Helper\CrudViewHelper::class => InvokableFactory::class,
                Helper\BootstrapHelper::class => InvokableFactory::class,
                Helper\LeftSideBarHelper::class => InvokableFactory::class,
                Helper\MainMenuHelper::class => InvokableFactory::class
            ],
            'abstract_factories' => [],
        ];
    }
}
