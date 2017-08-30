<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.08.17
 * Time: 12:48
 */

namespace rollun\dataFormat\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class DataStoreExporter extends AbstractDataStoreImprtExprtMiddleware
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
        $stream = $this->dataStoreImportExport->downloadData();
        $response = new Response( 'php://memory', 200, [
            "Content-Type" => "application/octet-stream",
            "Accept-Ranges" => "bytes",
            "Content-Length" => $stream->getSize(),
            "Content-Transfer-Encoding" => "binary",
            "Content-Description"=>"File Transfer",
            "Pragma"=>"public",
            "Content-Disposition" => "attachment; filename=ExportedDataStore"
        ]);
        $response = $response->withBody($stream);
        $request = $request->withAttribute('responseData', $response);
        //$response = $delegate->process($request);
        return $response;
    }
}
