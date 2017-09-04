<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 04.09.17
 * Time: 14:03
 */

namespace rollun\DataManager\Serializer\Adapter;

use DateTime;
use rollun\DataManager\Interfaces\DataSerializerInterfaces;
use Zend\Serializer\Adapter\AdapterInterface;

class CsvAdapter implements DataSerializerInterfaces
{
    /**
     * @var string
     */
    protected $delimiter;

    /**
     * @var string
     */
    protected $quotation;

    /**
     * @var string
     */
    protected $newLineSeparator;

    /**
     * CsvAdapter constructor.
     * @param $delimiter
     * @param $quotation
     * @param $newLineSeparator
     */
    public function __construct($delimiter = ",", $quotation = "\"", $newLineSeparator = "\n")
    {
        $this->delimiter = $delimiter;
        $this->quotation = $quotation;
        $this->newLineSeparator = $newLineSeparator;
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
        $string .= $this->newLineSeparator;
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
                $value = $this->quotation . $value->format("c") . $this->quotation;
                break;
            case is_null($value):
                $value = "";
                break;
            case is_object($value) && method_exists($value, '__toString'):
                $value = $this->quotation . $value->__toString() . $this->quotation;
                break;
            case is_string($value):
                $value = $this->quotation . $value . $this->quotation;
                break;
            default:
                $value = (string)$value;
        }
        return $value;
    }
    
    /**
     * Generates a storable representation of a value.
     *
     * @param  mixed $data Data to serialize
     * @return string
     * @throws \Zend\Serializer\Exception\ExceptionInterface
     */
    public function serialize($data)
    {
        $csvData = "";
        //validation
        $header = $this->getHeader($data);
        $string = implode($this->delimiter, $header);
        $string .= $this->newLineSeparator;
        $csvData .= $string;
        /** @var array $data */
        /** @var array $item */
        foreach ($data as $item) {
            $string = $this->valuesImplode($header, $item);
            $csvData .= $string;
        }
        return $csvData;
    }

    /**
     * Creates a PHP value from a stored representation.
     *
     * @param  string $serialized Serialized string
     * @return mixed
     * @throws \Zend\Serializer\Exception\ExceptionInterface
     */
    public function unserialize($serialized)
    {
        $response = [];
        $data = explode($this->newLineSeparator, $serialized);
        $headers = explode($this->delimiter, $data[0]);
        foreach ($data as $key => $string) {
            $itemValues = explode($this->delimiter, $string);
            foreach ($itemValues as &$itemValue) {
                $itemValue = trim($itemValue, $this->quotation);
            }
            $item = array_combine($headers, $itemValues);
            $response[] = $item;
        }
        return $response;
    }

    /**
     * @return string
     */
    public function getSerializationType()
    {
        return "csv";
    }
}
