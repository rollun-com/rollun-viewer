<?php
/**
 * Created by PhpStorm.
 * User: USER_T
 * Date: 06.08.2018
 * Time: 18:32
 */

namespace rollun\Crud\Helper;


use Exception;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Renderer\RendererInterface;

class DojoLoaderViewHelper extends AbstractHelper
{
    protected $isInitialised = false;
    protected $rgridVersion = '0.5.16';
    protected $rollunRqlVersion = '0.3.8';
    protected $debugMode = false;

    protected $packages = [
        [
            'name' => 'dstore',
            'location' => 'https://cdn.jsdelivr.net/npm/dojo-dstore@1.x'
        ],
        [
            'name' => 'dgrid',
            'location' => 'https://cdn.jsdelivr.net/npm/dgrid@1.x'
        ],
        [
            'name' => 'dijit',
            'location' => 'https://cdn.jsdelivr.net/npm/dijit@1.x'
        ],
        [
            'name' => 'dojox',
            'location' => 'https://cdn.jsdelivr.net/npm/dojox@1.x'
        ],
        [
            'name' => 'promised-io',
            'location' => 'https://cdn.jsdelivr.net/npm/promised-io@0.x'
        ],
    ];

    /**
     * @param $libName {string} - lib name
     * @param $version {string} - semver string with required version;
     * @throws Exception
     */
    public function changeVersion($libName, $version)
    {
        switch ($libName) {
            case 'rgrid':
                {
                    $this->rgridVersion = $version;
                    break;
                }
            case 'rollun-rql':
                {
                    $this->rollunRqlVersion = $version;
                    break;
                }
            default:
                {
                    throw new Exception("$libName is not a valid lib name");
                }
        }

    }

    /**
     * @return array
     */
    public function getVersions()
    {
        return [
            'rgrid' => $this->rgridVersion,
            'rollun-rql' => $this->rollunRqlVersion
        ];
    }

    /**
     * @param $packageName
     * @param $url
     */
    public function register($packageName, $url)
    {
        $this->packages[] = ['name' => $packageName, 'location' => $url];
    }

    /**
     * @param $packages array
     */
    public function multiRegister($packages)
    {
        foreach ($packages as $package) {
            $this->register($package['name'], $package['location']);
        }
    }

    /**
     * @param $isDebug bool
     */
    public function setDebug($isDebug)
    {
        $this->debugMode = $isDebug;
    }

    public function render()
    {
        if ($this->isInitialised) {
            return;
        }
        $rgridUrl = "https://cdn.jsdelivr.net/npm/rgrid@$this->rgridVersion/lib";
        $rollunRqlUrl = "https://cdn.jsdelivr.net/npm/rollun-rql@$this->rollunRqlVersion/";
        $rgridExamplesUrl = "https://cdn.jsdelivr.net/npm/rgrid@$this->rgridVersion/example";
        $rgridConfigUrl = $this->getRgridConfigUrl();
        $this->multiRegister([
            [
                'name' => 'rgrid',
                'location' => $rgridUrl,
            ],
            [
                'name' => 'rql',
                'location' => $rollunRqlUrl,
            ],
            [
                'name' => 'rgrid-examples',
                'location' => $rgridExamplesUrl,
            ],
            [
                'name' => 'config',
                'location' => $rgridConfigUrl
            ]
        ]);

        /** @var RendererInterface $view */
        $view = $this->getView();
        $dojoConfigString = $this->generateDojoConfig();
        $view->headScript()->appendScript("var dojoConfig = JSON.parse('$dojoConfigString');");
        $view->headLink()
            ->appendStylesheet("https://cdn.jsdelivr.net/npm/rgrid@$this->rgridVersion/themes/flat/flat.css")
            ->appendStylesheet("https://cdn.jsdelivr.net/npm/rgrid@$this->rgridVersion/lib/css/rgrid.css");
        $view->headScript()->appendFile('https://ajax.googleapis.com/ajax/libs/dojo/1.11.1/dojo/dojo.js');
        $view->inlineScript()->appendScript("require(['dojo/dom-class','dojo/_base/window'], 
                                          (domClass, window) => {domClass.add(window.body(), 'flat');});");

        $this->isInitialised = true;
    }

    /**
     * @return string
     */
    protected function getRgridConfigUrl()
    {
        return '/';
    }

    /**
     * @return string
     */
    protected function generateDojoConfig()
    {
        $packagesJson = $this->generatePackagesJson();
        $isDebug = $this->debugMode ? 'true' : 'false';
        return "{\"async\": true, \"isDebug\": $isDebug, \"packages\": $packagesJson}";
    }

    /**
     * @return string
     */
    protected function generatePackagesJson()
    {
        return json_encode($this->packages);
    }
}
