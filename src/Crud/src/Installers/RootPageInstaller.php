<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13.01.17
 * Time: 12:59
 */

namespace rollun\Crud\Installers;

use rollun\actionrender\Factory\ActionRenderAbstractFactory;
use rollun\actionrender\Installers\ActionRenderInstaller;
use rollun\actionrender\Installers\BasicRenderInstaller;
use rollun\Crud\Helper\Factory\RootPageHelperFactory;
use rollun\installer\Command;
use rollun\installer\Install\InstallerAbstract;
use rollun\Crud\Middleware\CrudAction;

class RootPageInstaller extends InstallerAbstract
{

    /**
     * install
     * @return array
     */
    public function install()
    {
        $defaultUrl = "http://" . constant("HOST") . "/";
        do {
            $url = $this->consoleIO->ask("Enter the uri to central (root) home page in you system. (By default use - `$defaultUrl`): ", $defaultUrl);
        } while (!$this->consoleIO->askConfirmation("You enter `$url`, Save this choice ?(y\\n) "));

        return [
            RootPageHelperFactory::KEY => [
                RootPageHelperFactory::KEY_URI_STRING => $url,
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
                $description = "Предоставляет настройку ссылки к центральной домашней странице.";
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
            isset($config[RootPageHelperFactory::KEY][RootPageHelperFactory::KEY_URI_STRING])
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
