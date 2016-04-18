function updateGeoLocationUI(locations) {
	var $display = jQUery("#geoList");
}

function geoLocSearch(apiKey) {
	var $location = jQuery("#geo_location");
	var $distance = jQuery("#geo_radius");
	var location = $location && $location.val() || null;
	var distance = $distance && $distance.val() || null;
	
	if (!location) {
		alert("Please enter a location (address, city, zip) to search for.");
		return;
	}
	
	if (!apiKey) {
		console.log("Cannot get current geo-location. API key error.");
		alert("Error running geo-services. Could not get your current location.");
		return;
	}
	
	// Generates ajax parameters for retrieving locations based on lat/long
	var getGeoLocationsParams = function (lat, long, r) {
		return {
			type: "POST",
			url: "index.php?option=com_ajax&module=geo_location_search&method=getGeoLocations&format=json&Itemid=1",
			data: { lat : lat, long : long, radius : r},
			success: function(response){
				updateGeoLocationUI(JSON.parse(response));
			}
		};
	};
	
	// Get the lat/long
	jQuery.ajax({
		type: "GET",
		url : "https://maps.googleapis.com/maps/api/geocode/json?address=" + encodeURI(location) + "&key=" + apiKey,
		success : function (response) {
			if (response && response.results && response.results.length > 0) {
				var geo = response.results[0].geometry;
				if (geo && geo.location) {
					// Get locations
					jQuery.ajax(getGeoLocationsParams(geo.location.lat, geo.location.lng, distance));
				} else {
					alert("Could not find the location specified.");
				}
			} else {
				alert("Could not find the location specified.");
			}
		}
	});
}