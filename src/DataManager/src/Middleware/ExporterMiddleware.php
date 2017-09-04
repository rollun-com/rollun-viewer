<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 04.09.17
 * Time: 16:04
 */

namespace rollun\DataManager\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Xiag\Rql\Parser\Query;
use Zend\Diactoros\Response;
use Zend\Diactoros\Stream;

class ExporterMiddleware extends AbstractDataManagerMiddleware
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
        $result = $this->dataStore->query(new Query());
        $data = $this->serializer->serialize($result);
        $type = $this->serializer->getSerializationType();
        file_put_contents('php://memory', $data);
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
                "Content-Disposition" => "attachment; filename=ExportedDataStore.$type"
            ]
        );
        return $response;
    }
}
