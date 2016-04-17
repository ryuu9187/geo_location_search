<?php
	
    class ModGeoLocationSearchHelper
	{
		public static function getGeoLocationsAjax($params) {
			$app = JFactory::getApplication();
			$postParams = $app->input;
			
			echo json_encode($postParams);
			
			$app->close();
		}
	}

?>