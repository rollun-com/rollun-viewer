<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 20.01.17
 * Time: 19:25
 */

use rollun\installer\Command;
use \rollun\logger\Installer as LoggerInstaller;


return [
    'dataStore' => [
        'loggerStore' => [
            'class' => rollun\datastore\DataStore\CsvBase::class,
            'filename' => Command::getDataDir() . DIRECTORY_SEPARATOR .
                LoggerInstaller::LOGS_DIR  . DIRECTORY_SEPARATOR .
                LoggerInstaller::LOGS_FILE,
            'delimiter' => ';',
        ],
        'filters' => [
            'class' => rollun\datastore\DataStore\DbTable::class,
            'tableName' => \rollun\viewer\ViewerFilterInstaller::FILTERS_TABLE_NAME
        ],
    ]
];
