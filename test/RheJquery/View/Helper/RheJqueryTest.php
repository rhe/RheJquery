<?php
namespace RheJquery\View\Helper;

use PHPUnit_Framework_TestCase as TestCase;

class RheJqueryTest extends TestCase {
	public function testAppendCssFile() {
		$jquery = new RheJquery();
		$jquery->appendCssFile('/testpath/test.css');
		$this->assertEquals(array('/testpath/test.css'), $jquery->getCssFiles());
	}
	
	public function testPrependCssFile() {
		$jquery = new RheJquery();
		$jquery->prependCssFile('/testpath/test.css');
		$this->assertEquals(array('/testpath/test.css'), $jquery->getCssFiles());
	}
	
	public function testAppendJavaScriptFile() {
		$jquery = new RheJquery();
		$jquery->appendJavaScriptFile('/testPath/test.js');
		$this->assertEquals(array('/testPath/test.js'), $jquery->getJavaScriptFiles());
	}
}