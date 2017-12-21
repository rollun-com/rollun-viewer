<?php
/**
 * Created by PhpStorm.
 * User: victorsecuring
 * Date: 08.12.17
 * Time: 4:41 PM
 */

namespace rollun\Crud\Helper;

use Zend\Uri\Uri;
use Zend\View\Helper\AbstractHelper;

/**
 * Class RootPageHelper need for configure url to central home page.
 * @package rollun\Crud\Helper
 */
class RootPageHelper extends AbstractHelper
{
    /**
     * @var Uri
     */
    protected $rootPageUri;

    /**
     * RootPageHelper constructor.
     * @param Uri $rootPageUri
     */
    public function __construct(Uri $rootPageUri)
    {
        $this->rootPageUri = $rootPageUri;
    }

    /**
     * Return string uri to central(root) home page.
     * @return string
     */
    public function __invoke()
    {
        return $this->rootPageUri->toString();
    }
}