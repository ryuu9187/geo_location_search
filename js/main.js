function geoLocSearch() {
	jQuery.ajax({
		type: "GET",
		url: "index.php?option=com_ajax&module=geo_location_search&method=getGeoLocations&format=json&Itemid=1",
		data: null,
		success: function(response){
			console.log(response);
		}
	});
}

jQuery(document).ready(function() {

});