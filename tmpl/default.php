<?php
    defined('_JEXEC') or die;
    
    // Load jQuery
    JHtml::_('jquery.framework', false);
    
    $document = JFactory::getDocument();
    $document->addScript('/dev/modules/mod_geo_location_search/js/main.js');
?>

<div>Hello, world</div>