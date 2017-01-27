<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 21.01.17
 * Time: 12:13
 */

namespace rollun\viewer;

use Composer\IO\IOInterface;
use Interop\Container\ContainerInterface;
use rollun\installer\Install\InstallerAbstract;
use rollun\datastore\TableGateway\TableManagerMysql as TableManager;
use Zend\Db\Adapter\AdapterInterface;


class ViewerFilterInstaller extends InstallerAbstract
{

    const FILTERS_TABLE_NAME = 'filters';
    /**
     *
     * @var AdapterInterface
     */
    private $dbAdapter;

    /**
     *
     *
     * Add to config:
     * <code>
     *    'services' => [
     *        'aliases' => [
     *            EavAbstractFactory::DB_SERVICE_NAME => getenv('APP_ENV') === 'prod' ? 'dbOnProduction' : 'local-db',
     *        ],
     *        'abstract_factories' => [
     *            EavAbstractFactory::class,
     *        ]
     *    ],
     * </code>
     * @param ContainerInterface $container
     * @param IOInterface $ioComposer
     */
    public function __construct(ContainerInterface $container, IOInterface $ioComposer)
    {
        parent::__construct($container, $ioComposer);
        if ($this->container->has('db')) {
            $this->dbAdapter = $this->container->get('db');
        } else {
            $this->io->write("db not fount. It has did nothing");
            exit;
        }
    }

    /**
     * Remove Table
     */
    public function uninstall()
    {
        if (constant('APP_ENV') !== 'dev') {
            $this->io->write('constant("APP_ENV") !== "dev" It has did nothing');
        }

        $tableManager = new TableManager($this->dbAdapter);
        $tableManager->deleteTable(self::FILTERS_TABLE_NAME);
    }

    /**
     * Create table
     */
    public function install()
    {
        if (isset($this->dbAdapter)) {
            if (constant('APP_ENV') === 'dev') {
                //develop only
                $tablesConfigDevelop = [
                    TableManager::KEY_TABLES_CONFIGS => array_merge(
                       $this->getTableConfig()
                    )
                ];
                $tableManager = new TableManager($this->dbAdapter, $tablesConfigDevelop);

                $tableManager->rewriteTable(self::FILTERS_TABLE_NAME);
            } else {
                $tablesConfigProdaction = [
                    TableManager::KEY_TABLES_CONFIGS =>$this->getTableConfig()
                ];
                $tableManager = new TableManager($this->dbAdapter, $tablesConfigProdaction);

                $tableManager->createTable(self::FILTERS_TABLE_NAME);
            }
        }
    }

    /**
     * return table Config
     * @return array
     */
    public function getTableConfig()
    {
        return [
            static::FILTERS_TABLE_NAME => [
                'id' => [
                    TableManager::FIELD_TYPE => 'Integer',
                    TableManager::FIELD_PARAMS => [
                        'options' => ['autoincrement' => true]
                    ]
                ],
                'name' => [
                    TableManager::FIELD_TYPE => 'Varchar',
                    TableManager::FIELD_PARAMS => [
                        'length' => 255,
                        'nullable' => false,
                    ],
                ],
                'filter' => [
                    TableManager::FIELD_TYPE => 'Varchar',
                    TableManager::FIELD_PARAMS => [
                        'length' => 255,
                        'nullable' => false,
                    ],
                ],
                'tableName' => [
                    TableManager::FIELD_TYPE => 'Varchar',
                    TableManager::FIELD_PARAMS => [
                        'length' => 255,
                        'nullable' => false,
                    ],
                ],
            ]
        ];
    }
}
