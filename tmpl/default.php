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
?>


<div id="geoSearchContainer" style="text-align:center;">
	<div style="padding: 10px; display: inline;">
		<label for="location">Location: </label>
		<input type="text" name="location" id="geo_location" size="50"/>
	</div>
	<div style="padding: 10px; display: inline;">
		<label for="radius">Distance: </label>
		<select id="geo_radius" name="radius">

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

	<button onclick="geoLocSearch('<?php echo $apiKey ?>', '<?php echo $linkTemplate ?>');"
		class="btn btn-primary" style="float:right;">Search</button>
</div>

<div>
	<ol id="geoList" style="list-style-type: none;"></ol>
</div>