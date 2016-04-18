<?php
	
    class ModGeoLocationSearchHelper
	{
		public static function getGeoLocationsAjax($params) {
			$app = JFactory::getApplication();
			$postParams = $app->input;
			
			$radius = $postParams->getString('radius');
			$lat = $postParams->getString('lat');
			$long = $postParams->getString('long');
			
			echo json_encode(self::getLocationsNearLatLong($lat, $long, $radius));
			
			$app->close();
		}
		
		private static function getLocationsNearLatLong($lat, $long, $radius) {
			// Get a db connection.
			$db = JFactory::getDbo();
 
			// Create a new query object.
			$query = $db->getQuery(true);

			$query->select($db->quoteName(array('name', 'address', 'city', 'state', 'zip')))
				->from($db->quoteName('#__eb_locations'))
				->where($db->quoteName('published') . ' = 1', 'AND')
				->where('get_distance_in_miles_between_geo_locations(' .
					implode(',', array($lat, $long, $db->quoteName('lat'), $db->quoteName('long'))) .
					') <= ' . $radius)
				->order('name ASC');
 
			// Reset the query using our newly populated query object.
			$db->setQuery($query);
 
			// Load the results as a list of stdClass objects (see later for more options on retrieving data).
			$results = $db->loadObjectList();
			
			return $results;
		}
	}

?>