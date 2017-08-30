<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 28.08.17
 * Time: 13:57
 */

namespace rollun\dataFormat\Interfaces;

use Generator;
use Psr\Http\Message\StreamInterface;
use Traversable;

interface DataConverterInterface
{
    /**
     * @param StreamInterface $stream
     * @return Generator|Traversable
     */
    public function getUnserializeDataIterator(StreamInterface $stream);

    /**
     * @param iterable $data
     * @return StreamInterface
     */
    public function getSerializeStream(iterable $data);
}
