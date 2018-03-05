<?php

namespace rollun\Crud;

use rollun\Crud\Helper;
use rollun\Crud\Helper\Factory\JSInitHelperFactory;
use rollun\Crud\Helper\Factory\RootPageHelperFactory;
use rollun\Crud\Helper\ImporterViewHelper;
use rollun\Crud\Helper\JSInitHelper;
use Zend\ServiceManager\Factory\InvokableFactory;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
	/**
	 * Returns the configuration array
	 *
	 * To add a bit of a structure, each section is defined in a separate
	 * method which returns an array with its configuration.
	 *
	 * @return array
	 */
	public function __invoke()
	{
		return [
			'templates' => $this->getTemplates(),
			'view_helpers' => $this->getViewHelpers(),
		];
	}

	/**
	 * Returns the templates configuration
	 *
	 * @return array
	 */
	public function getTemplates()
	{
		return [
			'paths' => [
				'crud-app' => [__DIR__ . '/../templates/crud-app'],
				'crud-error' => [__DIR__ . '/../templates/crud-error'],
				'crud-layout' => [__DIR__ . '/../templates/crud-layout']
			],
			'layout' => 'crud-layout::admin-layout',
		];
	}

	/**
	 * Returns the container dependencies
	 *
	 * @return array
	 */
	public function getViewHelpers()
	{
		return [
			'aliases' => [
				'crudTable' => Helper\CrudViewHelper::class,
                'advCrudTable' => Helper\AdvCrudViewHelper::class,
				'bootstrap' => Helper\BootstrapHelper::class,
				'lsb' => Helper\LeftSideBarHelper::class,
				'rootPage' => Helper\RootPageHelper::class,
				'mainMenu' => Helper\MainMenuHelper::class,
                'importer' => ImporterViewHelper::class,
                'jsInit' => JSInitHelper::class,
			],
			'invokables' => [],
			'factories' => [
                Helper\RootPageHelper::class => RootPageHelperFactory::class,
                Helper\CrudViewHelper::class => InvokableFactory::class,
                Helper\AdvCrudViewHelper::class => InvokableFactory::class,
                Helper\BootstrapHelper::class => InvokableFactory::class,
				Helper\LeftSideBarHelper::class => InvokableFactory::class,
				Helper\MainMenuHelper::class => InvokableFactory::class,
                ImporterViewHelper::class => InvokableFactory::class,
                JSInitHelper::class => JSInitHelperFactory::class,
			],
			'abstract_factories' => [],
		];
	}
}
