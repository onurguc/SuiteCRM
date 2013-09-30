<?php

require_once('modules/jjwg_Markers/jjwg_Markers_sugar.php');
require_once('modules/jjwg_Maps/jjwg_Maps.php');


class jjwg_Markers extends jjwg_Markers_sugar {

    /**
     * @var settings array
     */
    var $settings = array();

    function jjwg_Markers() {
        
        parent::jjwg_Markers_sugar();
        // Admin Config Setting
        $this->configuration();
    }

    /**
     * Load Configuration Settings using Administration Module
     * See jjwg_Maps module for setting config
     * $GLOBALS['jjwg_config_defaults']
     * $GLOBALS['jjwg_config']
     */
    function configuration() {

        $this->jjwg_Maps = new jjwg_Maps();
        $this->settings = $GLOBALS['jjwg_config'];
    }

    /**
     * 
     * Define Marker Location
     * @param $marker mixed (array or object)
     */
    function define_loc($marker = array()) {

        if (empty($marker)) {
            $marker = $this;
        }
        $loc = array();
        if (is_object($marker)) {
            $loc['name'] = $marker->name;
            $loc['lat'] = $marker->jjwg_maps_lat;
            $loc['lng'] = $marker->jjwg_maps_lng;
        } elseif (is_array($marker)) {
            $loc['name'] = $marker['name'];
            $loc['lat'] = $marker['lat'];
            $loc['lng'] = $marker['lng'];
        }
        if (empty($loc['name'])) {
            $loc['name'] = 'N/A';
            $loc['lat'] = null;
            $loc['lng'] = null;
        }
        if (!$this->is_valid_lat($loc['lat'])) {
            $loc['lat'] = $this->settings['map_default_center_latitude'];
        }
        if (!$this->is_valid_lng($loc['lng'])) {
            $loc['lng'] = $this->settings['map_default_center_longitude'];
        }
        $loc['image'] = $marker->marker_image;
        return $loc;
    }

    /**
     * 
     * Check for valid longitude
     * @param $lng float
     */
    function is_valid_lng($lng) {
        return (is_numeric($lng) && $lng >= -180 && $lng <= 180);
    }

    /**
     * 
     * Check for valid latitude
     * @param $lat float
     */
    function is_valid_lat($lat) {
        return (is_numeric($lat) && $lat >= -90 && $lat <= 90);
    }

}