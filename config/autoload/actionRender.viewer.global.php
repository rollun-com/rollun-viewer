<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24.01.17
 * Time: 17:32
 */

use rollun\actionrender\Factory\ActionRenderAbstractFactory;
use rollun\actionrender\Factory\LazyLoadResponseRendererAbstractFactory;
use rollun\actionrender\Factory\MiddlewarePipeAbstractFactory;

return [
    'dependencies' => [
        'invokables' => [
            \rollun\viewer\Renderer\Html\DSDojoHtmlParamResolver::class =>
                \rollun\viewer\Renderer\Html\DSDojoHtmlParamResolver::class
        ],
        'factories' => [
            \rollun\datastore\Middleware\HtmlDataStoreRendererAction::class =>
                \rollun\actionrender\Renderer\Html\HtmlRendererFactory::class
        ]
    ],
    LazyLoadResponseRendererAbstractFactory::KEY => [
        'dsDojoHtmlJsonRenderer' => [
            LazyLoadResponseRendererAbstractFactory::KEY_ACCEPT_TYPE_PATTERN => [
                //pattern => middleware-Service-Name
                '/application\/json/' => \rollun\actionrender\Renderer\Json\JsonRendererAction::class,
                '/text\/html/' => 'dsDojoHtmlRenderer'
            ]
        ]
    ],
    ActionRenderAbstractFactory::KEY => [
        'api-rest' => [
            ActionRenderAbstractFactory::KEY_ACTION_MIDDLEWARE_SERVICE => 'apiRestAction',
            ActionRenderAbstractFactory::KEY_RENDER_MIDDLEWARE_SERVICE => 'dsDojoHtmlJsonRenderer'

        ]
    ],
    MiddlewarePipeAbstractFactory::KEY => [
        'dsDojoHtmlRenderer' => [
            'middlewares' => [
                \rollun\actionrender\Renderer\Html\HtmlParamResolver::class,
                \rollun\viewer\Renderer\Html\DSDojoHtmlParamResolver::class,
                \rollun\actionrender\Renderer\Html\HtmlRendererAction::class
            ]
        ]
    ],
];
