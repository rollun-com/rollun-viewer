<?php
/**
 * Created by PhpStorm.
 * User: victorynox
 * Date: 04.09.17
 * Time: 18:26
 */

namespace rollun\DataManager\Middleware\LazyLoadMiddlewareGetters;


use Psr\Http\Message\ServerRequestInterface as Request;
use rollun\actionrender\Interfaces\LazyLoadMiddlewareGetterInterface;
use rollun\actionrender\LazyLoadMiddlewareGetter\Attribute;
use rollun\DataManager\Middleware\ExporterMiddleware;
use rollun\DataManager\Middleware\Factory\DataManagerMiddlewareAbstractFactory;
use rollun\DataManager\Middleware\ImporterMiddleware;

class LazyLoadDataManagerMiddlewareGetter
{
    const ATTR_OPERATIONS = "operations";

    const ATTR_DATASTORE = 'dataStore';

    const ATTR_SERIALIZER = "serializer";

    protected $operations = [
        "export" => ExporterMiddleware::class,
        "import" => ImporterMiddleware::class,
    ];

    public function getLazyLoadMiddlewares(Request $request)
    {
        $serviceName = $request->getAttribute(static::ATTR_OPERATIONS);
        $dataStore = $request->getAttribute(self::ATTR_DATASTORE);
        $serializer  = $request->getAttribute(self::ATTR_SERIALIZER);
        $class = $this->operations[$serviceName];

        $result = [
            LazyLoadMiddlewareGetterInterface::KEY_FACTORY_CLASS => DataManagerMiddlewareAbstractFactory::class,
            LazyLoadMiddlewareGetterInterface::KEY_REQUEST_NAME => $serviceName,
            LazyLoadMiddlewareGetterInterface::KEY_OPTIONS => ["$serviceName" => [
                DataManagerMiddlewareAbstractFactory::KEY_DATASTORE => $dataStore,
                DataManagerMiddlewareAbstractFactory::KEY_SERIALIZER => $serializer,
                DataManagerMiddlewareAbstractFactory::KEY_CLASS => $class,
            ]]
        ];
        return [
            $result
        ];
    }
}