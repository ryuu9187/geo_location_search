<?php
	
    class ModGeoLocationSearchHelper
	{
		public static function getGeoLocationsAjax($params) {
			$app = JFactory::getApplication();
			$postParams = $app->input;
			
			echo json_encode(self::getLocationsNearLatLong(0,0));
			
			$app->close();
		}
		
		
		private static function getLocationsNearLatLong($lat, $long) {
			// Get a db connection.
			$db = JFactory::getDbo();
 
			// Create a new query object.
			$query = $db->getQuery(true);
 

			$query->select($db->quoteName(array('name', 'address', 'city', 'state', 'zip')))
				->from($db->quoteName('#__eb_locations'))
				->where($db->quoteName('published') . ' = 1')
				->order('name ASC');
 
			// Reset the query using our newly populated query object.
			$db->setQuery($query);
 
			// Load the results as a list of stdClass objects (see later for more options on retrieving data).
			$results = $db->loadObjectList();
			
			return $results;
		}
	}

?>