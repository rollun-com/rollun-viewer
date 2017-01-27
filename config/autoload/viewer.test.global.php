<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 21.01.17
 * Time: 10:57
 */

use rollun\installer\Command;

return [
    'dataStore' => [
        'testCsvBase' => [
            'class' => rollun\datastore\DataStore\CsvBase::class,
            'filename' => Command::getDataDir() . DIRECTORY_SEPARATOR .
                'csv_storage' . DIRECTORY_SEPARATOR .
                'testCsvBase.csv',
            'delimiter' => ';',
        ],
    ]
];
