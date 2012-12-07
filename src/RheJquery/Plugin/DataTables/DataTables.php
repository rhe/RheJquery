<?php
/**
 * @author Robert Hennig <info@robcoding.de>
 * @copyright Copyright (c) 2012 Robert Hennig <info@robcoding.de>
 */
namespace RheJquery\Plugin\DataTables;

use Zend\Stdlib\ArrayUtils;

/**
 * DataTables server side representation.
 *
 * This represents a data table on the server side and allows to configure
 * all data table options and to build the neccessary HTML and JavaScript.
 *
 * @author Robert Hennig <info@robcoding.de>
 * @copyright Copyright (c) 2012 Robert Hennig <info@robcoding.de>
 */
class DataTables {
	/**
	 * Pagination type two buttons.
	 */
	const PAGINATION_TYPE_TWO_BUTTON = 'two_button';
	
	/**
	 * Pagination type full number.
	 */
	const PAGINATION_TYPE_FULL_NUMBERS = 'full_numbers';
	
	/**
	 * Server method 'GET'.
	 */
	const SERVER_METHOD_GET = 'GET';
	
	/**
	 * Server method 'POST'.
	 */
	const SERVER_METHOD_POST = 'POST';
	
	/**
	 * The name of the data table.
	 * 
	 * This is also used for the id within the generated HTML.
	 * 
	 * @var string
	 */
	protected $_name = 'dataTable';
	
	/**
	 * Enables or disables automatic column width calculation.
	 * 
	 * This can be disables as an optimisation (it takes some time to calculate
	 * the widths) if the talbes widths are passed in using aoColumns.
	 * 
	 * @var bool
	 */
	protected $_bAutoWidth = true;
	
	/**
	 * Toggles deferred rendering.
	 * 
	 * Deferred rendering can provide DataTables with a huge speed boost when 
	 * you are using an Ajax or JS data source for the table. This option, 
	 * when set to true, will cause DataTables to defer the creation of the 
	 * table elements for each row until they are needed for a draw - saving a 
	 * significant amount of time.
	 * 
	 * @var bool
	 */
	protected $_bDeferRender = false;
	
	/**
	 * Enable or disable filterning of data.
	 * 
	 * Filtering in DataTables is "smart" in that it allows the end user to 
	 * input multiple words (space separated) and will match a row containing 
	 * those words, even if not in the order that was specified (this allow 
	 * matching across multiple columns). Note that if you wish to use 
	 * filtering in DataTables this must remain 'true' - to remove the default 
	 * filtering input box and retain filtering abilities, please use 
	 * {@link DataTable.defaults.sDom}.
	 * 
	 * @var bool
	 */
	protected $_bFilter = true;
	
	/**
	 * Enable or disable table information display.
	 * 
	 * This shows information about the data that is currently visible on the 
	 * page, including information about filtered data if that action is being 
	 * performed.
	 * 
	 * @var boolean
	 */
	protected $_bInfo = true;
	
	/**
	 * Enable or disable jQuery UI ThemeRoller support.
	 * 
	 * required as ThemeRoller requires some slightly different and 
	 * additional mark-up from what DataTables has traditionally used.
	 * 
	 * @var boolean
	 */
	protected $_bJQueryUI = false;
	
	/**
	 * Enable or disable page size selection.
	 * 
	 * Allows the end user to select the size of a formatted page from a 
	 * select menu (sizes are 10, 25, 50 and 100). 
	 * Requires pagination (bPaginate).
	 * 
	 * @var boolean
	 */
	protected $_bLengthChange = true;
	
	/**
	 * Enable or disable pagination.
	 * 
	 * @var boolean
	 */
	protected $_bPaginate = true;
	
	/**
	 * Enable or disable the display of a 'processing' indicator when the table
	 * is being processed (e.g. a sort).
	 * 
	 * This is particularly useful for tables with large amounts of data where 
	 * it can take a noticeable amount of time to sort the entries.
	 * 
	 * @var boolean
	 */
	protected $_bProcessing = false;
	
	/**
	 * Enable infinite scrolling for DataTables (to be used in combination with 
	 * sScrollY).
	 * 
	 * Infinite scrolling means that DataTables will continually load data as 
	 * a user scrolls through a table, which is very useful for large dataset. 
	 * This cannot be used with pagination, which is automatically disabled. 
	 * Note - the Scroller extra for DataTables is recommended in in preference 
	 * to this option.
	 * 
	 * @var boolean
	 */
	protected $_bScrollInfinite = false;
	
	/**
	 * Configure DataTables to use server-side processing.
	 * 
	 * Note that the sAjaxSource parameter must also be given in order to give 
	 * DataTables a source to obtain the required data for each draw.
	 * 
	 * @var boolean
	 */
	protected $_bServerSide = false;
	
	/**
	 * Enable or disable sorting of columns.
	 * 
	 * Sorting of individual columns can be disabled by the "bSortable" option 
	 * for each column.
	 * 
	 * @var boolean
	 */
	protected $_bSort = true;
	
	/**
	 * Enable or disable the addition of the classes 'sorting_1', 'sorting_2' 
	 * and 'sorting_3' to the columns which are currently being sorted on. 
	 * 
	 * This is presented as a feature switch as it can increase processing time 
	 * (while classes are removed and added) so for large data sets you might 
	 * want to turn this off.
	 * 
	 * @var boolean
	 */
	protected $_bSortClasses = true;
	
	/**
	 * Enable or disable state saving. 
	 * 
	 * When enabled a cookie will be used to save table display information 
	 * such as pagination information, display length, filtering and sorting. 
	 * As such when the end user reloads the page the display display will 
	 * match what thy had previously set up. 
	 * 
	 * @var boolean
	 */
	protected $_bStateSave = false;
	
	/**
	 * Enable horizontal scrolling. 
	 * 
	 * When a table is too wide to fit into a certain layout, or you have a 
	 * large number of columns in the table, you can enable x-scrolling to show 
	 * the table in a viewport, which can be scrolled. This property can be any 
	 * CSS unit, or a number (in which case it will be treated as a pixel 
	 * measurement).
	 * 
	 * @var string
	 */
	protected $_sScrollX = '';
	
	/**
	 * Enable vertical scrolling. 
	 * 
	 * Vertical scrolling will constrain the DataTable to the given height, and 
	 * enable scrolling for any data which overflows the current viewport. This 
	 * can be used as an alternative to paging to display a lot of data in a 
	 * small area (although paging and scrolling can both be enabled at the 
	 * same time). This property can be any CSS unit, or a number (in which 
	 * case it will be treated as a pixel measurement).
	 * 
	 * @var string
	 */
	protected $_sScrollY = '';
	
	/**
	 * Replace a DataTable which matches the given selector and replace it with 
	 * one which has the properties of the new initialisation object passed. 
	 * 
	 * If no table matches the selector, then the new DataTable will be 
	 * constructed as per normal.
	 * 
	 * @var boolean
	 */
	protected $_bDestroy = false;
	
	/**
	 * Retrieve the DataTables object for the given selector. 
	 * 
	 * Note that if the table has already been initialised, this parameter will 
	 * cause DataTables to simply return the object that has already been set 
	 * up - it will not take account of any changes you might have made to the 
	 * initialisation object passed to DataTables (setting this parameter to 
	 * true is an acknowledgement that you understand this). bDestroy can be 
	 * used to reinitialise a table if you need.
	 * 
	 * @var boolean
	 */
	protected $_bRetrieve = false;
	
	/**
	 * Indicate if DataTables should be allowed to set the padding / margin etc 
	 * for the scrolling header elements or not. 
	 * 
	 * Typically you will want this.
	 * 
	 * @var boolean
	 */
	protected $_bScrollAutoCss = true;
	
	/**
	 * When vertical (y) scrolling is enabled, DataTables will force the height 
	 * of the table's viewport to the given height at all times (useful for 
	 * layout). 
	 * 
	 * However, this can look odd when filtering data down to a small data set, 
	 * and the footer is left "floating" further down. This parameter (when 
	 * enabled) will cause DataTables to collapse the table's viewport down 
	 * when the result set will fit within the given Y height.
	 * 
	 * @var boolean
	 */
	protected $_bScrollCollapse = false;
	
	/**
	 * Allows control over whether DataTables should use the top (true) unique 
	 * cell that is found for a single column, or the bottom (false - default). 
	 * 
	 * This is useful when using complex headers.
	 * 
	 * @var boolean
	 */
	protected $_bSortCellsTop = false;
	
	/**
	 * Duration of the cookie which is used for storing session information. 
	 * 
	 * This value is given in seconds.
	 * 
	 * @var integer
	 */
	protected $_iCookieDuration = 7200;
	
	/**
	 * Number of records overall and indicator to defer loading from server.
	 * 
	 * When enabled DataTables will not make a request to the server for the 
	 * first page draw - rather it will use the data already on the page (no 
	 * sorting etc will be applied to it), thus saving on an XHR at load time. 
	 * iDeferLoading is used to indicate that deferred loading is required, but 
	 * it is also used to tell DataTables how many records there are in the 
	 * full table (allowing the information element and pagination to be 
	 * displayed correctly). In the case where a filtering is applied to the 
	 * table on initial load, this can be indicated by giving the parameter as 
	 * an array, where the first element is the number of records available 
	 * after filtering and the second element is the number of records without 
	 * filtering (allowing the table information element to be shown correctly).
	 * 
	 * @var integer
	 */
	protected $_iDeferLoading = null;
	
	/**
	 * Number of rows to display on a single page when using pagination.
	 * 
	 * If feature enabled (bLengthChange) then the end user will be able to 
	 * override this to a custom setting using a pop-up menu.
	 * 
	 * @var integer
	 */
	protected $_iDisplayLength = 10;
	
	/**
	 * Define the starting point for data display when using DataTables with 
	 * pagination. 
	 * 
	 * Note that this parameter is the number of records, rather than the page 
	 * number, so if you have 10 records per page and want to start on the 
	 * third page, it should be "20".
	 * 
	 * @var integer
	 */
	protected $_iDisplayStart = 0;
	
	/**
	 * The scroll gap is the amount of scrolling that is left to go before 
	 * DataTables will load the next 'page' of data automatically. 
	 * 
	 * You typically want a gap which is big enough that the scrolling will be 
	 * smooth for the user, while not so large that it will load more data than 
	 * need.
	 * 
	 * @var integer
	 */
	protected $_iScrollLoadGap = 100;
	
	/**
	 * The tab index.
	 * 
	 * By default DataTables allows keyboard navigation of the table (sorting, 
	 * paging, and filtering) by adding a tabindex attribute to the required 
	 * elements. This allows you to tab through the controls and press the 
	 * enter key to activate them. The tabindex is default 0, meaning that the 
	 * tab follows the flow of the document. You can overrule this using this 
	 * parameter if you wish. Use a value of -1 to disable built-in keyboard 
	 * navigation.
	 * 
	 * @var integer
	 */
	protected $_iTabIndex = 0;
	
	/**
	 * This parameter allows you to have define the global filtering state at 
	 * initialisation time. As an object the "sSearch" parameter must be 
	 * defined, but all other parameters are optional. When "bRegex" is true, 
	 * the search string will be treated as a regular expression, when false 
	 * (default) it will be treated as a straight string. When "bSmart" 
	 * DataTables will use it's smart filtering methods (to word match at any 
	 * point in the data), when false this will not be done.
	 * 
	 * @var string
	 */
	protected $_oSearch = '';
	
	/**
	 * Ajax Data Property.
	 * 
	 * By default DataTables will look for the property 'aaData' when obtaining 
	 * data from an Ajax source or for server-side processing - this parameter 
	 * allows that property to be changed. You can use Javascript dotted object 
	 * notation to get a data source for multiple levels of nesting.
	 * 
	 * @var string
	 */
	protected $_sAjaxDataProp = 'aaData';
	
	/**
	 * Ajax source.
	 * 
	 * You can instruct DataTables to load data from an external source using 
	 * this parameter (use aData if you want to pass data in you already have). 
	 * Simply provide a url a JSON object can be obtained from. This object 
	 * must include the parameter 'aaData' which is the data source for the 
	 * table.
	 * 
	 * @var string
	 */
	protected $_sAjaxSource = null;
	
	/**
	 * This parameter can be used to override the default prefix that 
	 * DataTables assigns to a cookie when state saving is enabled.
	 * 
	 * @var string
	 */
	protected $_sCookiePrefix = 'SpryMedia_DataTables';
	
	/**
	 * This initialisation variable allows you to specify exactly where in the 
	 * DOM you want DataTables to inject the various controls it adds to the 
	 * page (for example you might want the pagination controls at the top of 
	 * the table). DIV elements (with or without a custom class) can also be 
	 * added to aid styling. The follow syntax is used:
	 * 
	 * The following options are allowed:
	 * <ul>
     *   <li>'l' - Length changing</li>
     *   <li>'f' - Filtering input</li>
     *   <li>'t' - The table!</li>
     *   <li>'i' - Information</li>
     *   <li>'p' - Pagination</li>
     *   <li>'r' - pRocessing</li>
     * </ul>
     * The following constants are allowed:
     * <ul>
     *   <li>
     *   	'H' - jQueryUI theme "header" classes ('fg-toolbar ui-widget-header 
     *   	ui-corner-tl ui-corner-tr ui-helper-clearfix')
     *   </li>
     *   <li>
     *   	'F' - jQueryUI theme "footer" classes ('fg-toolbar ui-widget-header 
     *   	ui-corner-bl ui-corner-br ui-helper-clearfix')
     *   </li>
     * </ul>
     * The following syntax is expected:
     * <ul>
     *   <li>'<' and '>' - div elements</li>
     *   <li>'<"class" and '>' - div with a class</li>
     *   <li>'<"#id" and '>' - div with an ID</li>
     * </ul>
     * Examples:
     * <ul>
     *   <li><"wrapper"flipt>'</li>
     *   <li>'ip>'</li>
     * </ul>
	 * @var string
	 */
	protected $_sDom = 'lfrtip';
	
	/**
	 * Pagination interaction method.
	 * 
	 * DataTables features two different built-in pagination interaction 
	 * methods ('twobutton' or 'fullnumbers') which present different page 
	 * controls to the end user. Further methods can be added using the API 
	 * (see below).
	 * 
	 * @var string
	 */
	protected $_sPaginationType = self::PAGINATION_TYPE_TWO_BUTTON;
	
	/**
	 * This property can be used to force a DataTable to use more width than it 
	 * might otherwise do when x-scrolling is enabled. 
	 * 
	 * For example if you have a table which requires to be well spaced, this 
	 * parameter is useful for "over-sizing" the table, and thus forcing 
	 * scrolling. This property can by any CSS unit, or a number (in which case 
	 * it will be treated as a pixel measurement).
	 * 
	 * @var string
	 */
	protected $_sScrollXInner = '';
	
	/**
	 * Set the HTTP method that is used to make the Ajax call for server-side 
	 * processing or Ajax sourced data.
	 * 
	 * @var string
	 */
	protected $_sServerMethod = self::SERVER_METHOD_GET;
	
	/**
	 * Customise the cookie and / or the parameters being stored when using 
	 * DataTables with state saving enabled. 
	 * 
	 * This function is called whenever the cookie is modified, and it expects 
	 * a fully formed cookie string to be returned. Note that the data object 
	 * passed in is a Javascript object which must be converted to a string 
	 * (JSON.stringify for example).
	 * 
	 * @var string
	 */
	protected $_fnCookieCallback = '';
	
	/**
	 * This function is called when a TR element is created (and all TD child 
	 * elements have been inserted), or registered if using a DOM source, 
	 * allowing manipulation of the TR element (adding classes etc).
	 * 
	 * @var string
	 */
	protected $_fnCreatedRow = '';
	
	/**
	 * This function is called on every 'draw' event, and allows you to 
	 * dynamically modify any aspect you want about the created DOM.
	 * 
	 * @var string
	 */
	protected $_fnDrawCallback = '';
	
	/**
	 * Identical to fnHeaderCallback() but for the table footer this function 
	 * allows you to modify the table footer on every 'draw' even.
	 * 
	 * @var string
	 */
	protected $_fnFooterCallback = '';
	
	/**
	 * When rendering large numbers in the information element for the table 
	 * (i.e. "Showing 1 to 10 of 57 entries") DataTables will render large 
	 * numbers to have a comma separator for the 'thousands' units (e.g. 1 
	 * million is rendered as "1,000,000") to help readability for the end 
	 * user. This function will override the default method DataTables uses.
	 * 
	 * @var string
	 */
	protected $_fnFormatNumber = '';
	
	/**
	 * This function is called on every 'draw' event, and allows you to 
	 * dynamically modify the header row. This can be used to calculate and 
	 * display useful information about the table.
	 * 
	 * @var string
	 */
	protected $_fnHeaderCallback = '';
	
	/**
	 * The information element can be used to convey information about the 
	 * current state of the table. 
	 * 
	 * Although the internationalisation options presented by DataTables are 
	 * quite capable of dealing with most customisations, there may be times 
	 * where you wish to customise the string further. This callback allows you 
	 * to do exactly that.
	 * 
	 * @var string
	 */
	protected $_fnInfoCallback = '';
	
	/**
	 * Called when the table has been initialised. 
	 * 
	 * Normally DataTables will initialise sequentially and there will be no 
	 * need for this function, however, this does not hold true when using 
	 * external language information since that is obtained using an async 
	 * XHR call.
	 * 
	 * @var string
	 */
	protected $_fnInitComplete = '';
	
	/**
	 * Called at the very start of each table draw and can be used to cancel 
	 * the draw by returning false, any other return (including undefined) 
	 * results in the full draw occurring).
	 * 
	 * @var string
	 */
	protected $_fnPreDrawCallback = '';
	
	/**
	 * This function allows you to 'post process' each row after it have been 
	 * generated for each table draw, but before it is rendered on screen. 
	 * 
	 * This function might be used for setting the row class name etc.
	 * 
	 * @var string
	 */
	protected $_fnRowCallback = '';
	
	/**
	 * This parameter allows you to override the default function which obtains 
	 * the data from the server ($.getJSON) so something more suitable for your 
	 * application. For example you could use POST data, or pull information 
	 * from a Gears or AIR database.
	 * 
	 * @var string
	 */
	protected $_fnServerData = '';
	
	/**
	 * It is often useful to send extra data to the server when making an Ajax 
	 * request - for example custom filtering information, and this callback 
	 * function makes it trivial to send extra information to the server. 
	 * The passed in parameter is the data set that has been constructed by 
	 * DataTables, and you can add to this or modify it as you require.
	 * 
	 * @var string
	 */
	protected $_fnServerParams = '';
	
	/**
	 * Load the table state. 
	 * 
	 * With this function you can define from where, and how, the state of a 
	 * table is loaded. By default DataTables will load from its state saving 
	 * cookie, but you might wish to use local storage (HTML5) or a server-side 
	 * database.
	 * 
	 * @var string
	 */
	protected $_fnStateLoad = '';
	
	/**
	 * Callback which allows modification of the saved state prior to loading 
	 * that state. 
	 * 
	 * This callback is called when the table is loading state from the stored 
	 * data, but prior to the settings object being modified by the saved 
	 * state. Note that for plug-in authors, you should use the 
	 * 'stateLoadParams' event to load parameters for a plug-in.
	 * 
	 * @var string
	 */
	protected $_fnStateLoadParams = '';
	
	/**
	 * Callback that is called when the state has been loaded from the state 
	 * saving method and the DataTables settings object has been modified as a 
	 * result of the loaded state.
	 * 
	 * @var string
	 */
	protected $_fnStateLoaded = '';
	
	/**
	 * Save the table state. 
	 * 
	 * This function allows you to define where and how the state information 
	 * for the table is stored - by default it will use a cookie, but you might 
	 * want to use local storage (HTML5) or a server-side database.
	 * 
	 * @var string
	 */
	protected $_fnStateSave = '';
	
	/**
	 * Callback which allows modification of the state to be saved. 
	 * 
	 * Called when the table has changed state a new state save is required. 
	 * This method allows modification of the state saving object prior to 
	 * actually doing the save, including addition or other state properties or 
	 * modification. Note that for plug-in authors, you should use the 
	 * 'stateSaveParams' event to save parameters for a plug-in.
	 * 
	 * @var string
	 */
	protected $_fnStateSaveParams = '';
	
	/**
	 * This array allows you to target a specific column, multiple columns, or 
	 * all columns, using the aTargets property of each object in the array 
	 * (please note that aoColumnDefs was introduced in DataTables 1.7). 
	 * 
	 * This allows great flexibility when creating tables, as the aoColumnDefs 
	 * arrays can be of any length, targeting the columns you specifically 
	 * want. The aTargets property is an array to target one of many columns 
	 * and each element in it can be:
	 * <ul>
	 *   <li>a string - class name will be matched on the TH for the column</li>
	 *   <li>0 or a positive integer - column index counting from the left</li>
	 *   <li>a negative integer - column index counting from the right</li>
	 *   <li>the string "_all" - all columns (i.e. assign a default)</li>
	 * </ul>
	 * Example:
	 * <code>
	 * "aoColumnDefs": [
	 *   { "aDataSort": [ 0, 1 ], "aTargets": [ 0 ] },
     *   { "aDataSort": [ 1, 0 ], "aTargets": [ 1 ] },
     *   { "aDataSort": [ 2, 3, 4 ], "aTargets": [ 2 ] }
	 * ]
	 * </code>
	 * 
	 * @var string
	 */
	protected $_aoColumnDefs = '';
	
	/**
	 * If specified, then the length of this array must be equal to the number 
	 * of columns in the original HTML table. Use 'null' where you wish to use 
	 * only the default values and automatically detected options.
	 * 
	 * Example using aDataSort to sort multiple columns:
	 * <code>
	 * "aoColumns": [
	 *   { "aDataSort": [ 0, 1 ] },
	 *   { "aDataSort": [ 1, 0 ] },
	 *   { "aDataSort": [ 2, 3, 4 ] },
	 *   null,
	 *   null
	 * ]
	 * </code>
	 * @var string
	 */
	protected $_aoColumns = '';
	
	/**
	 * Returns the name of the data table.
	 * 
	 * @return string
	 */
	public function getName() {
		return $this->_name;
	}
	
	/**
	 * Set the name of the table.
	 * 
	 * @param string $name
	 */
	public function setName($name) {
		$this->_name = $name;
	}
	
	/**
	 * Returns if automatic column width calculation is active or not.
	 * 
	 * @see $_bAutoWidth
	 * @return bool
	 */
	public function getBAutoWidth() {
		return $this->_bAutoWidth;
	}
	
	/**
	 * Set if automatic column width calculation is active or not.
	 * 
	 * @see $_bAutoWidth
	 * @param bool $bAutoWidth
	 */
	public function setBAutoWidth($bAutoWidth) {
		$this->_bAutoWidth = $bAutoWidth;
	}
	
	/**
	 * Returns defered rendering setting.
	 * 
	 * @see $_bDeferRender
	 * @return boolean
	 */
	public function getBDeferRender() {
		return $this->_bDeferRender;
	}
	
	/**
	 * Set defered rendering status.
	 * 
	 * @see $_bDeferRender
	 * @param bool $bDeferRender
	 */
	public function setBDeferRender($bDeferRender) {
		$this->_bDeferRender = $bDeferRender;
	}
	
	/**
	 * Returns wheter filtering is enabled or disabled.
	 * 
	 * @see $_bFilter
	 * @return boolean
	 */
	public function getBFilter() {
		return $this->_bFilter;
	}
	
	/**
	 * Sets whether filtering is disabled or enabled.
	 * 
	 * @see $_bFilter
	 * @param boolean $bFilter
	 */
	public function setBFilter($bFilter) {
		$this->_bFilter = $bFilter;
	}
	
	/**
	 * Returns whether table information is displayed or not.
	 * 
	 * @see $_bInfo
	 * @return boolean
	 */
	public function getBInfo() {
		return $this->_bInfo;
	}
	
	/**
	 * Sets whether table information is displayed or not.
	 * 
	 * @see $_bInfo
	 * @param boolean $bInfo
	 */
	public function setBInfo($bInfo) {
		$this->_bInfo = $bInfo;
	}
	
	/**
	 * Returns whehter jQuery ThemeRoller support is enabled or disabled.
	 * 
	 * @see $_bJQueryUI
	 * @return boolean
	 */
	public function getBJQueryUI() {
		return $this->_bJQueryUI;
	}
	
	/**
	 * Sets whether jQuery ThemeRoller support is enabled or disabled.
	 * 
	 * @see $_bJQueryUI
	 * @param boolean $bJQueryUI
	 */
	public function setBJQueryUI($bJQueryUI) {
		if($bJQueryUI == true) {
			if($this->getSDom() == '' || $this->getSDom() == 'lfrtip') {
				$this->setSDom('<"H"lfr>t<"F"ip>');
			}
		} else {
			if($this->getSDom() == '' || $this->getSDom() == '<"H"lfr>t<"F"ip>') {
				$this->setSDom('lfrtip');
			}
		}
		$this->_bJQueryUI = $bJQueryUI;
	}
	
	/**
	 * Returns whether page size selection is enabled or disabled.
	 * 
	 * @see $_bLenghtChange
	 * @return boolean
	 */
	public function getBLengthChange() {
		return $this->_bLengthChange;
	}
	
	/**
	 * Sets whether page size selection is enabled or disabled.
	 * 
	 * @see $_bLengthChange
	 * @param boolean $bLengthChange
	 */
	public function setBLengthChange($bLengthChange) {
		$this->_bLengthChange = $bLengthChange;
	}
	
	/**
	 * Returns whether paginatio is enabled or disabled.
	 * 
	 * @see $_bPaginate
	 * @return boolean
	 */
	public function getBPaginate() {
		return $this->_bPaginate;
	}
	
	/**
	 * Sets whether pagination is enabled or disabled.
	 * 
	 * @see $_bPaginate
	 * @param boolean $bPaginate
	 */
	public function setBPaginate($bPaginate) {
		$this->_bPaginate = $bPaginate;
	}
	
	/**
	 * Returns whether display of a 'processing' indicator is enabled or 
	 * disabled.
	 * 
	 * @see $_bProcessing
	 * @return boolean
	 */
	public function getBProcessing() {
		return $this->_bProcessing;
	}
	
	/**
	 * Sets whether display of a 'processing' indicator is enabled or disabled.
	 * 
	 * @see $_bProcessing
	 * @param boolean $bProcessing
	 */
	public function setBProcessing($bProcessing) {
		$this->_bProcessing = $bProcessing;
	}
	
	/**
	 * Returns whether infinite scrolling is enabled or disabled.
	 * 
	 * @see $_bScrollInfinite
	 * @return boolean
	 */
	public function getBScrollInfinite() {
		return $this->_bScrollInfinite;
	}
	
	/**
	 * Sets whether infinite scrolling is enabled or disabled.
	 * 
	 * @see $_bScrollInfinite
	 * @param boolean $bScrollInfinite
	 */
	public function setBScrollInfinite($bScrollInfinite) {
		$this->_bScrollInfinite = $bScrollInfinite;
	}
	
	/**
	 * Returns whether server-side processing is enabled or disabled.
	 * 
	 * @see $_bServerSide
	 * @return boolean
	 */
	public function getBServerSide() {
		return $this->_bServerSide;
	}
	
	/**
	 * Sets whether server-side processing is enabled or disabled.
	 * 
	 * @see $_bServerSide
	 * @param boolean $bServerSide
	 */
	public function setBServerSide($bServerSide) {
		$this->_bServerSide = $bServerSide;
	}
	
	/**
	 * Returns whether sorting of columns is enabled or disabled.
	 * 
	 * @see $_bSort
	 * @return boolean
	 */
	public function getBSort() {
		return $this->_bSort;
	}
	
	/**
	 * Sets whether sorting of columns is enabled or disabled.
	 * 
	 * @see $_bSort
	 * @param boolean $bSort
	 */
	public function setBSort($bSort) {
		$this->_bSort = $bSort;
	}
	
	/**
	 * Returns whether addition of the sorting classes is enabled or disabled.
	 * 
	 * @see $_bSortClasses
	 * @return boolean
	 */
	public function getBSortClasses() {
		return $this->_bSortClasses;
	}
	
	/**
	 * Sets whether addition of the sorting classes is disabled or enabled.
	 * 
	 * @see $_bSortClasses
	 * @param boolean $bSortClasses
	 */
	public function setBSortClasses($bSortClasses) {
		$this->_bSortClasses = $bSortClasses;
	}

	/**
	 * Returns whether state saving is enabled or disabled.
	 * 
	 * @see $_bStateSave
	 * @return boolean
	 */
	public function getBStateSave() {
		return $this->_bStateSave;
	}
	
	/**
	 * Sets whether state saving is enabled or disabled.
	 * 
	 * @see $_bStateSave
	 * @param boolean $bStateSave
	 */
	public function setBStateSave($bStateSave) {
		$this->_bStateSave = $bStateSave;
	}
	
	/**
	 * Returns the horizontal scrolling setting.
	 * 
	 * @see $_sScrollX
	 * @return string
	 */
	public function getSScrollX() {
		return $this->_sScrollX;
	}
	
	/**
	 * Set the horizontal scrolling setting.
	 * 
	 * @see $_sScrollX
	 * @param string $sScrollX
	 */
	public function setSScrollX($sScrollX) {
		$this->_sScrollX = $sScrollX;
	}
	
	/**
	 * Returns the vertical scrolling setting.
	 * 
	 * @see $_sScrollY
	 * @return string
	 */
	public function getSScrollY() {
		return $this->_sScrollY;
	}

	/**
	 * Sets the vertical scrolling setting.
	 * 
	 * @see $_sScrollY
	 * @param string $sScrollY
	 */
	public function setSScrollY($sScrollY) {
		$this->_sScrollY = $sScrollY;
	}
	
	/**
	 * Returns whether data table replacement is enabled or disabled.
	 * 
	 * @see $_bDestroy
	 * @return boolean
	 */
	public function getBDestroy() {
		return $this->_bDestroy;
	}
	
	/**
	 * Sets whether data table replacement is enabled or disabled.
	 * 
	 * @see $_bDestroy
	 * @param boolean $bDestroy
	 */
	public function setBDestroy($bDestroy) {
		$this->_bDestroy = $bDestroy;
	}
	
	/**
	 * Returns whether retrieval of the DataTables object is enabled or 
	 * disabled.
	 * 
	 * @see $_bRetrieve
	 * @return boolean
	 */
	public function getBRetrieve() {
		return $this->_bRetrieve;
	}
	
	/**
	 * Sets whether retrieval of the DataTables object is enabled or disabled.
	 * 
	 * @see $_bRetrieve
	 * @param boolean $bRetrieve
	 */
	public function setBRetrieve($bRetrieve) {
		$this->_bRetrieve = $bRetrieve;
	}
	
	/**
	 * Returns if DataTables should be allowed to set the padding / margin etc 
	 * for the scrolling header elements or not.
	 * 
	 * @see $_bScrollAutoCss
	 * @return boolean
	 */
	public function getBScrollAutoCss() {
		return $this->_bScrollAutoCss;
	}
	
	/**
	 * Sets if DataTables should be allowed to set the padding / margin etc 
	 * for the scrolling header elements or not.
	 * 
	 * @see $_bScrollAutoCss
	 * @param boolean $bScrollAutoCss
	 */
	public function setBScrollAutoCss($bScrollAutoCss) {
		$this->_bScrollAutoCss = $bScrollAutoCss;
	}
	
	/**
	 * Returns whether to collapse viewport or not.
	 * 
	 * @see $_bScrollCollapse
	 * @return boolean
	 */
	public function getBScrollCollapse() {
		return $this->_bScrollCollapse;
	}
	
	/**
	 * Sets whether to collapse viewport or not.
	 * 
	 * @see $_bScrollCollapse
	 * @param boolean $bScrollCollapse
	 */
	public function setBScrollCollapse($bScrollCollapse) {
		$this->_bScrollCollapse = $bScrollCollapse;
	}
	
	/**
	 * Returns whether top or bottom cells should be used for the header.
	 * 
	 * @see $_bSortCellsTop
	 * @return boolean
	 */
	public function getBSortCellsTop() {
		return $this->_bSortCellsTop;
	}
	
	/**
	 * Sets whether top or bottom cells should be used for the header.
	 * 
	 * @see $_bSortCellsTop
	 * @param boolen $bSortCellsTop
	 */
	public function setBSortCellsTop($bSortCellsTop) {
		$this->_bSortCellsTop = $bSortCellsTop;
	}
	
	/**
	 * Returns session cookie duration.
	 * 
	 * @see $_iCookieDuration
	 * @return integer
	 */
	public function getICookieDuration() {
		return $this->_iCookieDuration;
	}
	
	/**
	 * sets session cookie duration.
	 * 
	 * @see $_iCookieDuration
	 * @param integer $iCookieDuration
	 */
	public function setICookieDuration($iCookieDuration) {
		$this->_iCookieDuration = $iCookieDuration;
	}
	
	/**
	 * Returns number of total records if loading from server is defered.
	 * 
	 * @see $_iDeferLoading
	 * @return integer
	 */
	public function getIDeferLoading() {
		return $this->_iDeferLoading;
	}
	
	/**
	 * Set number of total records and to defer loading from server.
	 * 
	 * @see $_iDeferLoading
	 * @param integer $iDeferLoading
	 */
	public function setIDeferLoading($iDeferLoading) {
		$this->_iDeferLoading = $iDeferLoading;
	}
	
	/**
	 * Returns number of rows to display on a single page when using pagination.
	 * 
	 * @see $_iDisplayLength
	 * @return integer
	 */
	public function getIDisplayLength() {
		return $this->_iDisplayLength;
	}
	
	/**
	 * Sets number of rows to display on a single page when using pagination.
	 * 
	 * @see $_iDisplayLength
	 * @param integer $iDisplayLength
	 */
	public function setIDisplayLength($iDisplayLength) {
		$this->_iDisplayLength = $iDisplayLength;
	}
	
	/**
	 * Returns the starting point for data display when using pagination.
	 * 
	 * @see $_iDisplayStart
	 * @return integer
	 */
	public function getIDisplayStart() {
		return $this->_iDisplayStart;
	}
	
	/**
	 * Sets the starting point for data display when using pagination.
	 * 
	 * @see $_iDisplayStart
	 * @param integer $iDisplayStart
	 */
	public function setIDisplayStart($iDisplayStart) {
		$this->_iDisplayStart = $iDisplayStart;
	}
	
	/**
	 * Returns the scroll gap.
	 * 
	 * @see $_iScrollLoadGap
	 * @return integer
	 */
	public function getIScrollLoadGap() {
		return $this->_iScrollLoadGap;
	}
	
	/**
	 * Sets the scroll load gap.
	 * 
	 * @see $_iScrollLoadGap
	 * @param integer $iScrollLoadGap
	 */
	public function setIScrollLoadGap($iScrollLoadGap) {
		$this->_iScrollLoadGap = $iScrollLoadGap;
	}
	
	/**
	 * Returns the tab index.
	 * 
	 * @see $_iTabIndex
	 * @return integer
	 */
	public function getITabIndex() {
		return $this->_iTabIndex;
	}
	
	/**
	 * Sets the tab index.
	 * 
	 * @see $_iTabIndex
	 * @param integer $iTabIndex
	 */
	public function setITabIndex($iTabIndex) {
		$this->_iTabIndex = $iTabIndex;
	}
	
	/**
	 * Returns global filtering state at initialization.
	 * 
	 * @see $_oSearch
	 * @return string
	 */
	public function getOSearch() {
		return $this->_oSearch;
	}
	
	/**
	 * Sets the global filtering state at initialization.
	 * 
	 * @see $_oSearch
	 * @param string $oSearch
	 */
	public function setOSearch($oSearch) {
		$this->_oSearch = $oSearch;
	}
	
	/**
	 * Returns the Ajax data property.
	 * 
	 * @see $_sAjaxDataProp
	 * @return string
	 */
	public function getSAjaxDataProp() {
		return $this->_sAjaxDataProp;
	}
	
	/**
	 * Sets the Ajax data property.
	 * 
	 * @see $_sAjaxDataProp
	 * @param string $sAjaxDataProp
	 */
	public function setSAjaxDataProp($sAjaxDataProp) {
		$this->_sAjaxDataProp = $sAjaxDataProp;
	}
	
	/**
	 * Returns the Ajax source.
	 * 
	 * @see $_sAjaxSource
	 * @return string
	 */
	public function getSAjaxSource() {
		return $this->_sAjaxSource;
	}
	
	/**
	 * Sets the Ajax source.
	 * 
	 * @see $_sAjaxSource
	 * @param string $sAjaxSource
	 */
	public function setSAjaxSource($sAjaxSource) {
		$this->_sAjaxSource = $sAjaxSource;
	}
	
	/**
	 * Returns the cookie prefix.
	 * 
	 * @see $_sCookiePrefix
	 * @return string
	 */
	public function getSCookiePrefix() {
		return $this->_sCookiePrefix;
	}
	
	/**
	 * Sets the cookie prefix.
	 * 
	 * @see $_sCookiePrefix
	 * @param string $sCookiePrefix
	 */
	public function setSCookiePrefix($sCookiePrefix) {
		$this->_sCookiePrefix = $sCookiePrefix;
	}
	
	/**
	 * Returns where in the dom to inject the controls.
	 * 
	 * @see $_sDom
	 * @return string
	 */
	public function getSDom() {
		return $this->_sDom;
	}
	
	/**
	 * Sets where in the dom to inject the controls.
	 * 
	 * @see $_sDom
	 * @param string $sDom
	 */
	public function setSDom($sDom) {
		$this->_sDom = $sDom;
	}
	
	/**
	 * Returns pagination interaction method.
	 * 
	 * @see $_sPaginationType
	 * @return string
	 */
	public function getSPaginationType() {
		return $this->_sPaginationType;
	}
	
	/**
	 * Sets the pagination interaction method.
	 * 
	 * @see $_sPaginationType
	 * @param string $sPaginationType
	 */
	public function setSPaginationType($sPaginationType) {
		$this->_sPaginationType = $sPaginationType;
	}
	
	/**
	 * Returns X Scrolling width.
	 * 
	 * @see $_sScrollXInner
	 * @return string
	 */
	public function getSScrollXInner() {
		return $this->_sScrollXInner;
	}
	
	/**
	 * Sets the X Scrolling width.
	 * 
	 * @see $_sScrollXInner
	 * @param string $sScrollXInner
	 */
	public function setSScrollXInner($sScrollXInner) {
		$this->_sScrollXInner = $sScrollXInner;
	}
	
	/**
	 * Returns the request method used by the Ajax call.
	 * 
	 * @see $_sServerMethod
	 * @return string
	 */
	public function getSServerMethod() {
		return $this->_sServerMethod;
	}
	
	/**
	 * Sets the request method used by the Ajax call.
	 * 
	 * @see $_sServerMethod
	 * @param string $sServerMethod
	 */
	public function setSServerMethod($sServerMethod) {
		$this->_sServerMethod = $sServerMethod;
	}
	
	/**
	 * Returns the function body of the callback to customize the cookie.
	 * 
	 * @see $_fnCookieCallback
	 * @return string
	 */
	public function getFnCookieCallback() {
		return $this->_fnCookieCallback;
	}
	
	/**
	 * Sets the function body of the callback to customize the cookie.
	 * 
	 * @see $_fnCookieCallback
	 * @param string $fnCookieCallback
	 */
	public function setFnCookieCallback($fnCookieCallback) {
		$this->_fnCookieCallback = $fnCookieCallback;
	}
	
	/**
	 * Returns the function body of the callback executed after a record has 
	 * been created.
	 * 
	 * @see $_fnCreatedRow
	 * @return string
	 */
	public function getFnCreatedRow() {
		return $this->_fnCreatedRow;
	}
	
	/**
	 * Sets the function body of the callback executed after a record has been
	 * added.
	 * 
	 * @see $_fnCreatedRow
	 * @param string $fnCreatedRow
	 */
	public function setFnCreatedRow($fnCreatedRow) {
		$this->_fnCreatedRow = $fnCreatedRow;
	}
	
	/**
	 * Returns the function body of the callback executed on every 'draw' event.
	 * 
	 * @see $_fnDrawCallback
	 * @return string
	 */
	public function getFnDrawCallback() {
		return $this->_fnDrawCallback;
	}
	
	/**
	 * Sets the function body of the callback executed on every 'draw' event.
	 * 
	 * @see $_fnDrawCallback
	 * @parameter string $fnDrawCallback
	 */
	public function setFnDrawCallback($fnDrawCallback) {
		$this->_fnDrawCallback = $fnDrawCallback;
	}
	
	/**
	 * Returns the function body of the callback executed on every 'draw' event 
	 * that allows to modify the footer row.
	 * 
	 * @see $_fnFooterCallback
	 * @return string
	 */
	public function getFnFooterCallback() {
		return $this->_getFnFooterCallback();
	}
	
	/**
	 * Sets the function body of the callback executed on every 'draw' event 
	 * that allows to modify the footer row.
	 * 
	 * @see $_fnFooterCallback
	 * @param string $fnFooterCallback
	 */
	public function setFnFooterCallback($fnFooterCallback) {
		$this->_fnFooterCallback = $fnFooterCallback;
	}
	
	/**
	 * Returns the function body of the method used to format numbers.
	 * 
	 * @see $_fnFormatNumber
	 * @return string
	 */
	public function getFnFormatNumber() {
		return $this->_fnFormatNumber;
	}
	
	/**
	 * Sets the function body of the method used to format numbers.
	 * 
	 * @see $_fnFormatNumber
	 * @param string $fnFormatNumber
	 */
	public function setFnFormatNumber($fnFormatNumber) {
		$this->_fnFormatNumber = $fnFormatNumber;
	}
	
	/**
	 * Returns the function body of the callback executed on every 'draw' event
	 * that allows to modify the header row.
	 * 
	 * @see $_fnHeaderCallback
	 * @return string
	 */
	public function getFnHeaderCallback() {
		return $this->_fnHeaderCallback;
	}
	
	/**
	 * Sets the function body of the callback executed on every 'draw' event
	 * that allows to modify the header row.
	 * 
	 * @see $_fnHeaderCallback
	 * @param string $fnHeaderCallback
	 */
	public function setFnHeaderCallback($fnHeaderCallback) {
		$this->_fnHeaderCallback = $fnHeaderCallback;
	}
	
	/**
	 * Returns the function body of the callback executed that allows to modify
	 * the table information.
	 * 
	 * @see $_fnInfoCallback
	 * @return string
	 */
	public function getFnInfoCallback() {
		return $this->_fnInfoCallback;
	}
	
	/**
	 * Sets the function body of the callback executed that allows to modify the
	 * table information.
	 * 
	 * @see $_fnInfoCallback
	 * @param string $fnInfoCallback
	 */
	public function setFnInfoCallback($fnInfoCallback) {
		$this->_fnInfoCallback = $fnInfoCallback;
	}
	
	/**
	 * Returns the function body of the callback executed after table 
	 * initalisation.
	 * 
	 * @see $_fnInitComplete
	 * @return string
	 */
	public function getFnInitComplete() {
		return $this->_fnInitComplete;
	}
	
	/**
	 * Sets the function body of the callback executed after table initalisation.
	 * 
	 * @see $_fnInitComplete
	 * @param string $fnInitComplete
	 */
	public function setFnInitComplete($fnInitComplete) {
		$this->_fnInitComplete = $fnInitComplete;
	}
	
	/**
	 * Returns the function body of the callback executed at the very start of
	 * each table.
	 * 
	 * @see $_fnPreDrawCallback
	 * @return string
	 */
	public function getFnPreDrawCallback() {
		return $this->_fnPreDrawCallback;
	}
	
	/**
	 * Sets the function body of the callback executed at the very start of
	 * each table.
	 * 
	 * @see $_fnPreDrawCallback
	 * @param string $fnPreDrawCallback
	 */
	public function setFnPreDrawCallback($fnPreDrawCallback) {
		$this->_fnPreDrawCallback = $fnPreDrawCallback;
	}
	
	/**
	 * Returns the function body of the callback executed after each row.
	 * 
	 * @see $_fnRowCallback
	 * @return string
	 */
	public function getFnRowCallback() {
		return $this->_fnRowCallback;
	}
	
	/**
	 * Set sthe function body of the callback executed after each row.
	 * 
	 * @see $_fnRowCallback
	 * @param string $fnRowCallback
	 */
	public function setFnRowCallback($fnRowCallback) {
		$this->_fnRowCallback = $fnRowCallback;
	}
	
	/**
	 * Returns the function body of the function used to overwrite the server
	 * data handling.
	 * 
	 * @see $_fnServerData
	 * @return string
	 */
	public function getFnServerData() {
		return $this->_fnServerData;
	}
	
	/**
	 * Sets the function body of the function used to overwrite the server data
	 * handling.
	 * 
	 * @see $_fnServerData
	 * @param string $fnServerData
	 */
	public function setFnServerData($fnServerData) {
		$this->_fnServerData = $fnServerData;
	}
	
	/**
	 * Returns the function body of the callback that allows to modify the 
	 * data send to the server.
	 * 
	 * @see $_fnServerParams
	 * @return string
	 */
	public function getFnServerParams() {
		return $this->_fnServerParams;
	}
	
	/**
	 * Sets the function body of the callback that allows to modify the data
	 * send to the server.
	 * 
	 * @see $_fnServerParams
	 * @param string $fnServerParams
	 */
	public function setFnServerParams($fnServerParams) {
		$this->_fnServerParams = $fnServerParams;
	}
	
	/**
	 * Returns the function body of the callback that allows to specify from
	 * where and how the table state is being loaded.
	 * 
	 * @see $_fnStateLoad
	 * @return string
	 */
	public function getFnStateLoad() {
		return $this->_fnStateLoad;
	}
	
	/**
	 * Sets the function body of the callback that allows to specify from where
	 * and how the table state is being loaded.
	 * 
	 * @see $_fnStateLoad
	 * @param string $fnStateLoad
	 */
	public function setFnStateLoad($fnStateLoad) {
		$this->_fnStateLoad = $fnStateLoad;
	}
	
	/**
	 * Returns the function body of the callback that allows modification of 
	 * the saved state prior to loading the state.
	 * 
	 * @see $_fnStateLoadParams
	 * @return string
	 */
	public function getFnStateLoadParams() {
		return $this->_fnStateLoadParams;
	}
	
	/**
	 * Sets the function body of the callback that allows modification of the
	 * saved state prior to loading the state.
	 * 
	 * @see $_fnStateLoadParams
	 * @param string $fnStateLoadParams
	 */
	public function setFnStateLoadParams($fnStateLoadParams) {
		$this->_fnStateLoadParams = $fnStateLoadParams;
	}
	
	/**
	 * Returns the function body of the callback that is executed when the
	 * state has been loaded and data table settings have been modified.
	 * 
	 * @see $_fnStateLoaded
	 * @return string
	 */
	public function getFnStateLoaded() {
		return $this->_fnStateLoaded;
	}
	
	/**
	 * Sets the function body of the callback that is executed when the state
	 * has been loaded and data table settings have been modified.
	 * 
	 * @see $_fnStateLoaded
	 * @param string $fnStateLoaded
	 */
	public function setFnStateLoaded($fnStateLoaded) {
		$this->_fnStateLoaded = $fnStateLoaded;
	}
	
	/**
	 * Returns the function body of the function that allows to define how and
	 * where to save the table state.
	 * 
	 * @see $_fnStateSave
	 * @return string
	 */
	public function getFnStateSave() {
		return $this->_fnStateSave;
	}
	
	/**
	 * Sets the function body of the function that allows to define how and 
	 * where to save the table state.
	 * 
	 * @see $_fnStateSave
	 * @param string $fnStateSave
	 */
	public function setFnStateSave($fnStateSave) {
		$this->_fnStateSave = $fnStateSave;
	}
	
	/**
	 * Returns the function body of the callback that allows modification of the
	 * table state to be saved.
	 * 
	 * @see $_fnStateSaveParams
	 * @return string
	 */
	public function getFnStateSaveParams() {
		return $this->_fnStateSaveParams;
	}
	
	/**
	 * Sets the function body of the callback that allows modification of the 
	 * table state to be saved.
	 * 
	 * @see $_fnStateSaveParams
	 * @param string $fnStateSaveParams
	 */
	public function setFnStateSaveParams($fnStateSaveParams) {
		$this->_fnStateSaveParams = $fnStateSaveParams;
	}
	
	/**
	 * Returns aoColumnDefs setting.
	 * 
	 * @see $_aoColumnDefs
	 * @return string
	 */
	public function getAoColumnDefs() {
		return $this->_aoColumnDefs;
	}
	
	/**
	 * Set aoColumnDefs settings.
	 * 
	 * @see $_aoColumnDefs
	 * @param string $aoColumnDefs
	 */
	public function setAoColumnDefs($aoColumnDefs) {
		$this->_aoColumnDefs = $aoColumnDefs;
	}
	
	/**
	 * Returns aoColumns settings.
	 * 
	 * @see $_aoColumns
	 * return string
	 */
	public function getAoColumns() {
		return $this->_aoColumns;
	}
	
	/**
	 * Sets the aoColumns settings.
	 * 
	 * @see $_aoColumns
	 * @param string $aoColumns
	 */
	public function setAoColumns($aoColumns) {
		$this->_aoColumns = $aoColumns;
	}
	
	/**
	 * Factory that allows creation of a data tables object from an array of
	 * data.
	 * 
	 * @param array|Traversable $options
	 * @return DataTables
	 * @throws Exception if $options is neither an array nor an object 
	 *   implementing Traversable
	 * @throws Exception if $options contains a setting for which no setter
	 *   exists
	 */
	public static function factory($options) {
		if($options instanceof \Traversable) {
			$options = ArrayUtils::iteratorToArray(options);
		} elseif(!is_array($options)) {
			throw new \Exception(sprintf(
				'%s expects an array or Traversable object; received "%s"',
				__METHOD__,
				(is_object($options) ? get_class($options) : gettype($options))
			));
		}
		
		$dataTables = new static();
		foreach($options as $k => $v) {
			$methodName = 'set'.ucfirst($k);
			if(!method_exists($dataTables, $methodName)) {
				throw new \Exception("No setter available for '$k'");
			}
			call_user_func(array($dataTables, $methodName), $v);
		}
		
		return $dataTables;
	}
}