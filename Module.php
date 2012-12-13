<?php
namespace RheJquery;

class Module {
	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\ClassMapAutoLoader' => array(
				__DIR__.'/autoload_classmap.php',
			),
		);
	}
	
	public function getConfig() {
		return include __DIR__.'/config/module.config.php';
	}
	
}