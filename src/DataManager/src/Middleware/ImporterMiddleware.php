<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 04.09.17
 * Time: 16:00
 */

namespace rollun\DataManager\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;

class ImporterMiddleware extends AbstractDataManagerMiddleware
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
        $response = new Response();
        if ($request->getMethod() === "POST") {
            $files = $request->getUploadedFiles();
            if(empty($files)) {
                /** @var UploadedFileInterface $file */
                $file = $files[array_keys($files)[0]];
                $data = $this->serializer->unserialize($file->getStream()->getContents());
                if(empty($data)) {
                    $this->dataStore->deleteAll();
                    foreach ($data as $item) {
                        $this->dataStore->create($item);
                    }
                }
                $response = $response->withStatus(201);
            } else {
                $response = $response->withStatus(204);
            }
        } else {
            $response = $response->withStatus(404);
        }
        return $response;
    }
}
