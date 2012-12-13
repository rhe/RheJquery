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
	
	public function testPrependJavaScriptFile() {
		$jquery = new RheJquery();
		$jquery->prependJavaScriptFile('/second.js');
		$jquery->prependJavaScriptFile('/first.js');
		$this->assertEquals(array('/first.js', '/second.js'), $jquery->getJavaScriptFiles());
	}
	
	public function testAppendDocumentReadySnippet() {
		$jquery = new RheJquery();
		$jquery->appendDocumentReadySnippet('firstSnippet');
		$jquery->appendDocumentReadySnippet('secondSnippet');
		$this->assertEquals(array('firstSnippet', 'secondSnippet'), $jquery->getDocumentReadySnippets());
	}
	
	public function testPrependDocumentReadySnippet() {
		$jquery = new RheJquery();
		$jquery->prependDocumentReadySnippet('secondSnippet');
		$jquery->prependDocumentReadySnippet('firstSnippet');
		$this->assertEquals(array('firstSnippet', 'secondSnippet'), $jquery->getDocumentReadySnippets());
	}
	
	public function testHead() {
		$jquery = new RheJquery();
		$jquery->appendCssFile('/test.css');
		$jquery->appendJavaScriptFile('/test.js');
		$jquery->appendDocumentReadySnippet('testSnippet');
		
		$expected = "<link href=\"/test.css\" media=\"screen\" rel\"stylesheet\" ".
				"type=\"text/css\"/>\n";
		$expected.= "<script type=\"text/javascript\" src=\"/test.js\"></script>\n";
		$expected.= "<script type=\"text/javascript\">\n";
		$expected.= "\t<!--\n";
		$expected.= "\t".'${document}.ready(function() {'."\n";
		$expected.= "\ttestSnippet\n\n";
		$expected.= "\t".'});';
		$expected.= "\t-->";
		$expected.= "</script>\n";
		
		$this->assertEquals($expected, $jquery->head());
	}
	
	public function testInvoke() {
		$jquery = new RheJquery();
		$this->assertEquals(get_class($jquery), get_class($jquery()));
	}
}