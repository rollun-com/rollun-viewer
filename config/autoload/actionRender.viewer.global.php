<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24.01.17
 * Time: 17:32
 */

use rollun\actionrender\Factory\ActionRenderAbstractFactory;
use rollun\actionrender\Factory\MiddlewarePipeAbstractFactory;
use rollun\actionrender\Renderer\ResponseRendererAbstractFactory;
use rollun\datastore\Middleware\RequestDecoder;
use rollun\datastore\Middleware\ResourceResolver;

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
    ResponseRendererAbstractFactory::KEY_RESPONSE_RENDERER => [
        'dsDojoHtmlJsonRenderer' => [
            ResponseRendererAbstractFactory::KEY_ACCEPT_TYPE_PATTERN => [
                //pattern => middleware-Service-Name
                '/application\/json/' => \rollun\actionrender\Renderer\Json\JsonRendererAction::class,
                '/text\/html/' => 'dsDojoHtmlRenderer'
            ]
        ]
    ],
    ActionRenderAbstractFactory::KEY_AR_SERVICE => [
        'api-rest' => [
            ActionRenderAbstractFactory::KEY_AR_MIDDLEWARE => [
                ActionRenderAbstractFactory::KEY_ACTION_MIDDLEWARE_SERVICE => 'apiRestAction',
                ActionRenderAbstractFactory::KEY_RENDER_MIDDLEWARE_SERVICE => 'dsDojoHtmlJsonRenderer'
            ]
        ]
    ],
    MiddlewarePipeAbstractFactory::KEY_AMP => [
        'dsDojoHtmlRenderer' => [
            'middlewares' => [
                \rollun\actionrender\Renderer\Html\HtmlParamResolver::class,
                \rollun\viewer\Renderer\Html\DSDojoHtmlParamResolver::class,
                \rollun\actionrender\Renderer\Html\HtmlRendererAction::class
            ]
        ]
    ],
];
