<?php

namespace rollun\Crud;

use rollun\Crud\Helper;
use rollun\Crud\Helper\Factory\JSInitHelperFactory;
use rollun\Crud\Helper\Factory\RootPageHelperFactory;
use rollun\Crud\Helper\ImporterViewHelper;
use rollun\Crud\Helper\JSInitHelper;
use rollun\Crud\Helper\DojoLoaderViewHelper;
use rollun\Crud\Helper\Factory\NavbarHelperFactory;
use rollun\Crud\Helper\FitScreenHeightHelper;
use rollun\Crud\Helper\LeftSideBarHelper;
use rollun\Crud\Helper\NavbarHelper;
use rollun\Crud\Helper\RgridHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Expressive\ZendView\HelperPluginManagerFactory;
use Zend\Expressive\ZendView\ZendViewRendererFactory;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\View\HelperPluginManager;

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
            'dependencies' => $this->getDependencies(),
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
                'crudApp' => [__DIR__ . '/../templates/crudApp'],
                'crudError' => [__DIR__ . '/../templates/crudError'],
                'crudLayout' => [__DIR__ . '/../templates/crudLayout']
            ],
            'layout' => 'crudLayout::august-layout',
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
                'advCrudTable' => Helper\AdvCrudViewHelper::class,
                'bootstrap' => Helper\BootstrapHelper::class,
                'rootPage' => Helper\RootPageHelper::class,
                'mainMenu' => Helper\MainMenuHelper::class,
                'importer' => ImporterViewHelper::class,
                'jsInit' => JSInitHelper::class,
                'dojoLoader' => DojoLoaderViewHelper::class,
                'addLsb' => LeftSideBarHelper::class,
                'addNavbar' => NavbarHelper::class,
                'fitScreenHeight' => FitScreenHeightHelper::class,
                'rgrid' => RgridHelper::class
            ],
            'factories' => [
                Helper\RootPageHelper::class => RootPageHelperFactory::class,
                Helper\CrudViewHelper::class => InvokableFactory::class,
                Helper\AdvCrudViewHelper::class => InvokableFactory::class,
                Helper\BootstrapHelper::class => InvokableFactory::class,
                Helper\MainMenuHelper::class => InvokableFactory::class,
                ImporterViewHelper::class => InvokableFactory::class,
                JSInitHelper::class => JSInitHelperFactory::class,
                DojoLoaderViewHelper::class => InvokableFactory::class,
                LeftSideBarHelper::class => InvokableFactory::class,
                FitScreenHeightHelper::class => InvokableFactory::class,
                NavbarHelper::class => NavbarHelperFactory::class,
                RgridHelper::class => InvokableFactory::class
            ],
            'abstract_factories' => [],
        ];
    }

    public function getDependencies()
    {
        return [
            'factories' => [
                TemplateRendererInterface::class => ZendViewRendererFactory::class,
                HelperPluginManager::class => HelperPluginManagerFactory::class,
            ],
        ];
    }
}

