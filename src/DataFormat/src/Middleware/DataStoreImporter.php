<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.08.17
 * Time: 12:52
 */

namespace rollun\dataFormat\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DataStoreImporter extends AbstractDataStoreImprtExprtMiddleware
{

    /**
     * Process an incoming server request and return a response, optionally delegating
     * to the next middleware component to create the response.
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        // TODO: Implement process() method.
    }
}
