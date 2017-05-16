<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27.01.17
 * Time: 16:59
 */

namespace rollun\viewer\Renderer\Html;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use rollun\actionrender\Renderer\Html\HtmlParamResolver;
use rollun\actionrender\Renderer\Html\HtmlRendererAction;

class DSDojoHtmlParamResolver extends HtmlParamResolver
{
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $resourceName = $request->getAttribute('resourceName');
        $request = $request->withAttribute('responseData', ['resourceName' => $resourceName]);
        if (isset($out)) {
            return $out($request, $response);
        }
        return $response;
    }
}
