<?php
namespace RheJquery\Plugin\DataTables;

use PHPUnit_Framework_TestCase as TestCase;

class DataTablesTest extends TestCase {
	protected $_propertyDefaults = array(
		'bAutoWidth' => true,
		'bDeferRender' => false,
		'bFilter' => true,
		'bInfo' => true,
		'bJQueryUI' => false,
		'bLengthChange' => true,
		'bPaginate' => true,
		'bProcessing' => false,
		'bScrollInfinite' => false,
		'bServerSide' => false,
		'bSort' => true,
		'bSortClasses' => true,
		'bStateSave' => false,
		'sScrollX' => '',
		'sScrollY' => '',
		'bDestroy' => false,
		'bRetrieve' => false,
		'bScrollAutoCss' => true,
		'bScrollCollapse' => false,
		'bSortCellsTop' => false,
		'iCookieDuration' => 7200,
		'iDeferLoading' => null,
		'iDisplayLength' => 10,
		'iDisplayStart' => 0,
		'iScrollLoadGap' => 100,
		'iTabIndex' => 0,
		'oSearch' => null,
		'sAjaxDataProp' => 'aaData',
		'sAjaxSource' => null,
		'sCookiePrefix' => 'SpryMedia_DataTables_',
		'sDom' => 'lfrtip',
		'sPaginationType' => 'two_button',
		'sScrollXInner' => '',
		'sServerMethod' => 'GET',
		'fnCookieCallback' => '',
		'fnCreatedRow' => '',
		'fnDrawCallback' => '',
		'fnFooterCallback' => '',
		'fnFormatNumber' => '',
		'fnHeaderCallback' => '',
		'fnInfoCallback' => '',
		'fnInitComplete' => '',
		'fnPreDrawCallback' => '',
		'fnRowCallback' => '',
		'fnServerData' => '',
		'fnServerParams' => '',
		'fnStateLoad' => '',
		'fnStateLoadParams' => '',
		'fnStateLoaded' => '',
		'fnStateSave' => '',
		'fnStateSaveParams' => '',
		'aoColumnDefs' => '',
		'aoColumns' => '',
	);

	protected $_propertyValues = array(
		'bAutoWidth' => false,
		'bDeferRender' => true,
		'bFilter' => false,
		'bInfo' => false,
		'bJQueryUI' => true,
		'bLengthChange' => false,
		'bPaginate' => false,
		'bProcessing' => true,
		'bScrollInfinite' => true,
		'bServerSide' => true,
		'bSort' => false,
		'bSortClasses' => false,
		'bStateSave' => true,
		'sScrollX' => '100%',
		'sScrollY' => '200px',
		'bDestroy' => true,
		'bRetrieve' => true,
		'bScrollAutoCss' => false,
		'bScrollCollapse' => true,
		'bSortCellsTop' => true,
		'iCookieDuration' => 14400,
		'iDeferLoading' => 57,
		'iDisplayLength' => 20,
		'iDisplayStart' => 10,
		'iScrollLoadGap' => 50,
		'iTabIndex' => -1,
		'oSearch' => 'Initial search',
		'sAjaxDataProp' => 'bbData',
		'sAjaxSource' => 'http://www.sprymedia.co.uk/dataTables/json.php',
		'sCookiePrefix' => 'data_tables_',
		'sDom' => '<"top"i>rt<"bottom"flp><"clear">',
		'sPaginationType' => 'full_numbers',
		'sScrollXInner' => '110%',
		'sServerMethod' => 'POST',
		'fnCookieCallback' => 'return sName + "="+JSON.stringify(oData)+"; expires=" + sExpires +"; path=" + sPath;',
		'fnCreatedRow' => 'if ( aData[4] == "A" ) { $(\'td:eq(4)\', nRow).html( \'<b>A</b>\' ); }',
		'fnDrawCallback' => 'alert( \'DataTables has redrawn the table\' );',
		'fnFooterCallback' => 'nFoot.getElementsByTagName(\'th\')[0].innerHTML = "Starting index is "+iStart;',
		'fnFormatNumber' => 'if ( iIn < 1000 ) { return iIn; } else { var s=(iIn+""), a=s.split(""), out="", iLen=s.length; for ( var i=0 ; i<iLen ; i++ ) { if ( i%3 === 0 && i !== 0 ) { out = "\'"+out; } out = a[iLen-i-1]+out; } } return out;',
		'fnHeaderCallback' => 'nHead.getElementsByTagName(\'th\')[0].innerHTML = "Displaying "+(iEnd-iStart)+" records";',
		'fnInfoCallback' => 'return iStart +" to "+ iEnd;',
		'fnInitComplete' => 'alert( \'DataTables has finished its initialisation.\' );',
		'fnPreDrawCallback' => 'if ( $(\'#test\').val() == 1 ) { return false; }',
		'fnRowCallback' => 'if ( aData[4] == "A" ) { $(\'td:eq(4)\', nRow).html( \'<b>A</b>\' ); } }',
		'fnServerData' => 'oSettings.jqXHR = $.ajax( { "dataType": \'json\', "type": "POST","url": sSource, "data": aoData, "success": fnCallback } );',
		'fnServerParams' => '"fnServerParams": function ( aoData ) { aoData.push( { "name": "more_data", "value": "my_value" } ); }',
		'fnStateLoad' => 'var o; $.ajax( { "url": "/state_load", "async": false, "dataType": "json", "success": function (json) { o = json; } } ); return o;',
		'fnStateLoadParams' => 'oData.oSearch.sSearch = "";',
		'fnStateLoaded' => 'alert( \'Saved filter was: \'+oData.oSearch.sSearch );',
		'fnStateSave' => '$.ajax( { "url": "/state_save", "data": oData, "dataType": "json", "method": "POST" "success": function () {} } );',
		'fnStateSaveParams' => 'oData.oSearch.sSearch = "";',
		'aoColumnDefs' => '{ "aDataSort": [ 0, 1 ], "aTargets": [ 0 ] }, { "aDataSort": [ 1, 0 ], "aTargets": [ 1 ] }, { "aDataSort": [ 2, 3, 4 ], "aTargets": [ 2 ] }',
		'aoColumns' => '{ "aDataSort": [ 0, 1 ] }, { "aDataSort": [ 1, 0 ] }, { "aDataSort": [ 2, 3, 4 ] }, null, null',
	);
		
	public function testInitialValuesAreCorrect() {
		$dataTables = new DataTables();
		foreach($this->_propertyDefaults as $k => $v) {
			$method = 'get'.ucfirst($k);
			$actual = call_user_func(array($dataTables, $method));
			$this->assertEquals($v, $actual, "'$k' expected initial value '$v'");
		}
	}
	
	public function testFactorySetsValuesCorrectly() {
		$dataTables = DataTables::factory($this->_propertyValues);
		foreach($this->_propertyValues as $k => $v) {
			$method = 'get'.ucfirst($k);
			$actual = call_user_func(array($dataTables, $method));
			$this->assertEquals($v, $actual, "'$k' expected 'v'");
		}
	}
}