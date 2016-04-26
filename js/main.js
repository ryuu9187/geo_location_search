var _linkTemplate = "/courses/upcoming-event/{name}";
var _apiKey = "";

function createListItem(item, idx) {
	var formattedAddress = "";
	formattedAddress += item.address || "";
	formattedAddress += ((item.address && item.city) ? ", " : "") + (item.city || "");
	formattedAddress += ((item.city && item.state) ? ", " : "") + (item.state || "");
	formattedAddress += ((item.state && item.zip) ? " " : "") + (item.zip || "");

	var link = _linkTemplate.replace(/{name}/gi, item.name.toLowerCase().replace(/\s/gi, '-'));
	
	var $li = jQuery("<li></li>");
	var $div = jQuery("<div class='geo-sub-container'><p class='geo-title'>" + idx + ". " + item.name +
		"</p><p class='geo-distance'>" + (Math.round(item.distance * 10) / 10) + " Mi" + "</p></div>");
	var $div2 = jQuery("<div style='overflow:auto;'><p class='geo-address'>" + formattedAddress +
		"</p><a href='" + link + "' class='geo-courses-btn btn btn-primary'>Courses</a></div>");
	
	$li.append($div).append($div2);
	
	return $li;
}

function updateGeoLocationUI(locations) {
	var $display = jQuery("#geoList");
	$display.empty();
	
	for (var i = 0; i < locations.length; i++) {
		$display.append(createListItem(locations[i], i + 1));
	}
}

function geoLocSearch() {
	var $location = jQuery("#geo_location");
	var $distance = jQuery("#geo_radius");
	var location = $location && $location.val() || null;
	var distance = $distance && $distance.val() || null;
	
	if (!location) {
		alert("Please enter a location (address, city, zip) to search for.");
		return;
	}
	
	if (!_apiKey) {
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
		url : "https://maps.googleapis.com/maps/api/geocode/json?address=" + encodeURI(location) + "&key=" + _apiKey,
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


jQuery(document).ready(function() {
	var $location = jQuery("#geo_location").val() || "";
	if ($location) {
		geoLocSearch();
	}
});