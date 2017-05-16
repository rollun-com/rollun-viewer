<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13.01.17
 * Time: 12:59
 */

namespace rollun\test\Installers;


use rollun\actionrender\Factory\ActionRenderAbstractFactory;
use rollun\actionrender\Installers\ActionRenderInstaller;
use rollun\actionrender\Installers\BasicRenderInstaller;
use rollun\installer\Command;
use rollun\installer\Install\InstallerAbstract;
use rollun\test\Middleware\HelloAction;

class TestHelloWorldInstaller extends InstallerAbstract
{

    /**
     * install
     * @return array
     */
    public function install()
    {
        return [
            'dependencies' => [
                'invokables' => [
                    HelloAction::class => HelloAction::class
                ],
            ],
            ActionRenderAbstractFactory::KEY => [
                'home-service' => [
                    ActionRenderAbstractFactory::KEY_ACTION_MIDDLEWARE_SERVICE => HelloAction::class,
                    ActionRenderAbstractFactory::KEY_RENDER_MIDDLEWARE_SERVICE => 'simpleHtmlJsonRendererLLPipe'
                ]
            ],

        ];
    }

    /**
     * Clean all installation
     * @return void
     */
    public function uninstall()
    {

    }

    /**
     * Return string with description of installable functional.
     * @param string $lang ; set select language for description getted.
     * @return string
     */
    public function getDescription($lang = "en")
    {
        switch ($lang) {
            case "ru":
                $description = "Предоставляет базовое тестовое приложение.";
                break;
            default:
                $description = "Does not exist.";
        }
        return $description;
    }

    public function isInstall()
    {
        $config = $this->container->get('config');
        return (
            isset($config['dependencies']['invokables'][HelloAction::class]) &&
            isset($config[ActionRenderAbstractFactory::KEY]['home-service'])
        );
    }

    public function getDependencyInstallers()
    {
        return [
            ActionRenderInstaller::class,
            BasicRenderInstaller::class,
        ];
    }
}
