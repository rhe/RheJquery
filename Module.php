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
}