<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 21.01.17
 * Time: 12:05
 */

namespace rollun\viewer;

use rollun\installer\Command;
use rollun\installer\Install\InstallerAbstract;

class ViewerCSVInstaller extends InstallerAbstract
{

    const CSV_DIR = 'csv_storage';
    const CSV_FILE = 'testCsvBase.csv';

    public function uninstall()
    {
        if (constant('APP_ENV') !== 'dev') {
            $this->io->write('constant("APP_ENV") !== "dev" It has did nothing');
            exit;
        }
        $publicDir = Command::getDataDir();
        if (file_exists($publicDir . DIRECTORY_SEPARATOR . self::CSV_DIR . DIRECTORY_SEPARATOR . self::CSV_FILE)) {
            unlink($publicDir . DIRECTORY_SEPARATOR . self::CSV_DIR . DIRECTORY_SEPARATOR . self::CSV_FILE);
        }
        if (is_dir($publicDir . DIRECTORY_SEPARATOR . self::CSV_DIR)) {
            rmdir($publicDir . DIRECTORY_SEPARATOR . self::CSV_DIR);
        }
    }
    /**
     * install
     * @return void
     */
    public function install()
    {
        if (constant('APP_ENV') !== 'dev') {
            $this->io->write('constant("APP_ENV") !== "dev" It has did nothing');
            exit;
        }
        $dir = Command::getDataDir() . DIRECTORY_SEPARATOR . self::CSV_DIR;
        if(!is_dir($dir)) {
            mkdir($dir,0777,true);
        }
        $file = $dir . DIRECTORY_SEPARATOR . self::CSV_FILE;
        fopen($file, "w");
        file_put_contents($file, "id;name;data\n");
        for ($i = 0; $i < 10; $i++) {
            file_put_contents($file, "$i;name$i;data$i\n", FILE_APPEND);
        }
    }
}
