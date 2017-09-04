<?php

namespace rollun\DataManager;

use rollun\DataManager\Helper;
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
            'view_helpers' => $this->getViewHelpers(),
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
                'dataStoreImport' => Helper\ImportHelper::class,
                'dataStoreExport' => Helper\ExportHelper::class,
            ],
            'factories' => [
                Helper\ImportHelper::class => InvokableFactory::class,
                Helper\ExportHelper::class => InvokableFactory::class,
            ],
            'abstract_factories' => [],
        ];
    }
}
