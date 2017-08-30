<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.08.17
 * Time: 13:08
 */

namespace rollun\dataFormat\Middleware;

use Interop\Http\ServerMiddleware\MiddlewareInterface;
use rollun\dataFormat\DataStoreImportExport;

abstract class AbstractDataStoreImprtExprtMiddleware implements MiddlewareInterface
{
    /** @var  DataStoreImportExport */
    protected $dataStoreImportExport;

    /**
     * DataStoreExporter constructor.
     * @param DataStoreImportExport $dataStoreImportExport
     */
    public function __construct(DataStoreImportExport $dataStoreImportExport)
    {
        $this->dataStoreImportExport = $dataStoreImportExport;
    }
}
