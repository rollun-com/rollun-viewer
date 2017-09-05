<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 04.09.17
 * Time: 16:04
 */

namespace rollun\DataManager\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Xiag\Rql\Parser\Query;
use Zend\Diactoros\Response;
use Zend\Diactoros\Stream;
use Zend\Serializer\Adapter\AdapterInterface;

class ExporterFileRender implements MiddlewareInterface
{

    /** @var AdapterInterface */
    protected $serializer;

    /**
     * ExporterMiddleware constructor.
     * @param AdapterInterface $serializer
     */
    public function __construct(AdapterInterface $serializer)
    {
        $this->serializer = $serializer;
    }

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
        $responseData= $request->getAttribute('responseData');
        $data = $this->serializer->serialize($responseData);
        $response = new Response(
            'php://memory',
            200,
            [
                "Content-Type" => "application/octet-stream",
                "Accept-Ranges" => "bytes",
                "Content-Length" => mb_strlen($data),
                "Content-Transfer-Encoding" => "binary",
                "Content-Description" => "File Transfer",
                "Pragma" => "public",
                "Content-Disposition" => "attachment; filename=ExportedDataStore.csv"
            ]
        );
        $response->getBody()->write($data);
        $request = $request->withAttribute(ResponseInterface::class, $response);
        $response = $delegate->process($request);
        return $response;
    }
}
