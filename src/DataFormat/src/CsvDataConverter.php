<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 28.08.17
 * Time: 15:35
 */

namespace rollun\dataFormat;

use DateTime;
use Generator;
use Psr\Http\Message\StreamInterface;
use rollun\dataFormat\Interfaces\DataConverterInterface;
use RuntimeException;
use Traversable;
use Zend\Diactoros\Stream;

class CsvDataConverter implements DataConverterInterface
{

    const QUOTATION = "\"";
    const NEW_LINE_SEPARATOR = "\n";

    /** @var  string */
    protected $delimiter;

    /**
     * CsvDataConverter constructor.
     * @param $delimiter
     */
    public function __construct($delimiter)
    {
        $this->delimiter = $delimiter;
    }

    /**
     * @param StreamInterface $stream
     * @return Generator|Traversable
     * @throws RuntimeException
     */
    public function getUnserializeDataIterator(StreamInterface $stream)
    {
        if (!$stream->isReadable()) {
            throw new RuntimeException("Stream not readable.");
        }

        if (is_null($stream->getSize())) {
            throw new RuntimeException("Stream size is null.");
        }

        $wrapperType = $stream->getMetadata("wrapper_type");
        $wrapperData = $stream->getMetadata("wrapper_data");
        if (!$this->isMetadataValid($wrapperType, $wrapperData)) {
            throw new RuntimeException("Metadata not valid. Stream not supported.");
        }

        //todo: create read form buffer by one line.
        $contents = $stream->getContents();

        //explode data by line.
        $data = explode(static::NEW_LINE_SEPARATOR, $contents);
        unset($contents);
        //get headers
        $headers = explode($this->delimiter, $data[0]);
        unset($data[0]);
        foreach ($data as $key => $string) {
            $itemValues = explode($this->delimiter, $string);
            $item = array_combine($headers, $itemValues);
            yield $item;
        }
        return;
    }

    /**
     * @param $wrapperType
     * @param $wrapperData
     * @return bool
     */
    protected function isMetadataValid($wrapperType, $wrapperData)
    {
        if (!in_array($wrapperType, stream_get_wrappers())) {
            return false;
        }
        //todo: add wrapperData handle.
        return true;
    }

    /**
     * @param iterable $data
     * @return StreamInterface?
     */
    public function getSerializeStream(iterable $data)
    {
        $tempFile = tempnam(sys_get_temp_dir(), "csvDataConverterStream_");
        if ($tempFile === false) {
            throw new RuntimeException("Tmp file not created.");
        }
        $stream = new Stream(@fopen("php://memory", "wb+"), "wb+");
        if (!$stream->isWritable()) {
            throw new RuntimeException("Stream not writable.");
        }
        if (!empty($data)) {
            $header = $this->getHeader($data);
            //write header.
            $string = implode($this->delimiter, $header);
            $string .= static::NEW_LINE_SEPARATOR;
            $stream->write($string);
            foreach ($data as $item) {
                $string = $this->valuesImplode($header, $item);
                $stream->write($string);
            }
            return $stream;
        } else {
            unlink($tempFile);
            return null;
        }
    }

    /**
     * @param iterable $data
     * @return array
     */
    protected function getHeader(iterable $data)
    {
        $header = [];
        foreach ($data as $item) {
            $keys = array_keys($item);
            foreach ($keys as $key) {
                if (!in_array($key, $header)) {
                    $header[] = $key;
                }
            }
        }
        return $header;
    }

    /**
     * @param array $header
     * @param array $values
     * @return string
     */
    protected function valuesImplode(array $header, array $values)
    {
        $string = "";
        foreach ($header as $key) {
            if (!array_key_exists($key, $values)) {
                $values[$key] = null;
            }
            $value = $this->valueHandle($values[$key]);
            $string .= $value . $this->delimiter;
        }
        $string = trim($string, $this->delimiter);
        $string .= static::NEW_LINE_SEPARATOR;
        return $string;
    }

    /**
     * @param $value
     * @return string
     */
    protected function valueHandle($value)
    {
        switch (true) {
            case $value instanceof DateTime:
                $value = static::QUOTATION . $value->format("c") . static::QUOTATION;
                break;
            case is_null($value):
                $value = "";
                break;
            case is_object($value) && method_exists($value, '__toString'):
                $value = static::QUOTATION . $value->__toString() . static::QUOTATION;
                break;
            case is_string($value):
                $value = static::QUOTATION . $value . static::QUOTATION;
                break;
            default:
                $value = (string)$value;
        }
        return $value;
    }
}
