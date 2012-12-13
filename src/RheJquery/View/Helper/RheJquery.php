<?php
/**
 * @author Robert Hennig <info@robcoding.de>
 * @copyright Copyright (c) 2012 Robert Hennig <info@robcoding.de>
 */
namespace RheJquery\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * The Jquery view helper.
 * 
 * This view helper provides the following functionallity:
 * - manage (append/prepend) java script files
 * - manage (append/prepend) css files
 * - manage (append/prepend) JavaScript code to add to JQuery .reday method
 * - receive the necessary HTML to add to the head
 * 
 * @author Robert Hennig <info@robcoding.de>
 * @copyright Copyright (c) 2012 Robert Hennig <info@robcoding.de>
 */
class RheJquery extends AbstractHelper {
	/**
	 * The JavaScript files to include from within the head of the HTML document.
	 * 
	 * @var array
	 */
	private $_javaScriptFiles = array();
	
	/**
	 * The CSS files to include from within the head of the HTML document.
	 * 
	 * @var array
	 */
	private $_cssFiles = array();
	
	/**
	 * JavaScript code snippets to add to the ${document}.ready function.
	 * 
	 * @var array
	 */
	private $_documentReadySnippets = array();
	
	/**
	 * Returns all CSS files to include in the head of the HTML document.
	 * 
	 * @return array:
	 */
	public function getCssFiles() {
		return $this->_cssFiles;
	}
	
	/**
	 * Append a CSS file URI to the collection of CSS files to include in the
	 * head of the HTML document.
	 * 
	 * @param string $cssFile
	 */
	public function appendCssFile($cssFile) {
		$this->_cssFiles[] = $cssFile;
	}
	
	/**
	 * Prepend a CSS file URI to the collection of CSS URI's to include in the 
	 * head of the HTML document.
	 * 
	 * @param string $cssFile
	 */
	public function prependCssFile($cssFile) {
		array_unshift($this->_cssFiles, $cssFile);
	}
	
	/**
	 * Append a JavaScript file URI to the collection of JavaScript URI's to
	 * include in the head of the HTML document.
	 *  
	 * @param string $javaScriptFile
	 */
	public function appendJavaScriptFile($javaScriptFile) {
		$this->_javaScriptFiles[] = $javaScriptFile;
	}
	
	/**
	 * Prepend a JavaScript file URI to the collection of JavaScript URI's to
	 * include in the head of the HTML document.
	 * 
	 * @param string $javaScriptFile
	 */
	public function prependJavaScriptFile($javaScriptFile) {
		array_unshift($this->_javaScriptFiles, $javaScriptFile);
	}
	
	/**
	 * Returns the collection of JavaScript file URI's to include in the head
	 * of the HTML document.
	 * 
	 * @return array:
	 */
	public function getJavaScriptFiles() {
		return $this->_javaScriptFiles;
	}
	
	/**
	 * Returns the collection of JavaScript snippets to add to the 
	 * ${document}.ready function in the head of the HTML document.
	 * 
	 * @return array
	 */
	public function getDocumentReadySnippets() {
		return $this->_documentReadySnippets;
	}
	
	/**
	 * Appends a JavaScript snippet to the collection of snippets to add to the
	 * ${document}.ready() function in the head of the HTML document.
	 * 
	 * @param string $javaScriptSnippet
	 */
	public function appendDocumentReadySnippet($javaScriptSnippet) {
		$this->_documentReadySnippets[] = $javaScriptSnippet;
	}
	
	/**
	 * Prepends a JavaScript snippet to the collection of snippets to ad to the
	 * ${document}.ready() function in the head of the HTML document.
	 * 
	 * @param string $javaScriptSnippet
	 */
	public function prependDocumentReadySnippet($javaScriptSnippet) {
		array_unshift($this->_documentReadySnippets, $javaScriptSnippet);
	}
	
	/**
	 * Returns the necessary HTML to add to the head of the HTML document.
	 * 
	 * @return string
	 */
	public function head() {
		$html = '';
		foreach($this->_cssFiles as $file) {
			$html.= "<link href=\"$file\" media=\"screen\" rel\"stylesheet\" ".
				"type=\"text/css\"/>\n";
		}
		foreach($this->_javaScriptFiles as $file) {
			$html.= "<script type=\"text/javascript\" src=\"".$file."\"></script>\n";
		}
		if(!empty($this->_documentReadySnippets)) {
			$html.= "<script type=\"text/javascript\">\n";
			$html.= "\t<!--\n";
			$html.= "\t".'${document}.ready(function() {'."\n";
			foreach($this->_documentReadySnippets as $snippet) {
				$html.= "\t$snippet\n\n";
			}
			$html.= "\t".'});';
			$html.= "\t-->";
			$html.= "</script>\n";
		}
		return $html;
	}
	
	/**
	 * Returns Jquery object.
	 * 
	 * @return Jquery
	 */
	public function __invoke() {
		return $this;
	}
}