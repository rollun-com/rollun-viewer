<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 28.08.17
 * Time: 13:47
 */

namespace rollun\dataFormat;

use Psr\Http\Message\StreamInterface;
use rollun\dataFormat\Interfaces\DataConverterInterface;
use rollun\datastore\DataStore\Interfaces\DataStoresInterface;
use Xiag\Rql\Parser\Query;

class DataStoreImportExport
{
    /** @var  DataStoresInterface */
    protected $dataStore;

    /** @var DataConverterInterface */
    protected $dataConverter;

    /**
     * DataUploader constructor.
     * @param DataStoresInterface $dataStore
     * @param DataConverterInterface $dataConverter
     */
    public function __construct(DataStoresInterface $dataStore, DataConverterInterface $dataConverter)
    {
        $this->dataStore = $dataStore;
        $this->dataConverter = $dataConverter;
    }

    /**
     * @param StreamInterface $stream
     * @return void
     */
    public function uploadData(StreamInterface $stream)
    {
        if ($stream->isReadable()) {
            $this->dataStore->deleteAll();
            foreach ($this->dataConverter->getUnserializeDataIterator($stream) as $item) {
                $this->dataStore->create($item);
            }
        }
    }

    /**
     * @return StreamInterface
     */
    public function downloadData()
    {
        $stream = $this->dataConverter->getSerializeStream($this->dataStore->query(new Query()));
        return $stream;
    }
}
