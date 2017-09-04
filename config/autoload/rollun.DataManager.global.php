<?php
/**
 * Created by PhpStorm.
 * User: victorynox
 * Date: 04.09.17
 * Time: 19:56
 */

use rollun\actionrender\Factory\LazyLoadPipeAbstractFactory;
use rollun\DataManager\Middleware\Factory\DataManagerMiddlewareAbstractFactory;
use rollun\DataManager\Middleware\LazyLoadMiddlewareGetters\LazyLoadDataManagerMiddlewareGetter;
use rollun\DataManager\Serializer\Adapter\Factory\CsvAdapterAbstractFactory;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'dependencies' => [
        'factories' => [
            LazyLoadDataManagerMiddlewareGetter::class => InvokableFactory::class
        ],
        'abstract_factories' => [
            CsvAdapterAbstractFactory::class,
            DataManagerMiddlewareAbstractFactory::class,
        ],
        'aliases' => [],
    ],
    LazyLoadPipeAbstractFactory::KEY => [
        'api-dataManager' => LazyLoadDataManagerMiddlewareGetter::class,
    ],
];