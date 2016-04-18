function geoLocSearch() {
	var $location = jQuery("#geo_location");
	var $distance = jQuery("#geo_radius");
	var data = {
		location : $location && $location.val() || null,
		distance : $distance && $distance.val() || null
	};
	
	jQuery.ajax({
		type: "POST",
		url: "index.php?option=com_ajax&module=geo_location_search&method=getGeoLocations&format=json&Itemid=1",
		data: data,
		success: function(response){
			console.log(response);
		}
	});
}

jQuery(document).ready(function() {

});