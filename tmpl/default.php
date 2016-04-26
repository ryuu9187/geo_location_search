<?php
    defined('_JEXEC') or die;
    
    // Load jQuery
    JHtml::_('jquery.framework', false);
    
    $document = JFactory::getDocument();
    $document->addScript('/dev/modules/mod_geo_location_search/js/main.js');
	
	$module = JModuleHelper::getModule('mod_geo_location_search');
	$modParams = new JRegistry($module->params);
	$apiKey = $modParams['api_key'];
	$linkTemplate = $modParams['link_template'];
	
	// Set some global JS variables from the module
	$document->addScriptDeclaration("_apiKey = '" . $apiKey . "'; _linkTemplate = '" . $linkTemplate . "';");
	
	// CSS
	$style = '#geoList {list-style-type: none;padding: 2em;}';
	$style .= ' #geoList li {border: 1px solid #CCC; padding: 1em; font-size: 1em; border-radius: .5em; margin:0.5em}';
	$style .= ' .geo-sub-container {font-weight: bold;}';
	$style .= ' .geo-title {display:inline-block;font-size: 1.5em;}';
	$style .= ' .geo-distance {float:right;}';
	$style .= ' .geo-address {display:inline-block;margin-right:1em;}';
	$style .= ' .geo-courses-btn {}';
	$document->addStyleDeclaration($style);
	
?>


<div id="geoSearchContainer" style="text-align:center;">
	<div style="padding: 10px; display: inline-block;">
		<label for="location">Location: </label>
		<input type="text" name="location" id="geo_location" size="50"/>
	</div>
	<div style="padding: 10px; display: inline;">
		<label for="radius">Distance: </label>
		<select id="geo_radius" name="radius" style="width:inherit;">

<?php
	$radii = $modParams['radii_values'];
	$values = split(",", $radii);
	
	foreach ($values as $radius) {
		$trimmed = trim($radius);
		$intVal = intval($trimmed);
		
		if ($intVal > 0) {
			echo "<option value='" . $trimmed . "'>" . $trimmed . " miles</option>";
		}
	}
?>

		</select>
	</div>

	<button onclick="geoLocSearch();" class="btn btn-primary">Search</button>
</div>

<div>
	<ol id="geoList"></ol>
</div>