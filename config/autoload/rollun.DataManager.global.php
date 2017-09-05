<?php
/**
 * Created by PhpStorm.
 * User: victorynox
 * Date: 04.09.17
 * Time: 19:56
 */

use rollun\actionrender\Factory\ActionRenderAbstractFactory;
use rollun\actionrender\Factory\LazyLoadPipeAbstractFactory;
use rollun\actionrender\LazyLoadMiddlewareGetter\Factory\AbstractLazyLoadMiddlewareGetterAbstractFactory;
use rollun\actionrender\LazyLoadMiddlewareGetter\Factory\ResponseRendererAbstractFactory;
use rollun\actionrender\LazyLoadMiddlewareGetter\ResponseRenderer;
use rollun\actionrender\Renderer\Json\JsonRendererAction;
use rollun\DataManager\Middleware\ExporterFileRender;
use rollun\DataManager\Middleware\Factory\ExporterFileRenderAbstractFactory;
use rollun\DataManager\Serializer\Adapter\Factory\CsvAdapterAbstractFactory;
use rollun\datastore\DataStore\CsvBase;
use rollun\datastore\LazyLoadDSMiddlewareGetter;
use rollun\installer\Command;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'dependencies' => [
        'factories' => [
        ],
        'abstract_factories' => [
            CsvAdapterAbstractFactory::class,
            ExporterFileRenderAbstractFactory::class,
        ],
        'aliases' => [
            "csv" => "csvAdapter"
        ],
    ],

    AbstractLazyLoadMiddlewareGetterAbstractFactory::KEY => [
        'dataStoreHtmlJsonFileRenderer' => [
            ResponseRendererAbstractFactory::KEY_MIDDLEWARE => [
                '/application\/json/' => JsonRendererAction::class,
                '/text\/html/' => 'dataStoreHtmlRenderer',
                '/text\/csv/' => 'csvFileRenderer',
            ],
            ResponseRendererAbstractFactory::KEY_CLASS => ResponseRenderer::class,
        ],
    ],

    LazyLoadPipeAbstractFactory::KEY => [
        'dataStoreLLPipe' => LazyLoadDSMiddlewareGetter::class,
        'dataStoreHtmlJsonFileRendererLLPipe' => 'dataStoreHtmlJsonFileRenderer'
    ],

    ActionRenderAbstractFactory::KEY => [
        'api-datastore' => [
            ActionRenderAbstractFactory::KEY_ACTION_MIDDLEWARE_SERVICE => 'apiDataStoreAction',
            ActionRenderAbstractFactory::KEY_RENDER_MIDDLEWARE_SERVICE => 'dataStoreHtmlJsonFileRendererLLPipe'
        ],
    ],

    ExporterFileRenderAbstractFactory::KEY => [
        'csvFileRenderer' => [
            ExporterFileRenderAbstractFactory::KEY_CLASS => ExporterFileRender::class,
            ExporterFileRenderAbstractFactory::KEY_SERIALIZER => "csvAdapter"
        ]
    ],

    CsvAdapterAbstractFactory::KEY => [
        'csvAdapter' => [
            CsvAdapterAbstractFactory::KEY_DELIMITER => ";",
        ]
    ],

    'dataStore' => [
        'logs' => [
            'class' => CsvBase::class,
            'filename' => Command::getDataDir() . 'logs/logs.csv',
            'delimiter' => ';',
        ]
    ],
];
