<?php
/*
Plugin Name: WP Google Maps - Pro Add-on
Plugin URI: http://www.wpgmaps.com
Description: This is the Pro add-on for WP Google Maps. The Pro add-on enables you to add descriptions, pictures, links and custom icons to your markers as well as allows you to download your markers to a CSV file for quick editing and re-upload them when complete.
Version: 5.22
Author: WP Google Maps
Author URI: http://www.wpgmaps.com

 
 
 * 5.22
 * Fixed PHP notice warnings (shown in debug mode)
 * Fixed marker location bug when the default uploads directory has been changed
 * 
 * 5.21
 * Fixed a bug that caused KML, Fusion tables and polygons to appear on the first map instead of individual maps when multiple maps where used on one page
 * Fixed a map width bug (%)
 * Added the option to select which API version you would like to use
 * 
 * 5.20
 * Introduced ini_set("auto_detect_line_endings", true); for better mac/pc importing of CSV files
 * Maps now work automatically when put in tabs
 * Added more options for the store locator
 * Added opacity options for polygon lines
 * 
 * 5.19
 * Small bug fix
 * 
 * 5.18
 * Mutlisite marker location bug fixed
 * 
 * 5.17
 * Markers are now stored in the uploads/wp-google-maps/ directory
 * 
 * 5.16
 * Small bug fix
 * 
 * 5.15
 * Performance improvements
 * 
 * 5.14
 * Added the option to display categories as a dropdown or as checkboxes
 * Added store locator functionality. More functionality for this to follow soon (Still in BETA)
 * Fixed the bug that swapped the variables around for disabling "double click zoom"
 * Fixed a bug that forced a new geocode on every marker edit, even if the address wasnt changed
 * New functionality:
 *  - You can now choos to open a marker from click or hover
 *  - Better error handling
 * 
 * 5.13
 * Fixed a conflict between KML layers and Polygons whereby clicks on markers within a KML layer were not triggering if the polygon overlapped the KML layer markers. Polygons 'clickable' now set to false
 * 
 * 5.12
 * Fixed the category selection bug that did not revert back to 'all' markers.
 * 
 * 5.11
 * Small bug fix
 * 
 * 5.10
 * Small bug fix
 * 
 * 5.09
 * Added category filtering via shortcode
 * 
 * 5.08
 * Fixed a conflict with the NextGen plugin
 * 
 * 5.07
 * Fixed a bug that stopped directions from working with multiple maps on the same page
 * 
 * 5.06
 * Small bug fixes in the core.js file
 * 
 * 5.05
 * Fixed a bug causign JS conflicts in IE8
 * 
 * 5.04
 * Fixed a bug that messed up the iamge sizes in some browsers
 * 
 * 5.03
 * Fixed a bug that caused all control elements on the map to disspear
 * 
 * 5.02
 * Fixed an marker icon bug for some hosts
 * Fixed small bug with resetting select boxes within the add marker section
 * 
 * 5.01
 * Small bug fixes
 * 
 * 5.0
 * Complete re-code
 * Upgrade: The JavaScript is now in it's own file
 * Better error handling
 * You now have the ability to add a default "To" address for the directions.
 * Fixed map align center bug
 * Fixed infowindow styling issues when images are used
 * Fixed the bug that caused the map to not load if a blank polyline/polygon was created
 * Fixed cross-browser infowindow styling bugs
 * You can now hide/show columns of your choice with the advanced listing option
 * Fixed many smaller bugs
 * 
 * 
 * 4.18
 * You can now add HTML into the description field
 * Functionality added for category icons
 * You can now assign categories to specific maps or all maps
 * Bug fixes:
 *  Fixed the sorting markers bug
 *  Fixed the bug that stopped you from deleting polylines
 *  Fixed the bug that caused no markers to display in the marker list when "Select" was selected in the category filter drop down.
 * 
 * 4.17
 * There is now the option to hide the Category column
 * 
 * 4.16
 * Fixed an infowindow styling bug
 * 
 * 4.15
 * Added a check to see if the Google Maps API was already loaded to avoid duplicate loading
 * Fixed some SSL bugs
 * Added extra style support for the standard marker listing
 * Advanced marker list now updates with category drop down selection
 *
 * 4.14
 * Added a min-width to the DIV within the InfoWindow class to stop the scroll bars from appearing in IE10
 *
 * 4.13
 * Map mashups are now available by modifying the shortcode.
 * Added Category functionality.
 * Fixed a bug with the normal marker list layout
 * Added backwards compatibility for older versions of WordPress
 * Fixed a few small bugs
 * Replaced deprecated WordPress function calls
 * Added Spanish translation - Thank you Fernando!
 * Coming soon in 4.14: Map mashup via custom fields in post.
 *
 * 4.12
 * Fixed a small bug
 *
 * 4.11
 * Better localization support
 * Fixed a SSL bug
 * 
 * 4.10
 * Added Polygon functionality
 * Added Polyline functionality
 * You can now show your visitors location on the map
 * Markers can now be sorted by id,title,description or address
 * Added better support for jQuery versions
 * Plugin now works out the box with jQuery tabs
 * Added standards for the advanced marker list style
 * Added user access support for the visitor generated markers add-on
 * Adjusted the KML functionality to avoid caching
 * Fixed small bugs causing PHP warnings
 * Fixed a bug that stopped the advanced marker listing from working
 * 
 * 4.09
 * Fixed a bug that didnt allow for multiple clicks on the marker list to bring the view back to the map
 * 
 * 4.08
 * This version allows the plugin to update itself moving forward
 * 
 * 4.07
 * Fixed a bug that was causing a JavaScript error with DataTables
 * 
 * 4.06
 * Added troubleshooting support
 * Fixed a bug that was stopping the plugin from working on IIS servers
 * 
 * 4.05
 * Added support for one-page-style themes.
 * Fixed a firefox styling bug when using percentage width/height and set map alignment to 'none'
 * Added support for disabling mouse zooming and dragging
 * Added support for jQuery1.9+
 * 
 * 4.04
 * Fixed a centering bug - thank you Yannick!
 * Italian translation added
 * Fixed an IE9 display bug 
 * Fixed a compatibility bug between the VGm add-on and the Pro add-on
 * Fixed a bug with the VGM display option
 * Fixed a bug with importing markers whereby it always showed as an error even when importing correctly
 *
 * 4.03
 * Fixed a firefox styling bug that caused the Directions box to load on the right of the map instead of below.
 * Added support code for the new WP Google Maps Visitor Generated Markers plugin
 * Added the option for a more advanced way to list your markers below your maps
 * Added responsive size functionality
 * Added support for Fusion Tables
 *
 * 4.02
 * Fixed the bug that caused the directions box to show above the map by default
 * Fixed the bug whereby an address was already hard-coded into the "To" field of the directions box
 * Fixed the bug that caused the traffic layer to show by default
 *
 * 4.01
 * Added the functionality to list your markers below the map
 * Added more advanced directions functionality
 * Fixed small bugs
 * Fixed a bug that caused a fatal error when trying to activate the plugin on some hosts.
 *
 * 4.0
 * Plugin now supports multiple maps on one page
 * Bicycle directions now added
 * Walking directions now added
 * "Avoid tolls" now added to the directions functionality
 * "Avoid highways" now added to directions functionality
 * New setting: open links in a new window
 * Added functionality to reset the default marker image if required.
 *
 * 3.12
 * Fixed the bug that told users they had an outdated plugin when in fact they never
 *
 * 3.11
 * Fixed the bug that was causing both the bicycle layer and traffic layer to show all the time
 * 
 * 3.10
 * Added the bicycle layer
 * Added the traffic layer
 * Fixed the bug that was not allowing users to overwrite existing data when uploading a CSV file
 *
 * 3.9
 * Added support for KML/GeoRSS layers.
 * Fixed the directions box styling error in Firefox.
 * Fixed the bug whereby users couldnt change the default location without adding a marker first.
 * When the "Directions" link is clicked on, the "From" field is automatically highlighted for the user.
 * Added additional settings
 *
 * 3.8
 * Markers now automatically close when you click on another marker.
 * Russian localization added
 * The "To" field in the directions box now shows the address and not the GPS co-ords.
 *
 * 3.7
 * Added support for localization
 *
 * 3.6
 * Fixed the bug that caused slow loading times with sites that contain a high number of maps and markers
 *
 * 3.5
 * Fixed the bug where sometimes the short code wasnt working for home pages
 *
 * 3.4
 * Added functionality for 'Titles' for each marker
 *
 * 3.3
 * Added functionality for WordPress MU
 *
 * 3.2
 * Fixed a bug where in IE the zoom checkbox was showing
 * Fixed the bug where the map wasnt saving correctly in some instances

 * 3.1
 * Fixed redirect problem
 * Fixed bug that never created the default map on some systems

 * 3.0
 * Added Map Alignment functionality
 * Added Map Type functionality
 * Started using the Geocoding API Version 3  instead of Version 2 - quicker results!
 * Fixed bug that didnt import animation data for CSV files
 * Fixed zoom bug

 * 2.1
 * Fixed a few bugs with the jQuery script
 * Fixed the shortcode bug where the map wasnt displaying when two or more short codes were one the post/page
 * Fixed a bug that wouldnt save the icon on editing a marker in some instances
 *
 * 
 *
*/
error_reporting(E_ERROR);
global $wpgmza_pro_version;
global $wpgmza_pro_string;
$wpgmza_pro_version = "5.22";
$wpgmza_pro_string = "pro";

global $wpgmza_current_map_cat_selection;

global $wpgmza_p;
global $wpgmza_t;
$wpgmza_p = true;
$wpgmza_t = "pro";

global $wpgmza_count;
$wpgmza_count = 0;

global $wpgmza_post_nonce;
$wpgmza_post_nonce = md5(time());

include ("wp-google-maps-pro_categories.php");

add_action('admin_head', 'wpgmaps_upload_csv');
add_action('init', 'wpgmza_register_pro_version');


function wpgmaps_pro_activate() { 
    wpgmza_cURL_response_pro("activate");
    if (function_exists("wpgmaps_handle_directory")) { wpgmaps_handle_directory(); } ;
}
function wpgmaps_pro_deactivate() { wpgmza_cURL_response_pro("deactivate"); }




function wpgmza_register_pro_version() {
    global $wpgmza_pro_version;
    global $wpgmza_pro_string;
    global $wpgmza_t;
    if (!get_option('WPGMZA_PRO')) {
        add_option('WPGMZA_PRO',array("version" => $wpgmza_pro_version, "version_string" => $wpgmza_t));
    } else {
        update_option('WPGMZA_PRO',array("version" => $wpgmza_pro_version, "version_string" => $wpgmza_t));
    }
}

function wpgmza_pro_menu() {
    global $wpgmza_pro_version;
    global $wpgmza_p_version;
    global $wpgmza_post_nonce;
    global $wpgmza_tblname_maps;
    global $wpdb;
    

    
    $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
    $use_timthumb = $wpgmza_settings['wpgmza_settings_use_timthumb'];
    if ($use_timthumb == "" || !isset($use_timthumb)) {
        /* only check permissions if the user has requested to use timthumb */
        if (function_exists("wpgmaps_check_permissions_cache") && function_exists("wpgmaps_cache_permission_warning")) { 
            if (!wpgmaps_check_permissions_cache()) { wpgmaps_cache_permission_warning(); }
        }
    }
    
    
    if ($_GET['action'] == "edit") {

    }
    else if ($_GET['action'] == "new") {


        $def_data = get_option("WPGMZA_SETTINGS");

        $data['map_default_starting_lat'] = $map_start_lat;
        $data['map_default_starting_lng'] = $map_start_lng;
        $data['map_default_height'] = $map_height;
        $data['map_default_width'] = $map_width;
        $data['map_default_height_type'] = $map_height_type;
        $data['map_default_width_type'] = $map_width_type;
        $data['map_default_zoom'] = $map_start_zoom;
        $data['map_default_type'] = $type;
        $data['map_default_alignment'] = $alignment;
        $data['map_default_order_markers_by'] = $order_markers_by;
        $data['map_default_order_markers_choice'] = $order_markers_choice;
        $data['map_default_show_user_location'] = $show_user_location;
        $data['map_default_directions'] = $directions_enabled;
        $data['map_default_bicycle'] = $bicycle_enabled;
        $data['map_default_traffic'] = $traffic_enabled;
        $data['map_default_dbox'] = $dbox;
        $data['map_default_dbox_width'] = $dbox_width;
        $data['map_default_default_to'] = $default_to;
        $data['map_default_marker'] = $map_default_marker;

        if (isset($def_data['map_default_height_type'])) {
            $wpgmza_height_type = $def_data['map_default_height_type'];
        } else {
            $wpgmza_height_type = "px";
        }
        if (isset($def_data['map_default_width_type'])) {
            $wpgmza_width_type = $def_data['map_default_width_type'];
        } else {
            $wpgmza_width_type = "px";
        }
        
        if (isset($def_data['map_default_height'])) {
            $wpgmza_height = $def_data['map_default_height'];
        } else {
            $wpgmza_height = "400";
        }
        if (isset($def_data['map_default_width'])) {
            $wpgmza_width = $def_data['map_default_width'];
        } else {
            $wpgmza_width = "600";
        }
        if (isset($def_data['map_default_marker'])) {
            $wpgmza_def_marker = $def_data['map_default_marker'];
        } else {
            $wpgmza_def_marker = "0";
        }
        if (isset($def_data['map_default_alignment'])) {
            $wpgmza_def_alignment = $def_data['map_default_alignment'];
        } else {
            $wpgmza_def_alignment = "0";
        }
        if (isset($def_data['map_default_order_markers_by'])) {
            $wpgmza_def_order_markers_by = $def_data['map_default_order_markers_by'];
        } else {
            $wpgmza_def_order_markers_by = "0";
        }
        if (isset($def_data['map_default_order_markers_choice'])) {
            $wpgmza_def_order_markers_choice = $def_data['map_default_order_markers_choice'];
        } else {
            $wpgmza_def_order_markers_choice = "0";
        }
        if (isset($def_data['map_default_show_user_location'])) {
            $wpgmza_def_show_user_location = $def_data['map_default_show_user_location'];
        } else {
            $wpgmza_def_show_user_location = "0";
        }
        if (isset($def_data['map_default_directions'])) {
            $wpgmza_def_directions = $def_data['map_default_directions'];
        } else {
            $wpgmza_def_directions = "0";
        }
        if (isset($def_data['map_default_bicycle'])) {
            $wpgmza_def_bicycle = $def_data['map_default_bicycle'];
        } else {
            $wpgmza_def_bicycle = "0";
        }
        if (isset($def_data['map_default_traffic'])) {
            $wpgmza_def_traffic = $def_data['map_default_traffic'];
        } else {
            $wpgmza_def_traffic = "0";
        }
        if (isset($def_data['map_default_dbox'])) {
            $wpgmza_def_dbox = $def_data['map_default_dbox'];
        } else {
            $wpgmza_def_dbox = "0";
        }
        if (isset($def_data['map_default_dbox_wdith'])) {
            $wpgmza_def_dbox_width = $def_data['map_default_dbox_width'];
        } else {
            $wpgmza_def_dbox_width = "500";
        }
        if (isset($def_data['map_default_default_to'])) {
            $wpgmza_def_default_to = $def_data['map_default_default_to'];
        } else {
            $wpgmza_def_default_to = "";
        }
        if (isset($def_data['map_default_listmarkers'])) {
            $wpgmza_def_listmarkers = $def_data['map_default_listmarkers'];
        } else {
            $wpgmza_def_listmarkers = "0";
        }
        if (isset($def_data['map_default_listmarkers_advanced'])) {
            $wpgmza_def_listmarkers_advanced = $def_data['map_default_listmarkers_advanced'];
        } else {
            $wpgmza_def_listmarkers_advanced = "0";
        }
        if (isset($def_data['map_default_filterbycat'])) {
            $wpgmza_def_filterbycat = $def_data['map_default_filterbycat'];
        } else {
            $wpgmza_def_filterbycat = "0";
        }
        if (isset($def_data['map_default_type'])) {
            $wpgmza_def_type = $def_data['map_default_type'];
        } else {
            $wpgmza_def_type = "1";
        }

        if (isset($def_data['map_default_zoom'])) {
            $start_zoom = $def_data['map_default_zoom'];
        } else {
            $start_zoom = 5;
        }
        
        if (isset($def_data['map_default_ugm_access'])) {
            $ugm_access = $def_data['map_default_ugm_access'];
        } else {
            $ugm_access = 0;
        }
        
        if (isset($def_data['map_default_starting_lat']) && isset($def_data['map_default_starting_lng'])) {
            $wpgmza_lat = $def_data['map_default_starting_lat'];
            $wpgmza_lng = $def_data['map_default_starting_lng'];
        } else {
            $wpgmza_lat = "51.5081290";
            $wpgmza_lng = "-0.1280050";
        }


        $wpdb->insert( $wpgmza_tblname_maps, array(
            "map_title" => "New Map",
            "map_start_lat" => "$wpgmza_lat",
            "map_start_lng" => "$wpgmza_lng",
            "map_width" => "$wpgmza_width",
            "map_height" => "$wpgmza_height",
            "map_start_location" => "$wpgmza_lat,$wpgmza_lng",
            "map_start_zoom" => "$start_zoom",
            "default_marker" => "$wpgmza_def_marker",
            "alignment" => "$wpgmza_def_alignment",
            "styling_enabled" => "0",
            "styling_json" => "",
            "active" => "0",
            "directions_enabled" => "$wpgmza_def_directions",
            "type" => "$wpgmza_def_type",
            "kml" => "",
            "fusion" => "",
            "map_width_type" => "$wpgmza_width_type",
            "map_height_type" => "$wpgmza_height_type",
            "fusion" => "",
            "mass_marker_support" => "0",
            "ugm_enabled" => "0",
            "ugm_category_enabled" => "0",
            "ugm_access" => "$ugm_access",
            "bicycle" => "$wpgmza_def_bicycle",
            "traffic" => "$wpgmza_def_traffic",
            "dbox" => "$wpgmza_def_dbox",
            "dbox_width" => "$wpgmza_def_dbox_width",
            "listmarkers" => "$wpgmza_def_listmarkers",
            "listmarkers_advanced" => "$wpgmza_def_listmarkers_advanced",
            "filterbycat" => "$wpgmza_def_filterbycat",
            "order_markers_by" => "$wpgmza_def_order_markers_by",
            "order_markers_choice" => "$wpgmza_def_order_markers_choice",
            "show_user_location" => "$wpgmza_def_show_user_location"

            )
        );
        $lastid = $wpdb->insert_id;
        $_GET['map_id'] = $lastid;
        //wp_redirect( admin_url('admin.php?page=wp-google-maps-menu&action=edit&map_id='.$lastid) );
        //$wpdb->print_errors();
        
        echo "<script>window.location = \"".get_option('siteurl')."/wp-admin/admin.php?page=wp-google-maps-menu&action=edit&map_id=".$lastid."\"</script>";
    }


    if (isset($_GET['map_id'])) {

        $res = wpgmza_get_map_data($_GET['map_id']);
        if (function_exists("wpgmza_register_gold_version")) { $addon_text = __("including Pro &amp; Gold add-ons","wp-google-maps"); } else { $addon_text = __("including Pro add-on","wp-google-maps"); }
        /* if (!$res->map_id || $res->map_id == "") { $wpgmza_data['map_id'] = 1; } */
        if (!$res->default_marker || $res->default_marker == "" || $res->default_marker == "0") { $display_marker = "<img src=\"".wpgmaps_get_plugin_url()."/images/marker.png\" />"; } else { $display_marker = "<img src=\"".$res->default_marker."\" />"; }
        if ($res->map_start_zoom) { $wpgmza_zoom[intval($res->map_start_zoom)] = "SELECTED"; } else { $wpgmza_zoom[8] = "SELECTED"; }
        if ($res->type) { $wpgmza_map_type[intval($res->type)] = "SELECTED"; } else { $wpgmza_map_type[1] = "SELECTED"; }
        if ($res->alignment) { $wpgmza_map_align[intval($res->alignment)] = "SELECTED"; } else { $wpgmza_map_align[1] = "SELECTED"; }
        if ($res->directions_enabled) { $wpgmza_directions[intval($res->directions_enabled)] = "SELECTED"; } else { $wpgmza_directions[2] = "SELECTED"; }
        if ($res->bicycle) { $wpgmza_bicycle[intval($res->bicycle)] = "SELECTED"; } else { $wpgmza_bicycle[2] = "SELECTED"; }
        if ($res->traffic) { $wpgmza_traffic[intval($res->traffic)] = "SELECTED"; } else { $wpgmza_traffic[2] = "SELECTED"; }
        if ($res->dbox != "1") { $wpgmza_dbox[intval($res->dbox)] = "SELECTED"; } else { $wpgmza_dbox[1] = "SELECTED"; }

        if ($res->order_markers_by) { $wpgmza_map_order_markers_by[intval($res->order_markers_by)] = "SELECTED"; } else { $wpgmza_map_order_markers_by[1] = "SELECTED"; }
        if ($res->order_markers_choice) { $wpgmza_map_order_markers_choice[intval($res->order_markers_choice)] = "SELECTED"; } else { $wpgmza_map_order_markers_choice[2] = "SELECTED"; }

        if ($res->show_user_location) { $wpgmza_show_user_location[intval($res->show_user_location)] = "SELECTED"; } else { $wpgmza_show_user_location[2] = "SELECTED"; }
        
        $wpgmza_map_width_type_px = "";
        $wpgmza_map_height_type_px = "";
        $wpgmza_map_width_type_percentage = "";
        $wpgmza_map_height_type_percentage = "";
        
       if (stripslashes($res->map_width_type) == "%") { $wpgmza_map_width_type_percentage = "SELECTED"; } else { $wpgmza_map_width_type_px = "SELECTED"; }
       if (stripslashes($res->map_height_type) == "%") { $wpgmza_map_height_type_percentage = "SELECTED"; } else { $wpgmza_map_height_type_px = "SELECTED"; }


        if ($res->listmarkers == "1") { $listmarkers_checked = "CHECKED"; } else { $listmarkers_checked = ""; }
        if ($res->filterbycat == "1") { $listfilters_checked = "CHECKED"; } else { $listfilters_checked = ""; }
        if ($res->listmarkers_advanced == "1") { $listmarkers_advanced_checked = "CHECKED"; } else { }

        
        for ($i=0;$i<22;$i++) {
            if (!isset($wpgmza_zoom[$i])) { $wpgmza_zoom[$i] = ""; }
        }
        for ($i=0;$i<5;$i++) {
            if (!isset($wpgmza_map_type[$i])) { $wpgmza_map_type[$i] = ""; }
        }
        for ($i=0;$i<5;$i++) {
            if (!isset($wpgmza_map_align[$i])) { $wpgmza_map_align[$i] = ""; }
        }
        for ($i=0;$i<3;$i++) {
            if (!isset($wpgmza_bicycle[$i])) { $wpgmza_bicycle[$i] = ""; }
        }
        for ($i=0;$i<3;$i++) {
            if (!isset($wpgmza_traffic[$i])) { $wpgmza_traffic[$i] = ""; }
        }
        for ($i=0;$i<3;$i++) {
            if (!isset($wpgmza_directions[$i])) { $wpgmza_directions[$i] = ""; }
        }
        for ($i=0;$i<6;$i++) {
            if (!isset($wpgmza_dbox[$i])) { $wpgmza_dbox[$i] = ""; }
        }
        for ($i=0;$i<6;$i++) {
            if (!isset($wpgmza_map_order_markers_by[$i])) { $wpgmza_map_order_markers_by[$i] = ""; }
        } 
        for ($i=0;$i<6;$i++) {
            if (!isset($wpgmza_map_order_markers_choice[$i])) { $wpgmza_map_order_markers_choice[$i] = ""; }
        }   
        for ($i=0;$i<3;$i++) {
            if (!isset($wpgmza_show_user_location[$i])) { $wpgmza_show_user_location[$i] = ""; }
        }   
        
        
        $other_settings_data = maybe_unserialize($res->other_settings);
        $wpgmza_store_locator_enabled = $other_settings_data['store_locator_enabled'];
        $wpgmza_store_locator_distance = $other_settings_data['store_locator_distance'];
        $wpgmza_store_locator_category_enabled = $other_settings_data['store_locator_category'];
        
        
        $wpgmza_weather_option = $other_settings_data['weather_layer'];
        $wpgmza_cloud_option = $other_settings_data['cloud_layer'];
        $wpgmza_transport_option = $other_settings_data['transport_layer'];
        
        $wpgmza_store_locator_enabled_checked[0] = '';
        $wpgmza_store_locator_enabled_checked[1] = '';
        $wpgmza_store_locator_distance_checked[0] = '';
        $wpgmza_store_locator_distance_checked[1] = '';
        $wpgmza_store_locator_category_checked[0] = '';
        $wpgmza_store_locator_category_checked[1] = '';
        if ($wpgmza_store_locator_enabled == 1) {
            $wpgmza_store_locator_enabled_checked[0] = 'selected';
            
        } else {
            $wpgmza_store_locator_enabled_checked[1] = 'selected';
        }
        
        if ($wpgmza_store_locator_distance == 1) {
            $wpgmza_store_locator_distance_checked[0] = 'selected';
        } else {
            $wpgmza_store_locator_distance_checked[1] = 'selected';
        }
        
        if ($wpgmza_store_locator_category_enabled == 1) {
            $wpgmza_store_locator_category_checked[0] = 'selected';
        } else {
            $wpgmza_store_locator_category_checked[1] = 'selected';
        }
        
        $sl_stroke_color = $other_settings_data['sl_stroke_color'];
        $sl_stroke_opacity = $other_settings_data['sl_stroke_opacity'];
        $sl_fill_color = $other_settings_data['sl_fill_color'];
        $sl_fill_opacity = $other_settings_data['sl_fill_opacity'];
        if (!isset($sl_stroke_color) || $sl_stroke_color == "") {
            $sl_stroke_color = "FF0000";
        }
        if (!isset($sl_stroke_opacity) || $sl_stroke_opacity == "") {
            $sl_stroke_opacity = "0.25";
        }
        if (!isset($sl_fill_color) || $sl_fill_color == "") {
            $sl_fill_color = "FF0000";
        }
        if (!isset($sl_fill_opacity) || $sl_fill_opacity == "") {
            $sl_fill_opacity = "0.15";
        }
        

        
        
        $wpgmza_weather_layer_checked[0] = '';
        $wpgmza_weather_layer_checked[1] = '';
        $wpgmza_cloud_layer_checked[0] = '';
        $wpgmza_cloud_layer_checked[1] = '';
        $wpgmza_transport_layer_checked[0] = '';
        $wpgmza_transport_layer_checked[1] = '';
        
        
        if ($wpgmza_weather_option == 1) {
            $wpgmza_weather_layer_checked[0] = 'selected';
        } else {
            $wpgmza_weather_layer_checked[1] = 'selected';
        }
        if ($wpgmza_cloud_option == 1) {
            $wpgmza_cloud_layer_checked[0] = 'selected';
        } else {
            $wpgmza_cloud_layer_checked[1] = 'selected';
        }
        if ($wpgmza_transport_option == 1) {
            $wpgmza_transport_layer_checked[0] = 'selected';
        } else {
            $wpgmza_transport_layer_checked[1] = 'selected';
        }
        
        $wpgmza_csv = "<a href=\"".wpgmaps_get_plugin_url()."/csv.php\" title=\"".__("Download this as a CSV file","wp-google-maps")."\">".__("Download this data as a CSV file","wp-google-maps")."</a>";

    }
    echo "
       <div class='wrap'>
    
    
    
    
    
    
            <h1>WP Google Maps <small>($addon_text)</small></h1>
            <div class='wide'>
                    ".wpgmza_version_check()."
                    <h2>".__("Create your Map","wp-google-maps")."</h2>
                    
    
    <form action='' method='post' id='wpgmaps_options' name='wpgmza_map_form'>

        <div id=\"wpgmaps_tabs\">
                <ul>
                        <li><a href=\"#tabs-1\">General Settings</a></li>
                        <li><a href=\"#tabs-2\">Directions</a></li>
                        <li><a href=\"#tabs-3\">Store Locator</a></li>
                        <li><a href=\"#tabs-4\">Advanced Settings</a></li>
                </ul>
                <div id=\"tabs-1\">

                     
            
                    <p></p>

                        <input type='hidden' name='http_referer' value='".$_SERVER['PHP_SELF']."' />
                        <input type='hidden' name='wpgmza_id' id='wpgmza_id' value='".$res->id."' />
                        <input id='wpgmza_start_location' name='wpgmza_start_location' type='hidden' size='40' maxlength='100' value='".$res->map_start_location."' />
                        <select id='wpgmza_start_zoom' name='wpgmza_start_zoom' style=\"display:none;\">
                            <option value=\"1\" ".$wpgmza_zoom[1].">1</option>
                            <option value=\"2\" ".$wpgmza_zoom[2].">2</option>
                            <option value=\"3\" ".$wpgmza_zoom[3].">3</option>
                            <option value=\"4\" ".$wpgmza_zoom[4].">4</option>
                            <option value=\"5\" ".$wpgmza_zoom[5].">5</option>
                            <option value=\"6\" ".$wpgmza_zoom[6].">6</option>
                            <option value=\"7\" ".$wpgmza_zoom[7].">7</option>
                            <option value=\"8\" ".$wpgmza_zoom[8].">8</option>
                            <option value=\"9\" ".$wpgmza_zoom[9].">9</option>
                            <option value=\"10\" ".$wpgmza_zoom[10].">10</option>
                            <option value=\"11\" ".$wpgmza_zoom[11].">11</option>
                            <option value=\"12\" ".$wpgmza_zoom[12].">12</option>
                            <option value=\"13\" ".$wpgmza_zoom[13].">13</option>
                            <option value=\"14\" ".$wpgmza_zoom[14].">14</option>
                            <option value=\"15\" ".$wpgmza_zoom[15].">15</option>
                            <option value=\"16\" ".$wpgmza_zoom[16].">16</option>
                            <option value=\"17\" ".$wpgmza_zoom[17].">17</option>
                            <option value=\"18\" ".$wpgmza_zoom[18].">18</option>
                            <option value=\"19\" ".$wpgmza_zoom[19].">19</option>
                            <option value=\"20\" ".$wpgmza_zoom[20].">20</option>
                            <option value=\"21\" ".$wpgmza_zoom[21].">21</option>
                        </select>

                    <table class='form-table'>
                        <tr>
                            <td>".__("Short code","wp-google-maps").":</td>
                            <td><input type='text' readonly name='shortcode' style='font-size:18px; text-align:center;' value='[wpgmza id=\"".$res->id."\"]' /> <small><i>".__("copy this into your post or page to display the map","wp-google-maps")."</i>
                        </td>
                        </tr>
                        <tr>
                            <td>".__("Map Name","wp-google-maps").":</td>
                            <td><input id='wpgmza_title' name='wpgmza_title' class='regular-text' type='text' size='20' maxlength='50' value='".$res->map_title."' /></td>
                        </tr>
                        <tr>
                             <td>".__("Map Dimensions","wp-google-maps").":</td>
                             <td>
                                ".__("Width","wp-google-maps").": <input id='wpgmza_width' name='wpgmza_width' type='text' size='4' maxlength='4' class='small-text' value='".$res->map_width."' />
                                 <select id='wpgmza_map_width_type' name='wpgmza_map_width_type'>
                                    <option value=\"px\" $wpgmza_map_width_type_px>px</option>
                                    <option value=\"%\" $wpgmza_map_width_type_percentage>%</option>
                                 </select>

                                &nbsp; &nbsp; &nbsp; &nbsp; 
                                ".__("Height","wp-google-maps").": <input id='wpgmza_height' name='wpgmza_height' type='text' size='4' maxlength='4' class='small-text' value='".$res->map_height."' />
                                 <select id='wpgmza_map_height_type' name='wpgmza_map_height_type'>
                                    <option value=\"px\" $wpgmza_map_height_type_px>px</option>
                                    <option value=\"%\" $wpgmza_map_height_type_percentage>%</option>
                                 </select>

                            </td>
                        </tr>

                    </table>
                    
            
            
                </div>
                <div id=\"tabs-2\">
                    <table class='form-table' id='wpgmaps_advanced_options'>
                        
                        <tr>
                            <td width='200'>".__("Enable Directions?","wp-google-maps").":</td>
                            <td><select id='wpgmza_directions' name='wpgmza_directions' class='postform'>
                                <option value=\"1\" ".$wpgmza_directions[1].">".__("Yes","wp-google-maps")."</option>
                                <option value=\"2\" ".$wpgmza_directions[2].">".__("No","wp-google-maps")."</option>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            ".__("Directions Box Open by Default?","wp-google-maps").":
                            </td>
                            <td>
                            <select id='wpgmza_dbox' name='wpgmza_dbox' class='postform'>
                                <option value=\"1\" ".$wpgmza_dbox[1].">".__("No","wp-google-maps")."</option>
                                <option value=\"2\" ".$wpgmza_dbox[2].">".__("Yes, on the left","wp-google-maps")."</option>
                                <option value=\"3\" ".$wpgmza_dbox[3].">".__("Yes, on the right","wp-google-maps")."</option>
                                <option value=\"4\" ".$wpgmza_dbox[4].">".__("Yes, above","wp-google-maps")."</option>
                                <option value=\"5\" ".$wpgmza_dbox[5].">".__("Yes, below","wp-google-maps")."</option>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                ".__("Directions Box Width","wp-google-maps").":
                            </td>
                            <td>
                                <input id='wpgmza_dbox_width' name='wpgmza_dbox_width' type='text' size='4' maxlength='4' class='small-text' value='".$res->dbox_width."' /> px
                            </td>
                        </tr>
                        <tr>
                            <td>".__("Default 'To' address","wp-google-maps").":</td>
                            <td>
                             <input id='wpgmza_default_to' name='wpgmza_default_to' type='text' size='100' maxlength='700' class='regular-text' value='".$res->default_to."' /></td>
                            </td>
                        </tr>
                        </table>

                        
                            

            
    
                </div>
                <div id=\"tabs-3\">
                    <table class='form-table' id='wpgmaps_directions_options'>
                        <tr>
                            <td><h3>".__("General options","wp-google-maps").":</h3></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td width='200'>".__("Enable Store Locator","wp-google-maps").":</td>
                            <td><select id='wpgmza_store_locator' name='wpgmza_store_locator' class='postform'>
                                <option value=\"1\" ".$wpgmza_store_locator_enabled_checked[0].">".__("Yes","wp-google-maps")."</option>
                                <option value=\"2\" ".$wpgmza_store_locator_enabled_checked[1].">".__("No","wp-google-maps")."</option>
                            </select>
                            </td>
                        </tr>

                        <tr>
                            <td>".__("Show distance in","wp-google-maps").":</td>
                            <td><select id='wpgmza_store_locator_distance' name='wpgmza_store_locator_distance' class='postform'>
                                <option value=\"1\" ".$wpgmza_store_locator_distance_checked[0].">".__("Miles","wp-google-maps")."</option>
                                <option value=\"2\" ".$wpgmza_store_locator_distance_checked[1].">".__("Kilometers","wp-google-maps")."</option>
                            </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>".__("Allow category selection","wp-google-maps").":</td>
                            <td><select id='wpgmza_store_locator_category_enabled' name='wpgmza_store_locator_category_enabled' class='postform'>
                                <option value=\"1\" ".$wpgmza_store_locator_category_checked[0].">".__("Yes","wp-google-maps")."</option>
                                <option value=\"2\" ".$wpgmza_store_locator_category_checked[1].">".__("No","wp-google-maps")."</option>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td><h3>".__("Style options","wp-google-maps").":</h3></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                ".__("Line Color","wp-google-maps")."
                            </td>
                            <td>
                                <input id=\"sl_stroke_color\" name=\"sl_stroke_color\" type=\"text\" class=\"color\" value=\"$sl_stroke_color\" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                ".__("Line Opacity","wp-google-maps")."
                            </td>
                            <td>
                                <input id=\"sl_stroke_opacity\" name=\"sl_stroke_opacity\" type=\"text\" value=\"$sl_stroke_opacity\" /> ".__("(0 - 1.0) example: 0.5 for 50%","wp-google-maps")."
                            </td>
                        </tr>
                        <tr>
                            <td>
                                ".__("Fill Color","wp-google-maps")."
                            </td>
                            <td>
                                <input id=\"sl_fill_color\" name=\"sl_fill_color\" type=\"text\" class=\"color\" value=\"$sl_fill_color\" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                ".__("Fill Opacity","wp-google-maps")."
                            </td>
                            <td>
                                <input id=\"sl_fill_opacity\" name=\"sl_fill_opacity\" type=\"text\" value=\"$sl_fill_opacity\" /> ".__("(0 - 1.0) example: 0.5 for 50%","wp-google-maps")."
                            </td>
                        </tr>
                                                     




                        </table>
                        <p><em>".__('View','wp-google-maps')." <a href='http://wpgmaps.com/documentation/store-locator' target='_BLANK'>".__('Store Locator Documentation','wp-google-maps')."</a></em></p>
                        <p><em>Please note: the store locator functionality is still in Beta. If you find any bugs, please <a href='http://wpgmaps.com/contact-us/'>let us know</a></em></p>


                        
                            

            
    
                </div>
                <div id=\"tabs-4\">
                    <table class='form-table' id='wpgmaps_advanced_options'>
                        <tr>
                            <td>".__("Default Marker Image","wp-google-maps").":</td>
                            <td><span id=\"wpgmza_mm\">$display_marker</span> <input id=\"upload_default_marker\" name=\"upload_default_marker\" type='hidden' size='35' class='regular-text' maxlength='700' value='".$res->default_marker."' /> <input id=\"upload_default_marker_btn\" type=\"button\" value=\"".__("Upload Image","wp-google-maps")."\"  /> <a href=\"javascript:void(0);\" onClick=\"document.forms['wpgmza_map_form'].upload_default_marker.value = ''; var span = document.getElementById('wpgmza_mm'); while( span.firstChild ) { span.removeChild( span.firstChild ); } span.appendChild( document.createTextNode('')); return false;\" title=\"Reset to default\">-reset-</a> &nbsp; &nbsp; <small><i>".__("Get great map markers <a href='http://mapicons.nicolasmollet.com/' target='_BLANK' title='Great Google Map Markers'>here</a>","wp-google-maps")."</i></small></td>
                        </tr>

                        <tr>
                            <td>".__("Map type","wp-google-maps").":</td>
                            <td><select id='wpgmza_map_type' name='wpgmza_map_type' class='postform'>
                                <option value=\"1\" ".$wpgmza_map_type[1].">".__("Roadmap","wp-google-maps")."</option>
                                <option value=\"2\" ".$wpgmza_map_type[2].">".__("Satellite","wp-google-maps")."</option>
                                <option value=\"3\" ".$wpgmza_map_type[3].">".__("Hybrid","wp-google-maps")."</option>
                                <option value=\"4\" ".$wpgmza_map_type[4].">".__("Terrain","wp-google-maps")."</option>
                            </select>
                            </td>
                        </tr>
                        <tr>
                             <td>".__("List all Markers","wp-google-maps").":</td>
                             <td>
                                <input id='wpgmza_listmarkers' name='wpgmza_listmarkers' type='checkbox' value='1' $listmarkers_checked /> ".__("List all markers below the map","wp-google-maps")."
                                <br /><input id='wpgmza_listmarkers_advanced' name='wpgmza_listmarkers_advanced' type='checkbox' value='1' $listmarkers_advanced_checked /> ".__("Select this for the advanced listing functionality","wp-google-maps")."

                            </td>
                        </tr>
                        <tr>
                             <td>".__("Filter by Category","wp-google-maps").":</td>
                             <td>
                                <input id='wpgmza_filterbycat' name='wpgmza_filterbycat' type='checkbox' value='1' $listfilters_checked /> ".__("Allow users to filter by category?","wp-google-maps")."

                            </td>
                        </tr>
                        <tr>
                             <td>".__("Order markers by","wp-google-maps").":</td>
                             <td>
                                <select id='wpgmza_order_markers_by' name='wpgmza_order_markers_by' class='postform'>
                                    <option value=\"1\" ".$wpgmza_map_order_markers_by[1].">".__("ID","wp-google-maps")."</option>
                                    <option value=\"2\" ".$wpgmza_map_order_markers_by[2].">".__("Title","wp-google-maps")."</option>
                                    <option value=\"3\" ".$wpgmza_map_order_markers_by[3].">".__("Address","wp-google-maps")."</option>
                                    <option value=\"4\" ".$wpgmza_map_order_markers_by[4].">".__("Description","wp-google-maps")."</option>
                                    <option value=\"5\" ".$wpgmza_map_order_markers_by[5].">".__("Category","wp-google-maps")."</option>
                                </select>
                                <select id='wpgmza_order_markers_choice' name='wpgmza_order_markers_choice' class='postform'>
                                    <option value=\"1\" ".$wpgmza_map_order_markers_choice[1].">".__("Ascending","wp-google-maps")."</option>
                                    <option value=\"2\" ".$wpgmza_map_order_markers_choice[2].">".__("Descending","wp-google-maps")."</option>
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td>".__("Map Alignment","wp-google-maps").":</td>
                            <td><select id='wpgmza_map_align' name='wpgmza_map_align' class='postform'>
                                <option value=\"1\" ".$wpgmza_map_align[1].">".__("Left","wp-google-maps")."</option>
                                <option value=\"2\" ".$wpgmza_map_align[2].">".__("Center","wp-google-maps")."</option>
                                <option value=\"3\" ".$wpgmza_map_align[3].">".__("Right","wp-google-maps")."</option>
                                <option value=\"4\" ".$wpgmza_map_align[4].">".__("None","wp-google-maps")."</option>
                            </select>
                            </td>
                        </tr>

                        <tr>
                            <td>".__("Show User's Location?","wp-google-maps").":</td>
                            <td><select id='wpgmza_show_user_location' name='wpgmza_show_user_location' class='postform'>
                                <option value=\"1\" ".$wpgmza_show_user_location[1].">".__("Yes","wp-google-maps")."</option>
                                <option value=\"2\" ".$wpgmza_show_user_location[2].">".__("No","wp-google-maps")."</option>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td valign='top'>".__("Enable Layers","wp-google-maps").":</td>
                            <td>
                                <select id='wpgmza_bicycle' name='wpgmza_bicycle' class='postform'>
                                    <option value=\"1\" ".$wpgmza_bicycle[1].">".__("Yes","wp-google-maps")."</option>
                                    <option value=\"2\" ".$wpgmza_bicycle[2].">".__("No","wp-google-maps")."</option>
                                </select> ".__("Bicycle Layer","wp-google-maps")."<br />
                                <select id='wpgmza_traffic' name='wpgmza_traffic' class='postform'>
                                    <option value=\"1\" ".$wpgmza_traffic[1].">".__("Yes","wp-google-maps")."</option>
                                    <option value=\"2\" ".$wpgmza_traffic[2].">".__("No","wp-google-maps")."</option>
                                </select> ".__("Traffic Layer","wp-google-maps")."<br />
                                <select id='wpgmza_weather' name='wpgmza_weather' class='postform'>
                                    <option value=\"1\" ".$wpgmza_weather_layer_checked[0].">".__("Yes","wp-google-maps")."</option>
                                    <option value=\"2\" ".$wpgmza_weather_layer_checked[1].">".__("No","wp-google-maps")."</option>
                                </select> ".__("Weather Layer","wp-google-maps")."<br />
                                <select id='wpgmza_cloud' name='wpgmza_cloud' class='postform'>
                                    <option value=\"1\" ".$wpgmza_cloud_layer_checked[0].">".__("Yes","wp-google-maps")."</option>
                                    <option value=\"2\" ".$wpgmza_cloud_layer_checked[1].">".__("No","wp-google-maps")."</option>
                                </select> ".__("Cloud Layer","wp-google-maps")."<br />
                                <select id='wpgmza_transport' name='wpgmza_transport' class='postform'>
                                    <option value=\"1\" ".$wpgmza_transport_layer_checked[0].">".__("Yes","wp-google-maps")."</option>
                                    <option value=\"2\" ".$wpgmza_transport_layer_checked[1].">".__("No","wp-google-maps")."</option>
                                </select> ".__("Transit Layer","wp-google-maps")."

                            </td>
                        </tr>
                        <tr>

                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td>".__("KML/GeoRSS URL","wp-google-maps").":</td>
                            <td>
                             <input id='wpgmza_kml' name='wpgmza_kml' type='text' size='100' maxlength='700' class='regular-text' value='".$res->kml."' /> <em><small>".__("The KML/GeoRSS layer will over-ride most of your map settings","wp-google-maps")."</small></em></td>
                            </td>
                        </tr>
                        <tr>
                            <td>".__("Fusion table ID","wp-google-maps").":</td>
                            <td>
                             <input id='wpgmza_fusion' name='wpgmza_fusion' type='text' size='20' maxlength='200' class='small-text' value='".$res->fusion."' /> <em><small>".__("Read data directly from your Fusion Table. For more information, see <a href='http://googlemapsmania.blogspot.com/2010/05/fusion-tables-google-maps-api.html'>http://googlemapsmania.blogspot.com/2010/05/fusion-tables-google-maps-api.html</a>","wp-google-maps")."</small></em></td>
                            </td>
                        </tr>
                        </table>
                            

            
    
                </div>                
            </div> <!-- end of tab2 -->       






                <p class='submit'><input type='submit' name='wpgmza_savemap' class='button-primary' value='".__("Save Map","wp-google-maps")." &raquo;' /></p>
                <p style=\"width:600px; color:#808080;\">
                    ".__("Tip: Use your mouse to change the layout of your map. When you have positioned the map to your desired location, press \"Save Map\" to keep your settings.","wp-google-maps")."</p>

                
                <div id=\"wpgmza_map\">
                    <div class=\"wpgm_notice_message\" style='text-align:center;'>
                        <ul>
                            <li><h1>".__("The map could not load.","wp-google-maps")."</h1><p>".__("This is normally caused by a conflict with another plugin or a JavaScript error that is preventing our plugin's Javascript from executing. Please try disable all plugins one by one and see if this problem persists. If it persists, please contact nick@wpgmaps.com for support.","wp-google-maps")."</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id=\"wpgmaps_save_reminder\" style=\"display:none;\">
                <div class=\"wpgm_notice_message\" style='text-align:center;'>
                    <ul>
                        <li>
                         <h4>".__("Remember to save your map!","wp-google-maps")."</h4>
                        </li>
                    </ul>
                </div>

                            </div>


                <a name=\"wpgmaps_marker\" /></a>

                <div id=\"wpgmaps_tabs_markers\">
                <ul>
                        <li><a href=\"#tabs-m-1\" class=\"tabs-m-1\">".__("Markers","wp-google-maps")."</a></li>
                        <li><a href=\"#tabs-m-2\" class=\"tabs-m-2\">".__("Polygons","wp-google-maps")."</a></li>
                        <li><a href=\"#tabs-m-3\" class=\"tabs-m-3\">".__("Polylines","wp-google-maps")."</a></li>
                </ul>
                <div id=\"tabs-m-1\">


                    <h2 style=\"padding-top:0; margin-top:0;\">".__("Add a marker","wp-google-maps")."</h2>
                    <input type=\"hidden\" name=\"wpgmza_edit_id\" id=\"wpgmza_edit_id\" value=\"\" />
                    <p>
                    <table>
                    <tr>
                        <td>".__("Title","wp-google-maps").": </td>
                        <td><input id='wpgmza_add_title' name='wpgmza_add_title' type='text' size='35' maxlength='200' value='' /> &nbsp;<br /></td>

                    </tr>
                    <tr>
                        <td>".__("Address/GPS","wp-google-maps").": </td>
                        <td><input id='wpgmza_add_address' name='wpgmza_add_address' type='text' size='35' maxlength='200' value='' /> &nbsp;<br /></td>

                    </tr>

                    <tr><td valign='top'>".__("Description","wp-google-maps").": </td>
                    <td><textarea id='wpgmza_add_desc' name='wpgmza_add_desc'  rows='3' cols='37'></textarea>  &nbsp;<br /></td></tr>
                    <tr><td>".__("Pic URL","wp-google-maps").": </td>
                    <td><input id='wpgmza_add_pic' name=\"wpgmza_add_pic\" type='text' size='35' maxlength='700' value='' /> <input id=\"upload_image_button\" type=\"button\" value=\"".__("Upload Image","wp-google-maps")."\"  /> &nbsp; <small><i>(".__("Or paste image URL","wp-google-maps").")</i></small><br /></td></tr>
                    <tr><td>".__("Link URL","wp-google-maps").": </td>
                        <td><input id='wpgmza_link_url' name='wpgmza_link_url' type='text' size='35' maxlength='700' value=''  /><small><i> ".__("Format: http://www.domain.com","wp-google-maps")."</i></small><br /></td></tr>
                    <tr><td>".__("Custom Marker","wp-google-maps").": </td>
                    <td><span id=\"wpgmza_cmm\"></span><input id='wpgmza_add_custom_marker' name=\"wpgmza_add_custom_marker\" type='hidden' size='35' maxlength='700' value='' /> <input id=\"upload_custom_marker_button\" type=\"button\" value=\"".__("Upload Image","wp-google-maps")."\"  /> &nbsp; <small><i>(".__("ignore if you want to use the default marker","wp-google-maps").")</i></small><br /></td></tr>
                    <tr>
                        <td>".__("Category","wp-google-maps").": </td>
                        <td>
                            <select name=\"wpgmza_category\" id=\"wpgmza_category\">
                                ".wpgmza_pro_return_category_select_list($_GET['map_id'])."
                        </td>
                    </tr>
                    <tr>
                        <td>".__("Animation","wp-google-maps").": </td>
                        <td>
                            <select name=\"wpgmza_animation\" id=\"wpgmza_animation\">
                                <option value=\"0\">".__("None","wp-google-maps")."</option>
                                <option value=\"1\">".__("Bounce","wp-google-maps")."</option>
                                <option value=\"2\">".__("Drop","wp-google-maps")."</option>
                        </td>
                    </tr>
                    <tr>
                        <td>".__("InfoWindow open by default","wp-google-maps").": </td>
                        <td>
                            <select name=\"wpgmza_infoopen\" id=\"wpgmza_infoopen\">
                                <option value=\"0\">".__("No","wp-google-maps")."</option>
                                <option value=\"1\">".__("Yes","wp-google-maps")."</option>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <span id=\"wpgmza_addmarker_div\"><input type=\"button\" id='wpgmza_addmarker' class='button-primary' value='".__("Add Marker","wp-google-maps")."' /></span> <span id=\"wpgmza_addmarker_loading\" style=\"display:none;\">".__("Adding","wp-google-maps")."...</span>
                            <span id=\"wpgmza_editmarker_div\" style=\"display:none;\"><input type=\"button\" id='wpgmza_editmarker' class='button-primary' value='".__("Save Marker","wp-google-maps")."' /></span><span id=\"wpgmza_editmarker_loading\" style=\"display:none;\">".__("Saving","wp-google-maps")."...</span>
                        </td>
                    </tr>
                    </table>
                    <h2 style=\"padding-top:0; margin-top:0;\">".__("Your Markers","wp-google-maps")."</h2>
                    <div id=\"wpgmza_marker_holder\">
                        ".wpgmza_return_marker_list($_GET['map_id'])."
                    </div>
                </div>
                <div id=\"tabs-m-2\">
                        <h2 style=\"padding-top:0; margin-top:0;\">".__("Add a Polygon","wp-google-maps")."</h2>
                        <span id=\"wpgmza_addpolygon_div\"><a href='".get_option('siteurl')."/wp-admin/admin.php?page=wp-google-maps-menu&action=add_poly&map_id=".$_GET['map_id']."' id='wpgmza_addpoly' class='button-primary' value='".__("Add a New Polygon","wp-google-maps")."' />".__("Add a New Polygon","wp-google-maps")."</a></span>
                        <div id=\"wpgmza_poly_holder\">".wpgmza_b_return_polygon_list($_GET['map_id'])."</div>
                </div>
                <div id=\"tabs-m-3\">
                        <h2 style=\"padding-top:0; margin-top:0;\">".__("Add a Polyline","wp-google-maps")."</h2>
                        <span id=\"wpgmza_addpolyline_div\"><a href='".get_option('siteurl')."/wp-admin/admin.php?page=wp-google-maps-menu&action=add_polyline&map_id=".$_GET['map_id']."' id='wpgmza_addpolyline' class='button-primary' value='".__("Add a New Polyline","wp-google-maps")."' />".__("Add a New Polyline","wp-google-maps")."</a></span>
                        <div id=\"wpgmza_polyline_holder\">".wpgmza_b_return_polyline_list($_GET['map_id'])."</div>
                </div>
            </div>
            </form>

            

            ".wpgmza_return_pro_add_ons()." 
            <p><br /><br />".__("WP Google Maps encourages you to make use of the amazing icons created by Nicolas Mollet's Maps Icons Collection","wp-google-maps")." <a href='http://mapicons.nicolasmollet.com'>http://mapicons.nicolasmollet.com/</a> ".__("and to credit him when doing so.","wp-google-maps")."</p>


            </div>
        </div>
    ";

}
function wpgmaps_action_callback_pro() {
        global $wpdb;
        global $wpgmza_tblname;
        global $wpgmza_tblname_poly;
        global $wpgmza_tblname_polylines;
        $check = check_ajax_referer( 'wpgmza', 'security' );
        $table_name = $wpdb->prefix . "wpgmza";
        
        if ($check == 1) {

            if ($_POST['action'] == "add_marker") {
                  $ins_array = array( 'map_id' => $_POST['map_id'], 'title' => $_POST['title'], 'address' => $_POST['address'], 'description' => $_POST['desc'], 'pic' => $_POST['pic'], 'icon' => $_POST['icon'], 'link' => $_POST['link'], 'lat' => $_POST['lat'], 'lng' => $_POST['lng'], 'anim' => $_POST['anim'], 'category' => $_POST['category'], 'infoopen' => $_POST['infoopen'] );

                  $rows_affected = $wpdb->insert( $table_name, $ins_array );
                   wpgmaps_update_xml_file($_POST['map_id']);
                   echo wpgmza_return_marker_list($_POST['map_id']);
            }
            

            if ($_POST['action'] == "edit_marker") {
                  $desc = $_POST['desc'];
                  $link = $_POST['link'];
                  $pic = $_POST['pic'];
                  $icon = $_POST['icon'];
                  $anim = $_POST['anim'];
                  $category = $_POST['category'];
                  $infoopen = $_POST['infoopen'];
                  $cur_id = intval($_POST['edit_id']);
                  $rows_affected = $wpdb->query("UPDATE $table_name SET `title` = '".$_POST['title']."', `address` = '".$_POST['address']."', `description` = '$desc', `link` = '$link', `icon` = '$icon', `pic` = '$pic', `lat` = '".$_POST['lat']."', `lng` = '".$_POST['lng']."', `anim` = '$anim', `category` = '$category', `infoopen` = '$infoopen' WHERE `id`  = '$cur_id'");
                  wpgmaps_update_xml_file($_POST['map_id']);
                  echo wpgmza_return_marker_list($_POST['map_id']);
           }

            if ($_POST['action'] == "delete_marker") {
                $marker_id = $_POST['marker_id'];
                $wpdb->query(
                        "
                        DELETE FROM $wpgmza_tblname
                        WHERE `id` = '$marker_id'
                        LIMIT 1
                        "
                );
                wpgmaps_update_xml_file($_POST['map_id']);
                echo wpgmza_return_marker_list($_POST['map_id']);

            }
            if ($_POST['action'] == "delete_poly") {
                $poly_id = $_POST['poly_id'];
                
                $wpdb->query(
                        "
                        DELETE FROM $wpgmza_tblname_poly
                        WHERE `id` = '$poly_id'
                        LIMIT 1
                        "
                );
                
                echo wpgmza_b_return_polygon_list($_POST['map_id']);

            }
            if ($_POST['action'] == "delete_polyline") {
                $poly_id = $_POST['poly_id'];
                
                $wpdb->query(
                        "
                        DELETE FROM $wpgmza_tblname_polylines
                        WHERE `id` = '$poly_id'
                        LIMIT 1
                        "
                );
                
                echo wpgmza_b_return_polyline_list($_POST['map_id']);

            }
        }

        die(); // this is required to return a proper result

}
function wpgmza_return_pro_add_ons() {
    $wpgmza_ret = "";
    if (function_exists("wpgmza_register_gold_version")) { $wpgmza_ret .= wpgmza_gold_addon_display(); } else { $wpgmza_ret  .= ""; }
    if (function_exists("wpgmza_register_ugm_version")) { $wpgmza_ret .= wpgmza_ugm_addon_display_mapspage(); } else { $wpgmza_ret  .= ""; }
    return $wpgmza_ret;
}


function wpgmaps_tag_pro( $atts ) {
    global $wpgmza_current_map_id;
    global $wpgmza_current_map_cat_selection;
    global $wpgmza_current_mashup;
    global $wpgmza_mashup_ids;
    global $wpgmza_mashup_all;
    $wpgmza_current_mashup = false;
    extract( shortcode_atts( array(
        'id' => '1',
        'mashup' => false,
        'mashup_ids' => false,
        'cat' => 'all',
        'parent_id' => '1'
    ), $atts ) );


    if (isset($atts['mashup'])) { $wpgmza_mashup = $atts['mashup']; }

    if (isset($wpgmza_mashup_ids) && $wpgmza_mashup_ids == "ALL") {

    } else {
        if (isset($atts['mashup_ids'])) {
            $wpgmza_mashup_ids = explode(",",$atts['mashup_ids']);
        }
    }
    if (isset($atts['parent_id'])) { $wpgmza_mashup_parent_id = $atts['parent_id']; }

    if (isset($wpgmza_mashup)) { $wpgmza_current_mashup = true; }

    if (isset($wpgmza_mashup)) {
        $wpgmza_current_map_id = $wpgmza_mashup_parent_id;
        $res = wpgmza_get_map_data($wpgmza_mashup_parent_id);
    } else {
        $wpgmza_current_map_id = $atts['id'];
        wpgmza_check_if_marker_file_exists($wpgmza_current_map_id);
        $res = wpgmza_get_map_data($atts['id']);
    }
    if (!isset($atts['cat']) || $atts['cat'] == "all" || $atts['cat'] == "0") {
        $wpgmza_current_map_cat_selection[$wpgmza_current_map_id] = 'all';
    } else {
        $wpgmza_current_map_cat_selection[$wpgmza_current_map_id] = explode(",",$atts['cat']);
    }
    


    $wpgmza_general_settings = get_option('WPGMZA_OTHER_SETTINGS');
    $hide_category_column = $wpgmza_general_settings['wpgmza_settings_markerlist_category'];
    $hide_icon_column = $wpgmza_general_settings['wpgmza_settings_markerlist_icon'];
    $hide_title_column = $wpgmza_general_settings['wpgmza_settings_markerlist_title'];
    $hide_address_column = $wpgmza_general_settings['wpgmza_settings_markerlist_address'];
    $hide_description_column = $wpgmza_general_settings['wpgmza_settings_markerlist_description'];
    $filterbycat_type = $wpgmza_general_settings['wpgmza_settings_filterbycat_type'];
    if (!$filterbycat_type) { $filterbycat_type = 1; }
    
    $map_width_type = stripslashes($res->map_width_type);
    $map_height_type = stripslashes($res->map_height_type);
    if (!isset($map_width_type)) { $map_width_type == "px"; }
    if (!isset($map_height_type)) { $map_height_type == "px"; }
    if ($map_width_type == "%" && intval($res->map_width) > 100) { $res->map_width = 100; }
    if ($map_height_type == "%" && intval($res->map_height) > 100) { $res->map_height = 100; }
    $map_align = $res->alignment;
    if (!$map_align || $map_align == "" || $map_align == "1") { $map_align = "float:left;"; }
    else if ($map_align == "2") { $map_align = "margin-left:auto !important; margin-right:auto !important; align:center;"; }
    else if ($map_align == "3") { $map_align = "float:right;"; }
    else if ($map_align == "4") { $map_align = "clear:both;"; }
    $map_style = "style=\"display:block; overflow:auto; width:".$res->map_width."".$map_width_type."; height:".$res->map_height."".$map_height_type."; $map_align\"";
    global $short_code_active;
    $short_code_active = true;
    global $wpgmza_short_code_array;
    $wpgmza_short_code_array[] = $wpgmza_current_map_id;
    $d_enabled = $res->directions_enabled;
    $filterbycat = $res->filterbycat;
    $map_width = $res->map_width;
    $map_width_type = $res->map_width_type;
    // for marker list
    $default_marker = $res->default_marker;
    
    if (isset($res->default_to)) { $default_to = $res->default_to; } else { $default_to = ""; }
    
    $show_location = $res->show_user_location;
    if ($show_location == "1") {
        $use_location_from = "<span style=\"font-size:0.75em;\"><a href='javascript:void(0);' id='wpgmza_use_my_location_from' mid='$wpgmza_current_map_id' title='".__("Use my location","wp-google-maps")."'>".__("Use my location","wp-google-maps")."</a></span>";
        $use_location_to = "<span style=\"font-size:0.75em;\"><a href='javascript:void(0);' id='wpgmza_use_my_location_to' mid='$wpgmza_current_map_id' title='".__("Use my location","wp-google-maps")."'>".__("Use my location","wp-google-maps")."</a></span>";
    } else {
        $use_location_from = "";
        $use_location_to = "";
    }
    if ($default_marker) { $default_marker = "<img src='".$default_marker."' />"; } else { $default_marker = "<img src='".wpgmaps_get_plugin_url()."/images/marker.png' />"; }
    $dbox_width = $res->dbox_width;
    $dbox_option = $res->dbox;
    if ($dbox_option == "1") { $dbox_style = "display:none;"; }
    else if ($dbox_option == "2") { $dbox_style = "float:left; width:".$dbox_width."px; padding-right:10px; display:block; overflow:auto;"; }
    else if ($dbox_option == "3") { $dbox_style = "float:right; width:".$dbox_width."px; padding-right:10px; display:block; overflow:auto;"; }
    else if ($dbox_option == "4") { $dbox_style = "float:none; width:".$dbox_width."px; padding-bottom:10px; display:block; overflow:auto; clear:both;"; }
    else if ($dbox_option == "5") { $dbox_style = "float:none; width:".$dbox_width."px; padding-top:10px; display:block; overflow:auto; clear:both;"; }
    else { $dbox_style = "display:none;"; }
    $wpgmza_marker_list_output = "";
    $wpgmza_marker_filter_output = "";
    // Filter by category
    
    
    
    if ($filterbycat == 1) {
    
        
        
        if ($filterbycat_type == "1") {
            $wpgmza_marker_filter_output .= "<p style='text-align:left; margin-bottom:0px;'>".__("Filter by","wp-google-maps")."";
            $wpgmza_filter_dropdown = wpgmza_pro_return_category_select_list($wpgmza_current_map_id);
            $wpgmza_marker_filter_output .= "<select mid=\"".$wpgmza_current_map_id."\" name=\"wpgmza_filter_select\" id=\"wpgmza_filter_select\">";
            $wpgmza_marker_filter_output .= $wpgmza_filter_dropdown;
            $wpgmza_marker_filter_output .= "</select></p>";
        } else if ($filterbycat_type == "2") {
            $wpgmza_marker_filter_output .= "<p style='text-align:left; margin-bottom:0px;'>".__("Filter by","wp-google-maps")."</p>";
            $wpgmza_marker_filter_output .= "<div style=\"display:block; width:100%; height:auto; margin-top:10px;\">";
            $wpgmza_marker_filter_output .= "<div style=\"display:block; float:left; width:400px;\">    ";
            $wpgmza_marker_filter_output .= wpgmza_pro_return_category_checkbox_list($wpgmza_current_map_id);
            $wpgmza_marker_filter_output .= "</div>";
            $wpgmza_marker_filter_output .= "</div>";
            
        } else {
            $wpgmza_marker_filter_output .= "<p style='text-align:left; margin-bottom:0px;'>".__("Filter by","wp-google-maps")."";
            $wpgmza_filter_dropdown = wpgmza_pro_return_category_select_list($wpgmza_current_map_id);
            $wpgmza_marker_filter_output .= "<select mid=\"".$wpgmza_current_map_id."\" name=\"wpgmza_filter_select\" id=\"wpgmza_filter_select\">";
            $wpgmza_marker_filter_output .= $wpgmza_filter_dropdown;
            $wpgmza_marker_filter_output .= "</select></p>";
        }
    } 
    $wpgmza_marker_datatables_output = "";
    if ($hide_category_column == "yes") { $wpgmza_marker_datatables_output .= "<style>.wpgmza_table_category { display: none !important; }</style>"; }
    if ($hide_icon_column == "yes") { $wpgmza_marker_datatables_output .= "<style>.wpgmza_table_marker { display: none; }</style>"; }
    if ($hide_title_column == "yes") { $wpgmza_marker_datatables_output .= "<style>.wpgmza_table_title { display: none; }</style>"; }
    if ($hide_address_column == "yes") { $wpgmza_marker_datatables_output .= "<style>.wpgmza_table_address { display: none; }</style>"; }
    if ($hide_description_column == "yes") { $wpgmza_marker_datatables_output .= "<style>.wpgmza_table_description { display: none; }</style>"; }
    
    
    
    $map_other_settings = maybe_unserialize($res->other_settings);
    $sl_data = "";
    if ($map_other_settings['store_locator_enabled'] == 1) {
        $sl_data = wpgmaps_sl_user_output_basic($wpgmza_current_map_id);
        $wpgmza_marker_filter_output = "";
    } else { $sl_data = ""; }

    // GET LIST OF MARKERS

    if ($res->listmarkers == 1 && $res->listmarkers_advanced == 1) {
        if ($wpgmza_current_mashup) {
            $wpgmza_marker_list_output .= wpgmza_return_marker_list($wpgmza_mashup_parent_id,false,$map_width.$map_width_type,$wpgmza_current_mashup,$wpgmza_mashup_ids);
        } else {
            $wpgmza_marker_list_output .= wpgmza_return_marker_list($wpgmza_current_map_id,false,$map_width.$map_width_type,false);
        }
    }
    else if ($res->listmarkers == 1 && $res->listmarkers_advanced == 0) {

        global $wpdb;
        global $wpgmza_tblname;

        // marker sorting functionality
        if ($res->order_markers_by == 1) { $order_by = "id"; }
        else if ($res->order_markers_by == 2) { $order_by = "title"; }
        else if ($res->order_markers_by == 3) { $order_by = "address"; }
        else if ($res->order_markers_by == 4) { $order_by = "description"; }
        else if ($res->order_markers_by == 5) { $order_by = "category"; }
        else { $order_by = "id"; }
        if ($res->order_markers_choice == 1) { $order_choice = "ASC"; }
        else { $order_choice = "DESC"; }

        if ($wpgmza_current_mashup) {

            $wpgmza_cnt = 0;
            $sql_string1 = "";
            if ($wpgmza_mashup_ids[0] == "ALL") {
                $wpgmza_sql1 ="SELECT * FROM $wpgmza_tblname ORDER BY `$order_by` $order_choice";
            } else {
                $wpgmza_id_cnt = count($wpgmza_mashup_ids);
                foreach ($wpgmza_mashup_ids as $wpgmza_map_id) {
                    $wpgmza_cnt++;
                    if ($wpgmza_cnt == 1) { $sql_string1 .= "`map_id` = '$wpgmza_map_id' "; }
                    elseif ($wpgmza_cnt > 1 && $wpgmza_cnt < $wpgmza_id_cnt) { $sql_string1 .= "OR `map_id` = '$wpgmza_map_id' "; }
                    else { $sql_string1 .= "OR `map_id` = '$wpgmza_map_id' "; }

                }
                $wpgmza_sql1 ="SELECT * FROM $wpgmza_tblname WHERE $sql_string1 ORDER BY `$order_by` $order_choice";
            }
        } else {
            $wpgmza_sql1 ="SELECT * FROM $wpgmza_tblname WHERE `map_id` = '$wpgmza_current_map_id' ORDER BY `$order_by` $order_choice";
        }

        $results = $wpdb->get_results($wpgmza_sql1);


        $wpgmza_marker_list_output .= "
                <div class='verticalScroll' style='position: relative;'><table id=\"wpgmza_marker_list\" class=\"wpgmza_marker_list_class\" cellspacing=\"0\" cellpadding=\"0\" style='width:".$map_width."".$map_width_type."'>
                <tbody>
        ";


        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
        $wpgmza_image_height = $wpgmza_settings['wpgmza_settings_image_height'];
        $wpgmza_image_width = $wpgmza_settings['wpgmza_settings_image_width'];
        if (!$wpgmza_image_height || !isset($wpgmza_image_height)) { $wpgmza_image_height = "100"; }
        if (!$wpgmza_image_width || !isset($wpgmza_image_width)) { $wpgmza_image_width = "100"; }
        foreach ( $results as $result ) {
            $wmcnt++;
            $img = $result->pic;
            $wpgmaps_id = $result->id;
            $link = $result->link;
            $icon = $result->icon;
            $wpgmaps_lat = $result->lat;
            $wpgmaps_lng = $result->lng;
            $wpgmaps_address = $result->address;

            if (!$img) { $pic = ""; } else {
                $wpgmza_use_timthumb = $wpgmza_settings['wpgmza_settings_use_timthumb'];
                if ($wpgmza_use_timthumb == "" || !isset($wpgmza_use_timthumb)) {
                    $pic = "<img src='".wpgmaps_get_plugin_url()."/timthumb.php?src=".$result->pic."&h=".$wpgmza_image_height."&w=".$wpgmza_image_width."&zc=1' title='' alt='' style=\"\" />";
                } else  {
                    $pic = "<img src='".$result->pic."' class='wpgmza_map_image' style=\"float:right; margin:5px; height:".$wpgmza_image_height."px; width:".$wpgmza_image_width.".px\" />";
                }
            }
            if (!$icon) { $icon = $default_marker; } else { $icon = "<img src='".$result->icon."' />"; }
            if ($d_enabled == "1") {
                $wpgmaps_dir_text = "<br /><a href=\"javascript:void(0);\" id=\"$wpgmza_current_map_id\" title=\"".__("Get directions to","wp-google-maps")." ".$result->title."\" class=\"wpgmza_gd\" wpgm_addr_field=\"".$wpgmaps_address."\" gps=\"$wpgmaps_lat,$wpgmaps_lng\">".__("Directions","wp-google-maps")."</a>";
            }
            if ($result->description) {
                $wpgmaps_desc_text = "<br />".$result->description."";
            } else {
                $wpgmaps_desc_text = "";
            }
            if ($wmcnt%2) { $oddeven = "wpgmaps_odd"; } else { $oddeven = "wpgmaps_even"; }

            
            
            $wpgmza_marker_list_output .= "
                <tr id=\"wpgmza_marker_".$result->id."\" mid=\"".$result->id."\" mapid=\"".$result->map_id."\" class=\"wpgmaps_mlist_row $oddeven\">
                    <td height=\"40\" class=\"wpgmaps_mlist_marker\">".$icon."</td>
                    <td class=\"wpgmaps_mlist_pic\" style=\"width:".($wpgmza_image_width+20)."px;\">$pic</td>
                    <td  valign=\"top\" align=\"left\" class=\"wpgmaps_mlist_info\">
                        <strong><a href=\"javascript:openInfoWindow($wpgmaps_id);\" id=\"wpgmaps_marker_$wpgmaps_id\" title=\"".$result->title."\">".$result->title."</a></strong>
                        $wpgmaps_desc_text
                        $wpgmaps_dir_text
                    </td>

                </tr>";
        }
        $wpgmza_marker_list_output .= "</tbody></table></div>";

    } else { $wpgmza_marker_list_output = ""; }


    $dbox_div = "
        <div id=\"wpgmaps_directions_edit_".$wpgmza_current_map_id."\" style=\"$dbox_style\" class=\"wpgmaps_directions_outer_div\">
            <h2>".__("Get Directions","wp-google-maps")."</h2>
            <div id=\"wpgmaps_directions_editbox_".$wpgmza_current_map_id."\">
                <table>
                    <tr>
                        <td>".__("For","wp-google-maps").":</td><td>
                            <select id=\"wpgmza_dir_type_".$wpgmza_current_map_id."\" name=\"wpgmza_dir_type_".$wpgmza_current_map_id."\">
                            <option value=\"DRIVING\" selected=\"selected\">".__("Driving","wp-google-maps")."</option>
                            <option value=\"WALKING\">".__("Walking","wp-google-maps")."</option>
                            <option value=\"BICYCLING\">".__("Bicycling","wp-google-maps")."</option>
                            </select>
                            &nbsp;
                            <a href=\"javascript:void(0);\" mapid=\"".$wpgmza_current_map_id."\" id=\"wpgmza_show_options_".$wpgmza_current_map_id."\" onclick=\"wpgmza_show_options(".$wpgmza_current_map_id.");\" style=\"font-size:10px;\">".__("show options","wp-google-maps")."</a>
                            <a href=\"javascript:void(0);\" mapid=\"".$wpgmza_current_map_id."\" id=\"wpgmza_hide_options_".$wpgmza_current_map_id."\" onclick=\"wpgmza_hide_options(".$wpgmza_current_map_id.");\" style=\"font-size:10px; display:none;\">".__("hide options","wp-google-maps")."</a>
                        <div style=\"display:none\" id=\"wpgmza_options_box_".$wpgmza_current_map_id."\">
                            <input type=\"checkbox\" id=\"wpgmza_tolls_".$wpgmza_current_map_id."\" name=\"wpgmza_tolls_".$wpgmza_current_map_id."\" value=\"tolls\" /> ".__("Avoid Tolls","wp-google-maps")." <br />
                            <input type=\"checkbox\" id=\"wpgmza_highways_".$wpgmza_current_map_id."\" name=\"wpgmza_highways_".$wpgmza_current_map_id."\" value=\"highways\" /> ".__("Avoid Highways","wp-google-maps")."
                        </div>

                        </td>
                    </tr>
                    <tr><td>".__("From","wp-google-maps").":</td><td width='90%'><input type=\"text\" value=\"\" id=\"wpgmza_input_from_".$wpgmza_current_map_id."\" style='width:80%' /> $use_location_from</td></tr>
                    <tr><td>".__("To","wp-google-maps").":</td><td width='90%'><input type=\"text\" value=\"$default_to\" id=\"wpgmza_input_to_".$wpgmza_current_map_id."\" style='width:80%' /> $use_location_to</td></tr>
                    <tr>

                      <td>
                        </td><td>
                      <input onclick=\"javascript:void(0);\" class=\"wpgmaps_get_directions\" id=\"".$wpgmza_current_map_id."\" type=\"button\" value=\"".__("Go","wp-google-maps")."\"/>
                      </td>
                    </tr>
                </table>
            </div>


    ";


    if ($dbox_option == "5" || $dbox_option == "1" || !isset($dbox_option)) {
        

        if ($wpgmza_current_mashup) {
            $wpgmza_anchors = $wpgmza_mashup_ids;
        } else {
            $wpgmza_anchors = $wpgmza_current_map_id;
        }
        

        $ret_msg = "
            $wpgmza_marker_datatables_output
            <style>
            .wpgmza_map img { max-width:none !important; }
            </style>
            ".wpgmaps_return_marker_anchors($wpgmza_anchors)."
            $wpgmza_marker_filter_output
            $sl_data
            <div id=\"wpgmza_map_".$wpgmza_current_map_id."\" class='wpgmza_map' $map_style>&nbsp;</div>
            $wpgmza_marker_list_output
            <div id=\"display:block; width:100%;\">

                $dbox_div
                    <div id=\"wpgmaps_directions_notification_".$wpgmza_current_map_id."\" style=\"display:none;\">".__("Fetching directions...","wp-google-maps")."...</div>
                    <div id=\"wpgmaps_directions_reset_".$wpgmza_current_map_id."\" style=\"display:none;\"><a href='javascript:void(0)' onclick='wpgmza_reset_directions(".$wpgmza_current_map_id.");' id='wpgmaps_reset_directions' title='".__("Reset directions","wp-google-maps")."'>".__("Reset directions","wp-google-maps")."</a></div>
                    <div id=\"directions_panel_".$wpgmza_current_map_id."\"></div>
                </div>
            </div>

        ";
    } else {
        if ($wpgmza_current_mashup) {
            $wpgmza_anchors = $wpgmza_mashup_ids;
        } else {
            $wpgmza_anchors = $wpgmza_current_map_id;
        }
        
        $ret_msg = "
            $wpgmza_marker_datatables_output
            <style>
            .wpgmza_map img { max-width:none !important; }
            </style>
            
            <div id=\"display:block; width:100%; overflow:auto;\">

                $dbox_div
                    <div id=\"wpgmaps_directions_notification_".$wpgmza_current_map_id."\" style=\"display:none;\">".__("Fetching directions...","wp-google-maps")."...</div>
                    <div id=\"wpgmaps_directions_reset_".$wpgmza_current_map_id."\" style=\"display:none;\"><a href='javascript:void(0)' onclick='wpgmza_reset_directions(".$wpgmza_current_map_id.");' id='wpgmaps_reset_directions' title='".__("Reset directions","wp-google-maps")."'>".__("Reset directions","wp-google-maps")."</a></div>
                    <div id=\"directions_panel_".$wpgmza_current_map_id."\"></div>
                </div>
                
                

                $wpgmza_marker_filter_output
                $sl_data

            ".wpgmaps_return_marker_anchors($wpgmza_anchors)."
                
            <div id=\"wpgmza_map_".$wpgmza_current_map_id."\" class='wpgmza_map' $map_style>
                <div style='text-align:center; width:90%; border:1px solid #ccc; padding:10px;'>
                    <h1>".__("The map could not load.","wp-google-maps")."</h1><p>".__("This is normally caused by a conflict with another plugin or a JavaScript error that is preventing our plugin's Javascript from executing. Please try disable all plugins one by one and see if this problem persists. If it persists, please contact nick@wpgmaps.com for support.","wp-google-maps")."</p>
                    
                </div>
            </div>

            $wpgmza_marker_list_output
            </div>

        ";

    }

    if (function_exists("wpgmza_register_ugm_version")) {
        $ugm_enabled = $res->ugm_enabled;
        if ($ugm_enabled == 1) {
            $ret_msg .= wpgmaps_ugm_user_form($wpgmza_current_map_id);
        }
    }

    return $ret_msg;
}

function wpgmaps_return_marker_anchors($mid) {
    global $wpdb;
    global $wpgmza_tblname;



    if (is_array($mid)) {
        $wpgmza_cnt = 0;
        $sql_string1 = "";

        if ($mid[0] == "ALL") {
            $results = $wpdb->get_results("
                SELECT *
                FROM $wpgmza_tblname
                ORDER BY `id` DESC
            ");
        } else {

            $wpgmza_id_cnt = count($mid);
            foreach ($mid as $wpgmza_map_id) {
                $wpgmza_cnt++;
                if ($wpgmza_cnt == 1) { $sql_string1 .= "`map_id` = '$wpgmza_map_id' "; }
                elseif ($wpgmza_cnt > 1 && $wpgmza_cnt < $wpgmza_id_cnt) { $sql_string1 .= "OR `map_id` = '$wpgmza_map_id' "; }
                else { $sql_string1 .= "OR `map_id` = '$wpgmza_map_id' "; }

            }
            $results = $wpdb->get_results("
                SELECT *
                FROM $wpgmza_tblname
                WHERE $sql_string1 ORDER BY `id` DESC
            ");
        }
    } else {
        $results = $wpdb->get_results("
            SELECT *
            FROM $wpgmza_tblname
            WHERE `map_id` = '$mid' ORDER BY `id` DESC
        ");
    }







    

    $wpmlist = "";
    foreach ( $results as $result ) {
        $marker_id = $result->id;
        $wpmlist .= "<a name='marker".$marker_id."' ></a>";
    }
    return $wpmlist;
    
    
}
function wpgmza_return_all_map_ids() {
    global $wpdb;
    global $wpgmza_tblname_maps;
    $sql = "SELECT `id` FROM `".$wpgmza_tblname_maps."`";
    $results = $wpdb->get_results($sql);
    $tarr = array();
    foreach ($results as $result) {
        array_push($tarr,$result->id);
    }
    return $tarr;

}

function wpgmaps_user_javascript_pro() {


    global $short_code_active;
    global $wpgmza_count;
    $wpgmza_count++;
    if ($wpgmza_count >1) {  } else {
    global $wpgmza_current_map_id;
    global $wpgmza_short_code_array;
    global $wpgmza_current_mashup;
    
    global $wpgmza_current_map_cat_selection;
    
    if ($wpgmza_current_mashup) { $wpgmza_current_mashup_string = "true"; } else { $wpgmza_current_mashup_string = "false"; }
    
    global $wpgmza_mashup_ids;
    if (isset($wpgmza_mashup_ids)) {
        if ($wpgmza_mashups_ids == "ALL") {
            $wpgmza_mashup_ids = wpgmza_return_all_map_ids();
        }
    }

    
    if ($short_code_active) {
        
       
        
        $ajax_nonce = wp_create_nonce("wpgmza");
            wp_register_script('wpgmaps_datatables', wpgmaps_get_plugin_url()."/js/jquery.dataTables.js", true);
            wp_enqueue_script( 'wpgmaps_datatables' );

            wp_register_style('wpgmaps_datatables_style', wpgmaps_get_plugin_url()."/css/data_table_front.css");
            wp_enqueue_style( 'wpgmaps_datatables_style' );


            
            $res = array();
            if (isset($wpgmza_short_code_array)) {
                foreach ($wpgmza_short_code_array as $wpgmza_cmd) {
                    $res[$wpgmza_cmd] = wpgmza_get_map_data($wpgmza_cmd);
                    if ($res[$wpgmza_cmd]->styling_json != '') {
                        $res[$wpgmza_cmd]->styling_json = html_entity_decode(stripslashes($res[$wpgmza_cmd]->styling_json));
                    }
                    if ($res[$wpgmza_cmd]->other_settings != '') {
                        $res[$wpgmza_cmd]->other_settings = $other_settings = maybe_unserialize($res[$wpgmza_cmd]->other_settings);
                    }
                    $res[$wpgmza_cmd]->map_width_type = stripslashes($res[$wpgmza_cmd]->map_width_type);

                }
            }
            //var_dump($wpgmza_parse_variables);
            $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
            
            if (function_exists("wpgmaps_gold_activate")) {
                wp_register_script('wpgmaps_user_marker_clusterer_js', wpgmaps_get_plugin_url() .'/js/markerclusterer.js',array(),"1.0",false);
                wp_enqueue_script( 'wpgmaps_user_marker_clusterer_js' );
                
            }
            global $wpgmza_pro_version;
            wp_enqueue_script('wpgmaps_core', plugins_url('wp-google-maps-pro') .'/js/core.js', array(), $wpgmza_pro_version.'p' , false);
            
            
            if (function_exists("wpgmaps_ugm_activate")) {
                global $wpgmza_ugm_version;
                wp_enqueue_script('wpgmaps_ugm_core', plugins_url('wp-google-maps-ugm') .'/js/ugm-core.js', array(), $wpgmza_ugm_version.'vgm' , false);
            }
            
            if (function_exists("wpgmaps_sl_activate")) {
                global $wpgmza_sl_version;
                wp_enqueue_script('wpgmaps_sl_core', plugins_url('wp-google-maps-store-locator') .'/js/sl-core.js', array(), $wpgmza_sl_version.'sl' , false);
            }

            wp_localize_script( 'wpgmaps_core', 'wpgmaps_localize', $res);
            wp_localize_script( 'wpgmaps_core', 'wpgmaps_localize_mashup_ids', $wpgmza_mashup_ids);
            wp_localize_script( 'wpgmaps_core', 'wpgmaps_localize_cat_ids', $wpgmza_current_map_cat_selection);
            wp_localize_script( 'wpgmaps_core', 'wpgmaps_localize_global_settings', $wpgmza_settings);
            
            
            
            
            
            
            
            
            // get polyline and polygon settings and localize it
            $polygonoptions = array();
            if (isset($wpgmza_short_code_array)) {

                foreach ($wpgmza_short_code_array as $wpgmza_cmd) {
                    if ($wpgmza_current_mashup) {
                         foreach ($wpgmza_mashup_ids as $wpgmza_tmp_plg) {
                            $total_poly_array = wpgmza_b_return_polygon_id_array($wpgmza_tmp_plg);
                            if ($total_poly_array > 0) {
                                foreach ($total_poly_array as $poly_id) {
                                    $polygonoptions[$wpgmza_cmd][$poly_id] = wpgmza_b_return_poly_options($poly_id);

                                    $tmp_poly_array = wpgmza_b_return_polygon_array($poly_id);
                                    $poly_data_raw_array = array();
                                    foreach ($tmp_poly_array as $single_poly) {
                                        $poly_data_raw = str_replace(" ","",$single_poly);
                                        $poly_data_raw = explode(",",$poly_data_raw);
                                        $lat = $poly_data_raw[0];
                                        $lng = $poly_data_raw[1];
                                        $poly_data_raw_array[] = $poly_data_raw;
                                    }
                                    $polygonoptions[$wpgmza_cmd][$poly_id]->polydata = $poly_data_raw_array;

                                    $linecolor = $polygonoptions[$wpgmza_cmd][$poly_id]->linecolor;
                                    $fillcolor = $polygonoptions[$wpgmza_cmd][$poly_id]->fillcolor;
                                    $fillopacity = $polygonoptions[$wpgmza_cmd][$poly_id]->opacity;
                                    if (!$linecolor) { $polygonoptions[$wpgmza_cmd][$poly_id]->linecolor = "000000"; }
                                    if (!$fillcolor) { $polygonoptions[$wpgmza_cmd][$poly_id]->fillcolor = "66FF00"; }
                                    if (!$fillopacity) { $polygonoptions[$wpgmza_cmd][$poly_id]->opacity = "0.5"; }
                                }
                            }
                         }
                        } else {
                             $total_poly_array = wpgmza_b_return_polygon_id_array($wpgmza_cmd);

                            if ($total_poly_array > 0) {
                                foreach ($total_poly_array as $poly_id) {
                                    $polygonoptions[$wpgmza_cmd][$poly_id] = wpgmza_b_return_poly_options($poly_id);

                                    $tmp_poly_array = wpgmza_b_return_polygon_array($poly_id);
                                    $poly_data_raw_array = array();
                                    foreach ($tmp_poly_array as $single_poly) {
                                        $poly_data_raw = str_replace(" ","",$single_poly);
                                        $poly_data_raw = explode(",",$poly_data_raw);
                                        $lat = $poly_data_raw[0];
                                        $lng = $poly_data_raw[1];
                                        $poly_data_raw_array[] = $poly_data_raw;
                                    }
                                    $polygonoptions[$wpgmza_cmd][$poly_id]->polydata = $poly_data_raw_array;

                                    $linecolor = $polygonoptions[$wpgmza_cmd][$poly_id]->linecolor;
                                    $fillcolor = $polygonoptions[$wpgmza_cmd][$poly_id]->fillcolor;
                                    $fillopacity = $polygonoptions[$wpgmza_cmd][$poly_id]->opacity;
                                    if (!$linecolor) { $polygonoptions[$wpgmza_cmd][$poly_id]->linecolor = "000000"; }
                                    if (!$fillcolor) { $polygonoptions[$wpgmza_cmd][$poly_id]->fillcolor = "66FF00"; }
                                    if (!$fillopacity) { $polygonoptions[$wpgmza_cmd][$poly_id]->opacity = "0.5"; }
                                }
                            }  else { $polygonoptions = array(); }     
                        }
                }
                $polylineoptions = array();
                foreach ($wpgmza_short_code_array as $wpgmza_cmd) {
                    if ($wpgmza_current_mashup) {
                         foreach ($wpgmza_mashup_ids as $wpgmza_tmp_plg) {
                            $total_poly_array = wpgmza_b_return_polyline_id_array($wpgmza_tmp_plg);
                            if ($total_poly_array > 0) {
                                foreach ($total_poly_array as $poly_id) {
                                    $polylineoptions[$wpgmza_cmd][$poly_id] = wpgmza_b_return_polyline_options($poly_id);

                                    $tmp_poly_array = wpgmza_b_return_polyline_array($poly_id);
                                    $poly_data_raw_array = array();
                                    foreach ($tmp_poly_array as $single_poly) {
                                        $poly_data_raw = str_replace(" ","",$single_poly);
                                        $poly_data_raw = explode(",",$poly_data_raw);
                                        $lat = $poly_data_raw[0];
                                        $lng = $poly_data_raw[1];
                                        $poly_data_raw_array[] = $poly_data_raw;
                                    }
                                    $polylineoptions[$wpgmza_cmd][$poly_id]->polydata = $poly_data_raw_array;


                                    $linecolor = $polylineoptions[$wpgmza_cmd][$poly_id]->linecolor;
                                    $fillcolor = $polylineoptions[$wpgmza_cmd][$poly_id]->fillcolor;
                                    $fillopacity = $polylineoptions[$wpgmza_cmd][$poly_id]->opacity;
                                    if (!$linecolor) { $polylineoptions[$wpgmza_cmd][$poly_id]->linecolor = "000000"; }
                                    if (!$fillcolor) { $polylineoptions[$wpgmza_cmd][$poly_id]->fillcolor = "66FF00"; }
                                    if (!$fillopacity) { $polylineoptions[$wpgmza_cmd][$poly_id]->opacity = "0.5"; }
                                }
                            } 
                         }
                        } else {
                             $total_poly_array = wpgmza_b_return_polyline_id_array($wpgmza_cmd);
                            if ($total_poly_array > 0) {
                                foreach ($total_poly_array as $poly_id) {
                                    $polylineoptions[$wpgmza_cmd][$poly_id] = wpgmza_b_return_polyline_options($poly_id);

                                    $tmp_poly_array = wpgmza_b_return_polyline_array($poly_id);
                                    $poly_data_raw_array = array();
                                    foreach ($tmp_poly_array as $single_poly) {
                                        $poly_data_raw = str_replace(" ","",$single_poly);
                                        $poly_data_raw = explode(",",$poly_data_raw);
                                        $lat = $poly_data_raw[0];
                                        $lng = $poly_data_raw[1];
                                        $poly_data_raw_array[] = $poly_data_raw;
                                    }
                                    $polylineoptions[$wpgmza_cmd][$poly_id]->polydata = $poly_data_raw_array;


                                    $linecolor = $polylineoptions[$wpgmza_cmd][$poly_id]->linecolor;
                                    $fillcolor = $polylineoptions[$wpgmza_cmd][$poly_id]->fillcolor;
                                    $fillopacity = $polylineoptions[$wpgmza_cmd][$poly_id]->opacity;
                                    if (!$linecolor) { $polylineoptions[$wpgmza_cmd][$poly_id]->linecolor = "000000"; }
                                    if (!$fillcolor) { $polylineoptions[$wpgmza_cmd][$poly_id]->fillcolor = "66FF00"; }
                                    if (!$fillopacity) { $polylineoptions[$wpgmza_cmd][$poly_id]->opacity = "0.5"; }
                                }
                            } else { $polylineoptions = array(); }       
                        }
                }
            }
            
            wp_localize_script( 'wpgmaps_core', 'wpgmaps_localize_polygon_settings', $polygonoptions);
            wp_localize_script( 'wpgmaps_core', 'wpgmaps_localize_polyline_settings', $polylineoptions);
            $api_version = $wpgmza_settings['wpgmza_api_version'];
            if (isset($api_version) && $api_version != "") {
                $api_version_string = "v=$api_version&";
            } else {
                $api_version_string = "v=3.14&";
            }
            
        
            
        ?>
        <script type="text/javascript">
            if (typeof window.google === 'object' && typeof window.google.maps === 'object') { } else {
                var gmapsJsHost = (("https:" == document.location.protocol) ? "https://" : "http://");
                document.write(unescape("%3Cscript src='" + gmapsJsHost + "maps.google.com/maps/api/js?<?php echo $api_version_string; ?>sensor=false&libraries=weather' type='text/javascript'%3E%3C/script%3E"));
            }
        </script>
        
        <script type="text/javascript" >
            wpgmaps_map_mashup = <?php echo $wpgmza_current_mashup_string; ?>;
            wpgmaps_plugurl = '<?php echo wpgmaps_get_plugin_url(); ?>';

            <?php 
            global $wpgmza_version;
            if (floatval($wpgmza_version) < 6 || $wpgmza_version == "6.0.4" || $wpgmza_version == "6.0.3" || $wpgmza_version == "6.0.2" || $wpgmza_version == "6.0.1" || $wpgmza_version == "6.0.0") {
                if (is_multisite()) { 
                    global $blog_id;
                    $wurl = wpgmaps_get_plugin_url()."/".$blog_id."-";
                }
                else {
                    $wurl = wpgmaps_get_plugin_url()."/";
                }
            } else {
                /* later versions store marker files in wp-content/uploads/wp-google-maps director */
                if (is_multisite()) { 
                    $upload_dir = wp_upload_dir();
                    global $blog_id;
                    $wurl = $upload_dir['baseurl'].'/wp-google-maps/'.$blog_id."-";
                }
                else {
                    $upload_dir = wp_upload_dir();
                    $wurl = $upload_dir['baseurl'].'/wp-google-maps/';
                }
            }
            
            
            $wpgmza_settings_infowindow_link_text = $wpgmza_settings['wpgmza_settings_infowindow_link_text'];
            if (!$wpgmza_settings_infowindow_link_text) { $wpgmza_settings_infowindow_link_text = __("More details","wp-google-maps"); }
            ?>
            
            wpgmaps_markerurl = '<?php echo $wurl; ?>';
            wpgmaps_lang_more_details = '<?php echo $wpgmza_settings_infowindow_link_text; ?>';
            wpgmaps_lang_get_dir = '<?php _e("Get directions","wp-google-maps"); ?>';
            wpgmaps_lang_my_location = '<?php _e("My location","wp-google-maps"); ?>';
            wpgmaps_lang_error1 = "<?php _e("Please fill out both the 'from' and 'to' fields","wp-google-maps"); ?>";
            wpgmaps_lang_getting_location ='<?php _e("Getting your current location address...","wp-google-maps"); ?>';
            <?php if (function_exists("wpgmaps_gold_activate")) { ?>var wpgm_g_e = true; <?php } else { ?>var wpgm_g_e = false; <?php } ?>

            var wpgm_dt_sLengthMenu = "<?php _e('Show _MENU_ entries','wp-google-maps'); ?>";
            var wpgm_dt_sZeroRecords = "<?php _e('Nothing found - sorry','wp-google-maps'); ?>";
            var wpgm_dt_sInfo = "<?php _e('Showing _START_ to _END_ of _TOTAL_ records','wp-google-maps'); ?>";
            var wpgm_dt_sInfoEmpty = "<?php _e('Showing 0 to 0 of 0 records','wp-google-maps'); ?>";
            var wpgm_dt_sInfoFiltered = "<?php _e('(filtered from _MAX_ total records)','wp-google-maps'); ?>";
            var wpgm_dt_sFirst = "<?php _e('First','wp-google-maps'); ?>";
            var wpgm_dt_sLast = "<?php _e('Last','wp-google-maps'); ?>";
            var wpgm_dt_sNext = "<?php _e('Next','wp-google-maps'); ?>";
            var wpgm_dt_sPrevious = "<?php _e('Previous','wp-google-maps'); ?>";
            var wpgm_dt_sSearch = "<?php _e('Search','wp-google-maps'); ?>";
            
            
        <?php
        if (function_exists("wpgmaps_ugm_activate")) { ?>ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
            var vgm_human_error_string = '<?php _e("Please prove that you are human by checking the checkbox above","wp-google-maps"); ?>';
            <?php $ajax_nonce_ugm = wp_create_nonce("wpgmza_ugm"); ?>
            var wpgmaps_nonce = '<?php echo $ajax_nonce_ugm; ?>';
            
        <?php } ?></script>
<?php

        }
    }

}




function wpgmaps_admin_javascript_pro() {
    global $wpdb;
    global $wpgmza_tblname_maps;
    $ajax_nonce = wp_create_nonce("wpgmza");
    if (is_admin() && isset($_GET['page']) && isset($_GET['action']) && $_GET['page'] == 'wp-google-maps-menu' && $_GET['action'] == "edit_marker") { wpgmaps_admin_edit_marker_javascript(); }
    else if (is_admin() && isset($_GET['page']) && isset($_GET['action']) && $_GET['page'] == 'wp-google-maps-menu' && $_GET['action'] == "add_poly") { wpgmaps_b_admin_add_poly_javascript($_GET['map_id']); }
    else if (is_admin() && isset($_GET['page']) && isset($_GET['action']) && $_GET['page'] == 'wp-google-maps-menu' && $_GET['action'] == "edit_poly") { wpgmaps_b_admin_edit_poly_javascript($_GET['map_id'],$_GET['poly_id']); }
    else if (is_admin() && isset($_GET['page']) && isset($_GET['action']) && $_GET['page'] == 'wp-google-maps-menu' && $_GET['action'] == "add_polyline") { wpgmaps_b_admin_add_polyline_javascript($_GET['map_id']); }
    else if (is_admin() && isset($_GET['page']) && isset($_GET['action']) && $_GET['page'] == 'wp-google-maps-menu' && $_GET['action'] == "edit_polyline") { wpgmaps_b_admin_edit_polyline_javascript($_GET['map_id'],$_GET['poly_id']); }
    else if (is_admin() && isset($_GET['page']) && isset($_GET['action']) && $_GET['page'] == 'wp-google-maps-menu' && $_GET['action'] == "edit") {
        wpgmaps_update_xml_file($_GET['map_id']);
        $res = wpgmza_get_map_data($_GET['map_id']);
        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");

        $wpgmza_lat = $res->map_start_lat;
        $wpgmza_lng = $res->map_start_lng;
        $wpgmza_width = $res->map_width;
        $wpgmza_height = $res->map_height;
        $wpgmza_width_type = stripslashes($res->map_width_type);
        $wpgmza_height_type = $res->map_height_type;
        $wpgmza_map_type = $res->type;
        $wpgmza_default_icon = $res->default_marker;
        $kml = $res->kml;
        $fusion = $res->fusion;
        $wpgmza_traffic = $res->traffic;
        $wpgmza_bicycle = $res->bicycle;
        $wpgmza_dbox = $res->dbox;
        $wpgmza_dbox_width = $res->dbox_width;

        
        $map_other_settings = maybe_unserialize($res->other_settings);
        $weather_layer = $map_other_settings['weather_layer'];
        $cloud_layer = $map_other_settings['cloud_layer'];
        $transport_layer = $map_other_settings['transport_layer'];

        $wpgmza_open_infowindow_by = $wpgmza_settings['wpgmza_settings_map_open_marker_by'];
        if ($wpgmza_open_infowindow_by == null || !isset($wpgmza_open_infowindow_by)) { $wpgmza_open_infowindow_by = '1'; }

        if ($wpgmza_default_icon == "0") { $wpgmza_default_icon = ""; }
        if (!$wpgmza_map_type || $wpgmza_map_type == "" || $wpgmza_map_type == "1") { $wpgmza_map_type = "ROADMAP"; }
        else if ($wpgmza_map_type == "2") { $wpgmza_map_type = "SATELLITE"; }
        else if ($wpgmza_map_type == "3") { $wpgmza_map_type = "HYBRID"; }
        else if ($wpgmza_map_type == "4") { $wpgmza_map_type = "TERRAIN"; }
        else { $wpgmza_map_type = "ROADMAP"; }

        $start_zoom = $res->map_start_zoom;
        if ($start_zoom < 1 || !$start_zoom) {
            $start_zoom = 5;
        }
        if (!$wpgmza_lat || !$wpgmza_lng) {
            $wpgmza_lat = "51.5081290";
            $wpgmza_lng = "-0.1280050";
        }
        
        
        // marker sorting functionality
        if ($res->order_markers_by == 1) { $order_by = 0; }
        else if ($res->order_markers_by == 2) { $order_by = 2; }
        else if ($res->order_markers_by == 3) { $order_by = 4; }
        else if ($res->order_markers_by == 4) { $order_by = 5; }
        else if ($res->order_markers_by == 5) { $order_by = 3; }
        else { $order_by = 0; }
        if ($res->order_markers_choice == 1) { $order_choice = "asc"; }
        else { $order_choice = "desc"; }
        $api_version = $wpgmza_settings['wpgmza_api_version'];
        if (isset($api_version) && $api_version != "") {
            $api_version_string = "v=$api_version&";
        } else {
            $api_version_string = "v=3.14&";
        }
    ?>
    <?php

    if ($cloud_layer == 1 || $weather_layer == 1) {  ?>

    <script type="text/javascript">
        var gmapsJsHost = (("https:" == document.location.protocol) ? "https://" : "http://");
        document.write(unescape("%3Cscript src='" + gmapsJsHost + "maps.google.com/maps/api/js?<?php echo $api_version_string; ?>sensor=false&libraries=weather' type='text/javascript'%3E%3C/script%3E"));
    </script>

    <?php } else { ?>

    <script type="text/javascript">
        var gmapsJsHost = (("https:" == document.location.protocol) ? "https://" : "http://");
        document.write(unescape("%3Cscript src='" + gmapsJsHost + "maps.google.com/maps/api/js?<?php echo $api_version_string; ?>sensor=false' type='text/javascript'%3E%3C/script%3E"));
    </script>

    <?php } ?>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.8.24/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo wpgmaps_get_plugin_url(); ?>/css/data_table.css" />
    <script type="text/javascript" src="<?php echo wpgmaps_get_plugin_url(); ?>/js/jquery.dataTables.js"></script>
    <script type="text/javascript" >

    


    jQuery(function() {

        
        

        var wpgmzaTable;

                jQuery(document).ready(function(){

                    

                    
                    
                    jQuery("#wpgmaps_show_advanced").click(function() {
                      jQuery("#wpgmaps_advanced_options").show();
                      jQuery("#wpgmaps_show_advanced").hide();
                      jQuery("#wpgmaps_hide_advanced").show();

                    });
                    jQuery("#wpgmaps_hide_advanced").click(function() {
                      jQuery("#wpgmaps_advanced_options").hide();
                      jQuery("#wpgmaps_show_advanced").show();
                      jQuery("#wpgmaps_hide_advanced").hide();

                    });



                    wpgmzaTable = jQuery('#wpgmza_table').dataTable({
                        "bProcessing": true,
                        "aaSorting": [[ <?php echo "$order_by";?>, "<?php echo $order_choice; ?>" ]]
                    });
                    function wpgmza_reinitialisetbl() {
                        wpgmzaTable.fnClearTable( 0 );
                        wpgmzaTable = jQuery('#wpgmza_table').dataTable({
                            "bProcessing": true,
                            "aaSorting": [[ <?php echo "$order_by";?>, "<?php echo $order_choice; ?>" ]]
                        });
                    }
                    function wpgmza_InitMap() {
                        var myLatLng = new google.maps.LatLng(<?php echo $wpgmza_lat; ?>,<?php echo $wpgmza_lng; ?>);
                        MYMAP.init('#wpgmza_map', myLatLng, <?php echo $start_zoom; ?>);
                        UniqueCode=Math.round(Math.random()*10000);
                        MYMAP.placeMarkers('<?php echo wpgmaps_get_marker_url($_GET['map_id']); ?>?u='+UniqueCode,<?php echo $_GET['map_id']; ?>);
                    }

                    jQuery("#wpgmza_map").css({
                        height:'<?php echo $wpgmza_height; ?><?php echo $wpgmza_height_type; ?>',
                        width:'<?php echo $wpgmza_width; ?><?php echo $wpgmza_width_type; ?>'

                    });
                    
                    
                    jQuery("#sl_line_color").focusout(function() {
                        poly.setOptions({ strokeColor: "#"+jQuery("#poly_line").val() }); 
                    });
                    jQuery("#sl_fill_color").keyup(function() {
                        poly.setOptions({ strokeOpacity: jQuery("#poly_opacity").val() }); 
                    });
                    jQuery("#sl_opacity").keyup(function() {
                        poly.setOptions({ strokeWeight: jQuery("#poly_thickness").val() }); 
                    });
                    
                    var geocoder = new google.maps.Geocoder();
                    wpgmza_InitMap();



                    jQuery("body").on("click", ".wpgmza_del_btn", function() {
                        var cur_id = jQuery(this).attr("id");
                        var wpgm_map_id = "0";
                        if (document.getElementsByName("wpgmza_id").length > 0) { wpgm_map_id = jQuery("#wpgmza_id").val(); }
                        var data = {
                                action: 'delete_marker',
                                security: '<?php echo $ajax_nonce; ?>',
                                map_id: wpgm_map_id,
                                marker_id: cur_id
                        };
                        jQuery.post(ajaxurl, data, function(response) {
                                wpgmza_InitMap();
                                jQuery("#wpgmza_marker_holder").html(response);
                                wpgmza_reinitialisetbl();

                        });

                    });
                    jQuery("body").on("click", ".wpgmza_poly_del_btn", function() {
                        var cur_id = jQuery(this).attr("id");
                        var wpgm_map_id = "0";
                        if (document.getElementsByName("wpgmza_id").length > 0) { wpgm_map_id = jQuery("#wpgmza_id").val(); }
                        var data = {
                                action: 'delete_poly',
                                security: '<?php echo $ajax_nonce; ?>',
                                map_id: wpgm_map_id,
                                poly_id: cur_id
                        };
                        jQuery.post(ajaxurl, data, function(response) {
                                wpgmza_InitMap();
                                jQuery("#wpgmza_poly_holder").html(response);
                                window.location.reload();

                        });

                    });
                    jQuery("body").on("click", ".wpgmza_polyline_del_btn", function() {
                        var cur_id = jQuery(this).attr("id");
                        var wpgm_map_id = "0";
                        if (document.getElementsByName("wpgmza_id").length > 0) { wpgm_map_id = jQuery("#wpgmza_id").val(); }
                        var data = {
                                action: 'delete_polyline',
                                security: '<?php echo $ajax_nonce; ?>',
                                map_id: wpgm_map_id,
                                poly_id: cur_id
                        };
                        jQuery.post(ajaxurl, data, function(response) {
                                wpgmza_InitMap();
                                jQuery("#wpgmza_polyline_holder").html(response);
                                window.location.reload();

                        });

                    });

                    var wpgmza_edit_address = ""; /* set this here so we can use it in the edit marker function below */
                    var wpgmza_edit_lat = ""; 
                    var wpgmza_edit_lng = ""; 

                    jQuery("body").on("click", ".wpgmza_edit_btn", function() {
                        var cur_id = jQuery(this).attr("id");

                        var wpgmza_edit_title = jQuery("#wpgmza_hid_marker_title_"+cur_id).val();
                        wpgmza_edit_address = jQuery("#wpgmza_hid_marker_address_"+cur_id).val();
                        wpgmza_edit_lat = jQuery("#wpgmza_hid_marker_lat_"+cur_id).val();
                        wpgmza_edit_lng = jQuery("#wpgmza_hid_marker_lng_"+cur_id).val();
                        
                        
                        var wpgmza_edit_desc = jQuery("#wpgmza_hid_marker_desc_"+cur_id).val();
                        var wpgmza_edit_pic = jQuery("#wpgmza_hid_marker_pic_"+cur_id).val();
                        var wpgmza_edit_link = jQuery("#wpgmza_hid_marker_link_"+cur_id).val();
                        var wpgmza_edit_icon = jQuery("#wpgmza_hid_marker_icon_"+cur_id).val();
                        var wpgmza_edit_anim = jQuery("#wpgmza_hid_marker_anim_"+cur_id).val();
                        var wpgmza_edit_category = jQuery("#wpgmza_hid_marker_category_"+cur_id).val();
                        var wpgmza_edit_infoopen = jQuery("#wpgmza_hid_marker_infoopen_"+cur_id).val();
                        jQuery("#wpgmza_edit_id").val(cur_id);
                        jQuery("#wpgmza_add_title").val(wpgmza_edit_title);
                        jQuery("#wpgmza_add_address").val(wpgmza_edit_address);
                        jQuery("#wpgmza_add_desc").val(wpgmza_edit_desc);
                        jQuery("#wpgmza_add_pic").val(wpgmza_edit_pic);
                        jQuery("#wpgmza_link_url").val(wpgmza_edit_link);
                        jQuery("#wpgmza_animation").val(wpgmza_edit_anim);
                        jQuery("#wpgmza_category").val(wpgmza_edit_category);
                        jQuery("#wpgmza_infoopen").val(wpgmza_edit_infoopen);
                        jQuery("#wpgmza_add_custom_marker").val(wpgmza_edit_icon);
                        jQuery("#wpgmza_cmm").html("<img src='"+wpgmza_edit_icon+"' />");
                        jQuery("#wpgmza_addmarker_div").hide();
                        jQuery("#wpgmza_editmarker_div").show();


                    });

                    

                    jQuery("#wpgmza_addmarker").click(function(){
                        jQuery("#wpgmza_addmarker").hide();
                        jQuery("#wpgmza_addmarker_loading").show();

                        var wpgm_title = "";
                        var wpgm_address = "0";
                        var wpgm_desc = "0";
                        var wpgm_pic = "0";
                        var wpgm_link = "0";
                        var wpgm_icon = "0";
                        var wpgm_gps = "0";

                        var wpgm_anim = "0";
                        var wpgm_category = "0";
                        var wpgm_infoopen = "0";
                        var wpgm_map_id = "0";
                        if (document.getElementsByName("wpgmza_add_title").length > 0) { wpgm_title = jQuery("#wpgmza_add_title").val(); }
                        if (document.getElementsByName("wpgmza_add_address").length > 0) { wpgm_address = jQuery("#wpgmza_add_address").val(); }
                        if (document.getElementsByName("wpgmza_add_desc").length > 0) { wpgm_desc = jQuery("#wpgmza_add_desc").val(); }
                        if (document.getElementsByName("wpgmza_add_pic").length > 0) { wpgm_pic = jQuery("#wpgmza_add_pic").val(); }
                        if (document.getElementsByName("wpgmza_link_url").length > 0) { wpgm_link = jQuery("#wpgmza_link_url").val(); }
                        if (document.getElementsByName("wpgmza_add_custom_marker").length > 0) { wpgm_icon = jQuery("#wpgmza_add_custom_marker").val(); }
                        if (document.getElementsByName("wpgmza_animation").length > 0) { wpgm_anim = jQuery("#wpgmza_animation").val(); }
                        if (document.getElementsByName("wpgmza_category").length > 0) { wpgm_category = jQuery("#wpgmza_category").val(); }
                        if (document.getElementsByName("wpgmza_infoopen").length > 0) { wpgm_infoopen = jQuery("#wpgmza_infoopen").val(); }
                        if (document.getElementsByName("wpgmza_id").length > 0) { wpgm_map_id = jQuery("#wpgmza_id").val(); }

                        geocoder.geocode( { 'address': wpgm_address}, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                wpgm_gps = String(results[0].geometry.location);
                                var latlng1 = wpgm_gps.replace("(","");
                                var latlng2 = latlng1.replace(")","");
                                var latlngStr = latlng2.split(",",2);
                                var wpgm_lat = parseFloat(latlngStr[0]);
                                var wpgm_lng = parseFloat(latlngStr[1]);


                                var data = {
                                    action: 'add_marker',
                                    security: '<?php echo $ajax_nonce; ?>',
                                    map_id: wpgm_map_id,
                                    title: wpgm_title,
                                    address: wpgm_address,
                                    desc: wpgm_desc,
                                    link: wpgm_link,
                                    icon: wpgm_icon,
                                    pic: wpgm_pic,
                                    anim: wpgm_anim,
                                    category: wpgm_category,
                                    infoopen: wpgm_infoopen,
                                    lat: wpgm_lat,
                                    lng: wpgm_lng
                                };


                                jQuery.post(ajaxurl, data, function(response) {
                                        wpgmza_InitMap();
                                        jQuery("#wpgmza_marker_holder").html(response);
                                        jQuery("#wpgmza_addmarker").show();
                                        jQuery("#wpgmza_addmarker_loading").hide();

                                        jQuery("#wpgmza_add_title").val("");
                                        jQuery("#wpgmza_add_address").val("");
                                        jQuery("#wpgmza_add_desc").val("");
                                        jQuery("#wpgmza_add_pic").val("");
                                        jQuery("#wpgmza_link_url").val("");
                                        jQuery("#wpgmza_animation").val("0");
                                        jQuery("#wpgmza_category").val("0");
                                        jQuery("#wpgmza_edit_id").val("");
                                        wpgmza_reinitialisetbl();
                                });

                            } else {
                                alert("<?php _e("Geocode was not successful for the following reason","wp-google-maps"); ?>: " + status);
                            }
                        });



                    });
                    jQuery("#wpgmza_editmarker").click(function(){

                        jQuery("#wpgmza_editmarker_div").hide();
                        jQuery("#wpgmza_editmarker_loading").show();


                        var wpgm_edit_id;
                        wpgm_edit_id = parseInt(jQuery("#wpgmza_edit_id").val());
                        var wpgm_title = "";
                        var wpgm_address = "0";
                        var wpgm_desc = "0";
                        var wpgm_pic = "0";
                        var wpgm_link = "0";
                        var wpgm_anim = "0";
                        var wpgm_category = "0";
                        var wpgm_infoopen = "0";
                        var wpgm_icon = "";
                        var wpgm_map_id = "0";
                        var wpgm_gps = "0";
                        if (document.getElementsByName("wpgmza_add_title").length > 0) { wpgm_title = jQuery("#wpgmza_add_title").val(); }
                        if (document.getElementsByName("wpgmza_add_address").length > 0) { wpgm_address = jQuery("#wpgmza_add_address").val(); }
                        if (document.getElementsByName("wpgmza_add_desc").length > 0) { wpgm_desc = jQuery("#wpgmza_add_desc").val(); }
                        if (document.getElementsByName("wpgmza_add_pic").length > 0) { wpgm_pic = jQuery("#wpgmza_add_pic").val(); }
                        if (document.getElementsByName("wpgmza_link_url").length > 0) { wpgm_link = jQuery("#wpgmza_link_url").val(); }
                        if (document.getElementsByName("wpgmza_animation").length > 0) { wpgm_anim = jQuery("#wpgmza_animation").val(); }
                        if (document.getElementsByName("wpgmza_category").length > 0) { wpgm_category = jQuery("#wpgmza_category").val(); }
                        if (document.getElementsByName("wpgmza_infoopen").length > 0) { wpgm_infoopen = jQuery("#wpgmza_infoopen").val(); }
                        if (document.getElementsByName("wpgmza_add_custom_marker").length > 0) { wpgm_icon = jQuery("#wpgmza_add_custom_marker").val(); }
                        if (document.getElementsByName("wpgmza_id").length > 0) { wpgm_map_id = jQuery("#wpgmza_id").val(); }


                        var do_geocode;
                        if (wpgm_address === wpgmza_edit_address) {
                            do_geocode = false;
                            var wpgm_lat = wpgmza_edit_lat;
                            var wpgm_lng = wpgmza_edit_lng;
                        } else { 
                            do_geocode = true;
                        }

                        if (do_geocode === true) {


                        geocoder.geocode( { 'address': wpgm_address}, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                wpgm_gps = String(results[0].geometry.location);
                                var latlng1 = wpgm_gps.replace("(","");
                                var latlng2 = latlng1.replace(")","");
                                var latlngStr = latlng2.split(",",2);
                                var wpgm_lat = parseFloat(latlngStr[0]);
                                var wpgm_lng = parseFloat(latlngStr[1]);

                                var data = {
                                        action: 'edit_marker',
                                        security: '<?php echo $ajax_nonce; ?>',
                                        map_id: wpgm_map_id,
                                        edit_id: wpgm_edit_id,
                                        title: wpgm_title,
                                        address: wpgm_address,
                                        lat: wpgm_lat,
                                        lng: wpgm_lng,
                                        icon: wpgm_icon,
                                        desc: wpgm_desc,
                                        link: wpgm_link,
                                        pic: wpgm_pic,
                                        anim: wpgm_anim,
                                        category: wpgm_category,
                                        infoopen: wpgm_infoopen
                                };

                                jQuery.post(ajaxurl, data, function(response) {
                                    wpgmza_InitMap();
                                    jQuery("#wpgmza_marker_holder").html(response);
                                    jQuery("#wpgmza_addmarker_div").show();
                                    jQuery("#wpgmza_editmarker_loading").hide();
                                    jQuery("#wpgmza_add_title").val("");
                                    jQuery("#wpgmza_add_address").val("");
                                    jQuery("#wpgmza_add_desc").val("");
                                    jQuery("#wpgmza_add_pic").val("");
                                    jQuery("#wpgmza_link_url").val("");
                                    jQuery("#wpgmza_edit_id").val("");
                                    jQuery("#wpgmza_animation").val("None");
                                    jQuery("#wpgmza_category").val("Select");
                                    jQuery("#wpgmza_cmm").html("");
                                    wpgmza_reinitialisetbl();
                                });

                            } else {
                                alert("<?php _e("Geocode was not successful for the following reason","wp-google-maps"); ?>: " + status);
                            }
                        });
                        } else {
                            /* address was the same, no need for geocoding */
                            var data = {
                                action: 'edit_marker',
                                security: '<?php echo $ajax_nonce; ?>',
                                map_id: wpgm_map_id,
                                edit_id: wpgm_edit_id,
                                title: wpgm_title,
                                address: wpgm_address,
                                lat: wpgm_lat,
                                lng: wpgm_lng,
                                icon: wpgm_icon,
                                desc: wpgm_desc,
                                link: wpgm_link,
                                pic: wpgm_pic,
                                anim: wpgm_anim,
                                category: wpgm_category,
                                infoopen: wpgm_infoopen
                            };

                            jQuery.post(ajaxurl, data, function(response) {
                                wpgmza_InitMap();
                                jQuery("#wpgmza_marker_holder").html(response);
                                jQuery("#wpgmza_addmarker_div").show();
                                jQuery("#wpgmza_editmarker_loading").hide();
                                jQuery("#wpgmza_add_title").val("");
                                jQuery("#wpgmza_add_address").val("");
                                jQuery("#wpgmza_add_desc").val("");
                                jQuery("#wpgmza_add_pic").val("");
                                jQuery("#wpgmza_link_url").val("");
                                jQuery("#wpgmza_edit_id").val("");
                                jQuery("#wpgmza_animation").val("None");
                                jQuery("#wpgmza_category").val("Select");
                                jQuery("#wpgmza_cmm").html("");
                                wpgmza_reinitialisetbl();
                            });
                        }





                    });
            });

            });

           

            var MYMAP = {
                map: null,
                bounds: null,
                mc: null
            }
            MYMAP.init = function(selector, latLng, zoom) {
              var myOptions = {
                zoom:zoom,

                center: latLng,
                scrollwheel: <?php if (isset($wpgmza_settings['wpgmza_settings_map_scroll']) && $wpgmza_settings['wpgmza_settings_map_scroll'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                zoomControl: <?php if (isset($wpgmza_settings['wpgmza_settings_map_zoom']) && $wpgmza_settings['wpgmza_settings_map_zoom'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                panControl: <?php if (isset($wpgmza_settings['wpgmza_settings_map_pan']) && $wpgmza_settings['wpgmza_settings_map_pan'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                mapTypeControl: <?php if (isset($wpgmza_settings['wpgmza_settings_map_type']) && $wpgmza_settings['wpgmza_settings_map_type'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                streetViewControl: <?php if (isset($wpgmza_settings['wpgmza_settings_map_streetview']) && $wpgmza_settings['wpgmza_settings_map_streetview'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                mapTypeId: google.maps.MapTypeId.<?php echo $wpgmza_map_type; ?>
              }
            this.map = new google.maps.Map(jQuery(selector)[0], myOptions);
            this.bounds = new google.maps.LatLngBounds();

            google.maps.event.addListener(MYMAP.map, 'zoom_changed', function() {
                zoomLevel = MYMAP.map.getZoom();
                jQuery("#wpgmza_start_zoom").val(zoomLevel);
            });
            <?php
                $total_poly_array = wpgmza_b_return_polygon_id_array($_GET['map_id']);
                if ($total_poly_array > 0) {
                foreach ($total_poly_array as $poly_id) {
                    $polyoptions = wpgmza_b_return_poly_options($poly_id);
                    $linecolor = $polyoptions->linecolor;
                    $lineopacity = $polyoptions->lineopacity;
                    $fillcolor = $polyoptions->fillcolor;
                    $fillopacity = $polyoptions->opacity;
                    if (!$linecolor) { $linecolor = "000000"; }
                    if (!$fillcolor) { $fillcolor = "66FF00"; }
                    if ($fillopacity == "") { $fillopacity = "0.5"; }
                    if ($lineopacity == "") { $lineopacity = "1"; }
                    $linecolor = "#".$linecolor;
                    $fillcolor = "#".$fillcolor;
                    
                    $poly_array = wpgmza_b_return_polygon_array($poly_id);
                    
                        
            ?> 

            <?php if (sizeof($poly_array) > 1) { ?>

            var WPGM_PathData_<?php echo $poly_id; ?> = [
                <?php
                        foreach ($poly_array as $single_poly) {
                            $poly_data_raw = str_replace(" ","",$single_poly);
                            $poly_data_raw = explode(",",$poly_data_raw);
                            $lat = $poly_data_raw[0];
                            $lng = $poly_data_raw[1];
                            ?>
                            new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $lng; ?>),            
                            <?php
                        }
                ?>
                
               
            ];
            var WPGM_Path_<?php echo $poly_id; ?> = new google.maps.Polygon({
              path: WPGM_PathData_<?php echo $poly_id; ?>,
              strokeColor: "<?php echo $linecolor; ?>",
              strokeOpacity: "<?php echo $lineopacity; ?>",
              fillOpacity: "<?php echo $fillopacity; ?>",
              fillColor: "<?php echo $fillcolor; ?>",
              strokeWeight: 2
            });

            WPGM_Path_<?php echo $poly_id; ?>.setMap(this.map);
            <?php } } ?>

            <?php } ?>


           
<?php
                // polylines
                    $total_polyline_array = wpgmza_b_return_polyline_id_array($_GET['map_id']);
                    if ($total_polyline_array > 0) {
                    foreach ($total_polyline_array as $poly_id) {
                        $polyoptions = wpgmza_b_return_polyline_options($poly_id);
                        $linecolor = $polyoptions->linecolor;
                        $fillopacity = $polyoptions->opacity;
                        $linethickness = $polyoptions->linethickness;
                        if (!$linecolor) { $linecolor = "000000"; }
                        if (!$linethickness) { $linethickness = "4"; }
                        if (!$fillopacity) { $fillopacity = "0.5"; }
                        $linecolor = "#".$linecolor;
                        $poly_array = wpgmza_b_return_polyline_array($poly_id);
                        ?>
                    
                <?php if (sizeof($poly_array) > 1) { ?>
                    var WPGM_PathLineData_<?php echo $poly_id; ?> = [
                    <?php
                    $poly_array = wpgmza_b_return_polyline_array($poly_id);

                    foreach ($poly_array as $single_poly) {
                        $poly_data_raw = str_replace(" ","",$single_poly);
                        $poly_data_raw = explode(",",$poly_data_raw);
                        $lat = $poly_data_raw[0];
                        $lng = $poly_data_raw[1];
                        ?>
                        new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $lng; ?>),            
                        <?php
                    }
                    ?>
                ];
                var WPGM_PathLine_<?php echo $poly_id; ?> = new google.maps.Polyline({
                  path: WPGM_PathLineData_<?php echo $poly_id; ?>,
                  strokeColor: "<?php echo $linecolor; ?>",
                  strokeOpacity: "<?php echo $fillopacity; ?>",
                  strokeWeight: "<?php echo $linethickness; ?>"
                  
                });

                WPGM_PathLine_<?php echo $poly_id; ?>.setMap(this.map);
                    <?php } } } ?>    


            google.maps.event.addListener(MYMAP.map, 'center_changed', function() {
                var location = MYMAP.map.getCenter();
                jQuery("#wpgmza_start_location").val(location.lat()+","+location.lng());
                jQuery("#wpgmaps_save_reminder").show();
            });

            <?php if ($wpgmza_bicycle == "1") { ?>
            var bikeLayer = new google.maps.BicyclingLayer();
            bikeLayer.setMap(this.map);
            <?php } ?>
            <?php if ($wpgmza_traffic == "1") { ?>
            var trafficLayer = new google.maps.TrafficLayer();
            trafficLayer.setMap(this.map);
            <?php } ?>
            <?php if ($weather_layer == 1) { ?>
            var weatherLayer = new google.maps.weather.WeatherLayer();
            weatherLayer.setMap(this.map);
            <?php } ?>
            <?php if ($cloud_layer == 1) { ?>
            var cloudLayer = new google.maps.weather.CloudLayer();
            cloudLayer.setMap(this.map);
            <?php } ?>
            <?php if ($transport_layer == 1) { ?>
            var transitLayer = new google.maps.TransitLayer();
            transitLayer.setMap(this.map);
            <?php } ?>



            <?php if ($kml != "") { ?>
            var georssLayer = new google.maps.KmlLayer('<?php echo $kml; ?>?tstamp=<?php echo time(); ?>');
            georssLayer.setMap(this.map);
            <?php } ?>
            <?php if ($fusion != "") { ?>
                var fusionlayer = new google.maps.FusionTablesLayer('<?php echo $fusion; ?>', {
                      suppressInfoWindows: false
                });
                fusionlayer.setMap(this.map);
            <?php } ?>


            } // end of map init

            var infoWindow = new google.maps.InfoWindow();
            <?php
                $wpgmza_settings_infowindow_width = "200";
                $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS"); 
               $wpgmza_settings_infowindow_width = $wpgmza_settings['wpgmza_settings_infowindow_width'];
                if (!$wpgmza_settings_infowindow_width || !isset($wpgmza_settings_infowindow_width)) { $wpgmza_settings_infowindow_width = "200"; }
            ?>
            infoWindow.setOptions({maxWidth:<?php echo $wpgmza_settings_infowindow_width; ?>});

            google.maps.event.addDomListener(window, 'resize', function() {
                var myLatLng = new google.maps.LatLng(<?php echo $wpgmza_lat; ?>,<?php echo $wpgmza_lng; ?>);
                MYMAP.map.setCenter(myLatLng);
            });


            

            MYMAP.placeMarkers = function(filename,map_id) {
                
            
                marker_array = [];
                    jQuery.get(filename, function(xml){
                            jQuery(xml).find("marker").each(function(){
                                    var wpgmza_def_icon = '<?php echo $wpgmza_default_icon; ?>';
                                    var wpmgza_map_id = jQuery(this).find('map_id').text();

                                    if (wpmgza_map_id == map_id) {
                                        var wpmgza_title = jQuery(this).find('title').text();
                                        var wpmgza_show_address = jQuery(this).find('address').text();
                                        var wpmgza_address = jQuery(this).find('address').text();
                                        var wpmgza_mapicon = jQuery(this).find('icon').text();
                                        var wpmgza_image = jQuery(this).find('pic').text();
                                        var wpmgza_desc  = jQuery(this).find('desc').text();
                                        var wpmgza_anim  = jQuery(this).find('anim').text();
                                        var wpmgza_infoopen  = jQuery(this).find('infoopen').text();
                                        var wpmgza_linkd = jQuery(this).find('linkd').text();
                                        if (wpmgza_title != "") {
                                            wpmgza_title = wpmgza_title+'<br />';
                                        }
                                        if (wpmgza_image != "") {

                                    <?php
                                        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                                        $wpgmza_settings_infowindow_link_text = $wpgmza_settings['wpgmza_settings_infowindow_link_text'];
                                        if (!$wpgmza_settings_infowindow_link_text) { $wpgmza_settings_infowindow_link_text = __("More details","wp-google-maps"); }
                                        $wpgmza_image_height = $wpgmza_settings['wpgmza_settings_image_height'];
                                        $wpgmza_image_width = $wpgmza_settings['wpgmza_settings_image_width'];
                                        if (!$wpgmza_image_height || !isset($wpgmza_image_height)) { $wpgmza_image_height = "100"; }
                                        if (!$wpgmza_image_width || !isset($wpgmza_image_width)) { $wpgmza_image_width = "100"; }

                                        if (isset($wpgmza_settings['wpgmza_settings_use_timthumb'])) { $wpgmza_use_timthumb = $wpgmza_settings['wpgmza_settings_use_timthumb']; }
                                        if ( !isset($wpgmza_use_timthumb) || $wpgmza_use_timthumb == "") { ?>
                                                wpmgza_image = "<img src='<?php echo wpgmaps_get_plugin_url(); ?>/timthumb.php?src="+wpmgza_image+"&h=<?php echo $wpgmza_image_height; ?>&w=<?php echo $wpgmza_image_width; ?>&zc=1' title='' alt='' style=\"float:right; width:"+<?php echo $wpgmza_image_width; ?>+"px; height:"+<?php echo $wpgmza_image_height; ?>+"px;\" />";
                                    <?php } else  { ?>
                                                wpmgza_image = "<img src='"+wpmgza_image+"' class='wpgmza_map_image' style=\"float:right; margin:5px; height:<?php echo $wpgmza_image_height; ?>px; width:<?php echo $wpgmza_image_width; ?>px\" />";
                                    <?php } ?>

                                            } else { wpmgza_image = "" }
                                        if (wpmgza_linkd != "") {
                                                <?php
                                                    $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                                                    if (isset($wpgmza_settings['wpgmza_settings_infowindow_links'])) { $wpgmza_settings_infowindow_links = $wpgmza_settings['wpgmza_settings_infowindow_links']; }
                                                    if (isset($wpgmza_settings_infowindow_links) && $wpgmza_settings_infowindow_links == "yes") { $wpgmza_settings_infowindow_links = "target='_BLANK'";  } else { $wpgmza_settings_infowindow_links = ""; }
                                                ?>

                                                wpmgza_linkd = "<a href='"+wpmgza_linkd+"' <?php echo $wpgmza_settings_infowindow_links; ?> title='<?php echo $wpgmza_settings_infowindow_link_text; ?>'><?php echo $wpgmza_settings_infowindow_link_text; ?></a>";
                                            }
                                        if (wpmgza_mapicon == "" || !wpmgza_mapicon) { if (wpgmza_def_icon != "") { wpmgza_mapicon = '<?php echo $wpgmza_default_icon; ?>'; } }

                                        var lat = jQuery(this).find('lat').text();
                                        var lng = jQuery(this).find('lng').text();
                                        var point = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));
                                        MYMAP.bounds.extend(point);
                                        if (wpmgza_anim == "1") {
                                        var marker = new google.maps.Marker({
                                                position: point,
                                                map: MYMAP.map,
                                                icon: wpmgza_mapicon,
                                                animation: google.maps.Animation.BOUNCE
                                        });
                                        }
                                        else if (wpmgza_anim == "2") {
                                            var marker = new google.maps.Marker({
                                                    position: point,
                                                    map: MYMAP.map,
                                                    icon: wpmgza_mapicon,
                                                    animation: google.maps.Animation.DROP
                                            });
                                        }
                                        else {
                                            var marker = new google.maps.Marker({
                                                    position: point,
                                                    map: MYMAP.map,
                                                    icon: wpmgza_mapicon
                                            });
                                        }
                                        //var html=''+wpmgza_image+'<strong>'+wpmgza_address+'</strong><br /><span style="font-size:12px;">'+wpmgza_desc+'<br />'+wpmgza_linkd+'</span>';
                                        <?php
                                                $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                                                if (isset($wpgmza_settings['wpgmza_settings_infowindow_address'])) { 
                                                    $wpgmza_settings_infowindow_address = $wpgmza_settings['wpgmza_settings_infowindow_address'];
                                                } else { $wpgmza_settings_infowindow_address = ""; }
                                                if ($wpgmza_settings_infowindow_address == "yes") {
                                                
                                        ?>
                                                    wpmgza_show_address = "";
                                        <?php } ?>
                                        
                                        
                                        var html='<div id="wpgmza_markerbox" style="min-width:'+<?php echo $wpgmza_settings_infowindow_width; ?>+'px;">'+wpmgza_image+'<p><strong>'+wpmgza_title+'</strong>'+wpmgza_show_address+'<br />'
                                                +wpmgza_desc+
                                                '<br />'
                                                +wpmgza_linkd+
                                                ''
                                                +'</p></div>';
                                        if (wpmgza_infoopen == "1") {

                                            infoWindow.setContent(html);
                                            infoWindow.open(MYMAP.map, marker);
                                        }

                                        <?php if ($wpgmza_open_infowindow_by == '2') { ?>
                                        google.maps.event.addListener(marker, 'mouseover', function() {
                                            infoWindow.close();
                                            infoWindow.setContent(html);
                                            infoWindow.open(MYMAP.map, marker);

                                        });
                                        <?php } else { ?>
                                        google.maps.event.addListener(marker, 'click', function() {
                                            infoWindow.close();
                                            infoWindow.setContent(html);
                                            infoWindow.open(MYMAP.map, marker);

                                        });
                                        <?php } ?>
                                       

                                    }

                        });
                });
            }

        </script>
<?php
}

}


function wpgmaps_upload_csv() {
    if (!function_exists("wpgmaps_activate")) {
        echo "<div id='message' class='updated' style='padding:10px; '><span style='font-weight:bold; color:red;'>".__("WP Google Maps","wp-google-maps").":</span> ".__("Please ensure you have <strong>both</strong> the <strong>Basic</strong> and <strong>Pro</strong> versions of WP Google Maps installed and activated at the same time in order for the plugin to function correctly.","wp-google-maps")."<br /></div>";
    }
    
    
    if (isset($_POST['wpgmza_uploadcsv_btn'])) {

        if (is_uploaded_file($_FILES['wpgmza_csvfile']['tmp_name'])) {
        ini_set("auto_detect_line_endings", true);
        global $wpdb;
        global $wpgmza_tblname;
        $handle = fopen($_FILES['wpgmza_csvfile']['tmp_name'], "r");
        $header = fgetcsv($handle);

        unset ($wpgmza_errormsg);
        if ($header[0] != "id") { $wpgmza_errormsg = __("Header 1 should be 'id', not","wp-google-maps")." '$header[0]'<br />"; }
        if ($header[1] != "map_id") { $wpgmza_errormsg .= __("Header 2 should be 'map_id', not","wp-google-maps")." '$header[1]'<br />"; }
        if ($header[2] != "address") { $wpgmza_errormsg .= __("Header 3 should be 'address', not","wp-google-maps")." '$header[2]'<br />"; }
        if ($header[3] != "description") { $wpgmza_errormsg .= __("Header 4 should be 'description', not","wp-google-maps")." '$header[3]'<br />"; }
        if ($header[4] != "pic") { $wpgmza_errormsg .= __("Header 5 should be 'pic', not","wp-google-maps")." '$header[4]'<br />"; }
        if ($header[5] != "link") { $wpgmza_errormsg .= __("Header 6 should be 'link', not","wp-google-maps")." '$header[5]'<br />"; }
        if ($header[6] != "icon") { $wpgmza_errormsg .= __("Header 7 should be 'icon', not","wp-google-maps")." '$header[6]'<br />"; }
        if ($header[7] != "lat") { $wpgmza_errormsg .= __("Header 8 should be 'lat', not","wp-google-maps")." '$header[7]'<br />"; }
        if ($header[8] != "lng") { $wpgmza_errormsg .= __("Header 9 should be 'lng', not","wp-google-maps")." '$header[8]'<br />"; }
        if ($header[9] != "anim") { $wpgmza_errormsg .= __("Header 10 should be 'anim', not","wp-google-maps")." '$header[9]'<br />"; }
        if ($header[10] != "title") { $wpgmza_errormsg .= __("Header 11 should be 'title', not","wp-google-maps")." '$header[10]'<br />"; }
        if ($header[11] != "infoopen") { $wpgmza_errormsg .= __("Header 12 should be 'infoopen', not","wp-google-maps")." '$header[11]'<br />"; }
        if ($header[12] != "category") { $wpgmza_errormsg .= __("Header 13 should be 'category', not","wp-google-maps")." '$header[12]'<br />"; }
        if (isset($wpgmza_errormsg)) {
            echo "<div class='error below-h2'>".__("CSV import failed","wp-google-maps")."!<br /><br />$wpgmza_errormsg</div>";

        }
        else {
        while(! feof($handle)){
            if ($_POST['wpgmza_csvreplace'] == "Yes") { 
                $wpdb->query("TRUNCATE TABLE $wpgmza_tblname");
            }
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $ra = $wpdb->insert( $wpgmza_tblname, array(
                    $header[1] => $data[1],
                    $header[2] => $data[2],
                    $header[3] => $data[3],
                    $header[4] => $data[4],
                    $header[5] => $data[5],
                    $header[6] => $data[6],
                    $header[7] => $data[7],
                    $header[8] => $data[8],
                    $header[9] => $data[9],
                    $header[10] => $data[10],
                    $header[11] => $data[11],
                    $header[12] => $data[12]
                    )
                );
             }

        }
        fclose($handle);
        echo "<div class='error below-h2'>".__("Your CSV file has been successfully imported","wp-google-maps")."</div>";
        }
    }
    }

}

function wpgmza_cURL_response_pro($action) {
    if (function_exists('curl_version')) {
        global $wpgmza_pro_version;
        global $wpgmza_pro_string;
        $request_url = "http://www.wpgmaps.com/api/rec.php?action=$action&dom=".$_SERVER['HTTP_HOST']."&ver=".$wpgmza_pro_version.$wpgmza_pro_string;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
    }

}

function wpgmza_pro_advanced_menu() {
    $wpgmza_csv = "<a href=\"".wpgmaps_get_plugin_url()."/csv.php\" title=\"".__("Download ALL marker data to a CSV file","wp-google-maps")."\">".__("Download ALL marker data to a CSV file","wp-google-maps")."</a>";

    echo "
        <div class=\"wrap\"><div id=\"icon-tools\" class=\"icon32 icon32-posts-post\"><br></div><h2>".__("Advanced Options","wp-google-maps")."</h2>
        <div style=\"display:block; overflow:auto; background-color:#FFFBCC; padding:10px; border:1px solid #E6DB55; margin-top:35px; margin-bottom:5px;\">
            $wpgmza_csv
            <br /><br /><strong>- ".__("OR","wp-google-maps")." -<br /><br /></strong><form enctype=\"multipart/form-data\" method=\"POST\">
                ".__("Upload CSV File","wp-google-maps").": <input name=\"wpgmza_csvfile\" type=\"file\" /><br />
                <input name=\"wpgmza_security\" type=\"hidden\" value=\"$wpgmza_post_nonce\" /><br />
                ".__("Replace existing data with data in file","wp-google-maps").": <input name=\"wpgmza_csvreplace\" type=\"checkbox\" value=\"Yes\" /><br />
                <input type=\"submit\" name=\"wpgmza_uploadcsv_btn\" value=\"".__("Upload File","wp-google-maps")."\" />
            </form>
        </div>



    ";


}


function wpgmaps_settings_page_pro() {


    echo"<div class=\"wrap\"><div id=\"icon-edit\" class=\"icon32 icon32-posts-post\"><br></div><h2>".__("WP Google Map Settings","wp-google-maps")."</h2>";


    if (function_exists("wpgmza_register_pro_version")) {
        $pro_settings1 = wpgmaps_settings_page_sub('infowindow');
        $pro_settings2 = wpgmaps_settings_page_sub('mapsettings');
        $pro_settings3 = wpgmaps_settings_page_sub('ugm');
        global $wpgmza_version;
        if (floatval($wpgmza_version) < 5) {
            $prov_msg = "<div class='error below-h1'><p>Please update your BASIC version of this plugin for all of these settings to work.</p></div>";
        } else { $prov_msg = ''; }
    }
    if (function_exists('wpgmza_register_ugm_version')) {
        $pro_settings3 = wpgmaps_settings_page_sub('ugm');
    }

    echo "

            <form action='' method='post' id='wpgmaps_options'>
                <p>$prov_msg</p>

                $pro_settings1
                $pro_settings2
                $pro_settings3

                <p class='submit'><input type='submit' name='wpgmza_save_settings' class='button-primary' value='".__("Save Settings","wp-google-maps")." &raquo;' /></p>


            </form>
    ";

    echo "</div>";






}
register_activation_hook( __FILE__, 'wpgmaps_pro_activate' );
register_deactivation_hook( __FILE__, 'wpgmaps_pro_deactivate' );


$wpgmaps_api_url = 'http://wpgmaps.com/apid/';
$wpgmaps_plugin_slug = basename(dirname(__FILE__));

// Take over the update check
add_filter('pre_set_site_transient_update_plugins', 'wpgmaps_check_for_plugin_update');

function wpgmaps_check_for_plugin_update($checked_data) {
	global $wpgmaps_api_url, $wpgmaps_plugin_slug, $wp_version;
	
	//Comment out these two lines during testing.
	if (empty($checked_data->checked))
		return $checked_data;
	
        
        
	$args = array(
		'slug' => $wpgmaps_plugin_slug,
		'version' => $checked_data->checked[$wpgmaps_plugin_slug .'/'. $wpgmaps_plugin_slug .'.php'],
	);
	$request_string = array(
			'body' => array(
				'action' => 'basic_check', 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
	
	// Start checking for an update
	$raw_response = wp_remote_post($wpgmaps_api_url, $request_string);
        
        
	if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
		$response = unserialize($raw_response['body']);
	
	if (is_object($response) && !empty($response)) // Feed the update data into WP updater
		$checked_data->response[$wpgmaps_plugin_slug .'/'. $wpgmaps_plugin_slug .'.php'] = $response;
	
	return $checked_data;
}



add_filter('plugins_api', 'wpgmaps_plugin_api_call', 10, 3);

function wpgmaps_plugin_api_call($def, $action, $args) {
	global $wpgmaps_plugin_slug, $wpgmaps_api_url, $wp_version;
	
	if (!isset($args->slug) || ($args->slug != $wpgmaps_plugin_slug))
		return false;
	
	// Get the current version
	$plugin_info = get_site_transient('update_plugins');
	$current_version = $plugin_info->checked[$wpgmaps_plugin_slug .'/'. $wpgmaps_plugin_slug .'.php'];
	$args->version = $current_version;
	
	$request_string = array(
			'body' => array(
				'action' => $action, 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
	
	$request = wp_remote_post($wpgmaps_api_url, $request_string);
	
	if (is_wp_error($request)) {
		$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
	} else {
		$res = unserialize($request['body']);
		
		if ($res === false)
			$res = new WP_Error('plugins_api_failed', __('An unknown error occurred'), $request['body']);
	}
	
	return $res;
}



function wpgmaps_settings_page_sub($section) {

    if ($section == "ugm") {
        if (function_exists('wpgmaps_ugm_settings_page')) { return wpgmaps_ugm_settings_page(); }
        else { return ""; }
    }

    if ($section == "mapsettings") {
        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
        $wpgmza_settings_map_streetview = $wpgmza_settings['wpgmza_settings_map_streetview'];
        $wpgmza_settings_map_zoom = $wpgmza_settings['wpgmza_settings_map_zoom'];
        $wpgmza_settings_map_pan = $wpgmza_settings['wpgmza_settings_map_pan'];
        $wpgmza_settings_map_type = $wpgmza_settings['wpgmza_settings_map_type'];
        $wpgmza_settings_map_scroll = $wpgmza_settings['wpgmza_settings_map_scroll'];
        $wpgmza_settings_map_draggable = $wpgmza_settings['wpgmza_settings_map_draggable'];
        $wpgmza_settings_map_clickzoom = $wpgmza_settings['wpgmza_settings_map_clickzoom'];
        $wpgmza_force_jquery = $wpgmza_settings['wpgmza_settings_force_jquery'];
        $wpgmza_settings_markerlist_category = $wpgmza_settings['wpgmza_settings_markerlist_category'];
        $wpgmza_settings_markerlist_icon = $wpgmza_settings['wpgmza_settings_markerlist_icon'];
        $wpgmza_settings_markerlist_title = $wpgmza_settings['wpgmza_settings_markerlist_title'];
        $wpgmza_settings_markerlist_address = $wpgmza_settings['wpgmza_settings_markerlist_description'];
        $wpgmza_settings_markerlist_description = $wpgmza_settings['wpgmza_settings_markerlist_address'];
        $wpgmza_settings_filterbycat_type = $wpgmza_settings['wpgmza_settings_filterbycat_type'];
        
        if ($wpgmza_settings_map_streetview == "yes") { $wpgmza_streetview_checked = "checked='checked'"; } else { $wpgmza_streetview_checked = ''; }
        if ($wpgmza_settings_map_zoom == "yes") { $wpgmza_zoom_checked = "checked='checked'"; } else { $wpgmza_zoom_checked = ''; }
        if ($wpgmza_settings_map_pan == "yes") { $wpgmza_pan_checked = "checked='checked'"; } else { $wpgmza_pan_checked = ''; }
        if ($wpgmza_settings_map_type == "yes") { $wpgmza_type_checked = "checked='checked'"; } else { $wpgmza_type_checked = ''; }
        if ($wpgmza_settings_map_scroll == "yes") { $wpgmza_scroll_checked = "checked='checked'"; } else { $wpgmza_scroll_checked = ''; }
        if ($wpgmza_settings_map_draggable == "yes") { $wpgmza_draggable_checked = "checked='checked'"; } else { $wpgmza_draggable_checked = ''; }
        if ($wpgmza_settings_map_clickzoom == "yes") { $wpgmza_clickzoom_checked = "checked='checked'"; } else { $wpgmza_clickzoom_checked = ''; }
        if ($wpgmza_force_jquery == "yes") { $wpgmza_force_jquery_checked = "checked='checked'"; } else { $wpgmza_force_jquery_checked = ''; }
        if ($wpgmza_settings_markerlist_category == "yes") { $wpgmza_hide_category_checked = "checked='checked'"; } else { $wpgmza_hide_category_checked = ''; }
        if ($wpgmza_settings_markerlist_icon == "yes") { $wpgmza_hide_icon_checked = "checked='checked'"; } else { $wpgmza_hide_icon_checked = ''; }
        if ($wpgmza_settings_markerlist_title == "yes") { $wpgmza_hide_title_checked = "checked='checked'"; } else { $wpgmza_hide_title_checked = ''; }
        if ($wpgmza_settings_markerlist_address == "yes") { $wpgmza_hide_address_checked = "checked='checked'"; } else { $wpgmza_hide_address_checked = ''; }
        if ($wpgmza_settings_markerlist_description == "yes") { $wpgmza_hide_description_checked = "checked='checked'"; } else { $wpgmza_hide_description_checked = ''; }
    
        if (isset($wpgmza_settings['wpgmza_api_version'])) { $wpgmza_api_version = $wpgmza_settings['wpgmza_api_version']; }

    
        $wpgmza_api_version_selected[0] = "";
        $wpgmza_api_version_selected[1] = "";
        $wpgmza_api_version_selected[2] = "";

        if ($wpgmza_api_version == "3.14") { $wpgmza_api_version_selected[0] = "selected"; }
        else if ($wpgmza_api_version == "3.15") { $wpgmza_api_version_selected[1] = "selected"; }
        else if ($wpgmza_api_version == "3.exp") { $wpgmza_api_version_selected[2] = "selected"; }
        else { $wpgmza_api_version_selected[0] = "selected"; }
        
        $wpgmza_settings_map_open_marker_by_checked[0] = '';
        $wpgmza_settings_map_open_marker_by_checked[1] = '';
        $wpgmza_settings_map_open_marker_by = $wpgmza_settings['wpgmza_settings_map_open_marker_by'];
        if ($wpgmza_settings_map_open_marker_by == '1') { $wpgmza_settings_map_open_marker_by_checked[0] = "checked='checked'"; }
        else if ($wpgmza_settings_map_open_marker_by == '2') { $wpgmza_settings_map_open_marker_by_checked[1] = "checked='checked'"; }
        else { $wpgmza_settings_map_open_marker_by_checked[0] = "checked='checked'"; }

        
        
        if ($wpgmza_settings_filterbycat_type == "1" || $wpgmza_settings_filterbycat_type == "" || !$wpgmza_settings_filterbycat_type) { 
            $wpgmza_settings_filterbycat_type_checked_dropdown = "checked='checked'";
            $wpgmza_settings_filterbycat_type_checked_checkbox = "";
        } else {
            $wpgmza_settings_filterbycat_type_checked_checkbox = "checked='checked'";
            $wpgmza_settings_filterbycat_type_checked_dropdown = "";
        }

        return "
            <h3>".__("Map Settings","wp-google-maps")."</h3>
                <table class='form-table'>
                    <tr>
                         <td width='200' valign='top'>".__("General Map Settings","wp-google-maps").":</td>
                         <td>
                                <input name='wpgmza_settings_map_streetview' type='checkbox' id='wpgmza_settings_map_streetview' value='yes' $wpgmza_streetview_checked /> ".__("Disable StreetView","wp-google-maps")."<br />
                                <input name='wpgmza_settings_map_zoom' type='checkbox' id='wpgmza_settings_map_zoom' value='yes' $wpgmza_zoom_checked /> ".__("Disable Zoom Controls","wp-google-maps")."<br />
                                <input name='wpgmza_settings_map_pan' type='checkbox' id='wpgmza_settings_map_pan' value='yes' $wpgmza_pan_checked /> ".__("Disable Pan Controls","wp-google-maps")."<br />
                                <input name='wpgmza_settings_map_type' type='checkbox' id='wpgmza_settings_map_type' value='yes' $wpgmza_type_checked /> ".__("Disable Map Type Controls","wp-google-maps")."<br />
                                <input name='wpgmza_settings_map_scroll' type='checkbox' id='wpgmza_settings_map_scroll' value='yes' $wpgmza_scroll_checked /> ".__("Disable Mouse Wheel Zoom","wp-google-maps")."<br />
                                <input name='wpgmza_settings_map_draggable' type='checkbox' id='wpgmza_settings_map_draggable' value='yes' $wpgmza_draggable_checked /> ".__("Disable Mouse Dragging","wp-google-maps")."<br />
                                <input name='wpgmza_settings_map_clickzoom' type='checkbox' id='wpgmza_settings_map_clickzoom' value='yes' $wpgmza_clickzoom_checked /> ".__("Disable Mouse Double Click Zooming","wp-google-maps")."<br />
                            </td>
                    </tr>
                    <tr>
                        <td valign='top' style='vertical-align:top;'>".__("Open Marker InfoWindows by","wp-google-maps")." </td>
                            <td><input name='wpgmza_settings_map_open_marker_by' type='radio' id='wpgmza_settings_map_open_marker_by' value='1' ".$wpgmza_settings_map_open_marker_by_checked[0]." />Click<br /><input name='wpgmza_settings_map_open_marker_by' type='radio' id='wpgmza_settings_map_open_marker_by' value='2' ".$wpgmza_settings_map_open_marker_by_checked[1]." />Hover </td>
                    </tr>
                    <tr>
                         <td width='200' valign='top'>".__("Filter by category displayed as","wp-google-maps").":</td>
                         <td>
                                <input name='wpgmza_settings_filterbycat_type' type='radio' id='wpgmza_settings_filterbycat_type' value='1' $wpgmza_settings_filterbycat_type_checked_dropdown /> ".__("Dropdown","wp-google-maps")."<br />
                                <input name='wpgmza_settings_filterbycat_type' type='radio' id='wpgmza_settings_filterbycat_type' value='2' $wpgmza_settings_filterbycat_type_checked_checkbox /> ".__("Checkboxes","wp-google-maps")." (still in beta)<br />
                            </td>
                    </tr>
                    <tr>
                         <td width='200' valign='top'>".__("Marker Listing Settings","wp-google-maps").":</td>
                         <td>
                                <input name='wpgmza_settings_markerlist_icon' type='checkbox' id='wpgmza_settings_markerlist_icon' value='yes' $wpgmza_hide_icon_checked /> ".__("Hide the Icon column","wp-google-maps")."<br />
                                <input name='wpgmza_settings_markerlist_title' type='checkbox' id='wpgmza_settings_markerlist_title' value='yes' $wpgmza_hide_title_checked /> ".__("Hide the Title column","wp-google-maps")."<br />
                                <input name='wpgmza_settings_markerlist_address' type='checkbox' id='wpgmza_settings_markerlist_address' value='yes' $wpgmza_hide_address_checked /> ".__("Hide the Address column","wp-google-maps")."<br />
                                <input name='wpgmza_settings_markerlist_category' type='checkbox' id='wpgmza_settings_markerlist_category' value='yes' $wpgmza_hide_category_checked /> ".__("Hide the Category column","wp-google-maps")."<br />
                                <input name='wpgmza_settings_markerlist_description' type='checkbox' id='wpgmza_settings_markerlist_description' value='yes' $wpgmza_hide_description_checked /> ".__("Hide the Description column","wp-google-maps")."<br />
                        </td>
                    </tr>
                    <tr>
                         <td width='200' valign='top'>".__("Troubleshooting Options","wp-google-maps").":</td>
                         <td>
                                <input name='wpgmza_settings_force_jquery' type='checkbox' id='wpgmza_settings_force_jquery' value='yes' $wpgmza_force_jquery_checked /> ".__("Over-ride current jQuery with version 1.8.3 (Tick this box if you are receiving jQuery related errors)")."<br />
                        </td>
                    </tr>
                    <tr>
                           <td width='200' valign='top'>".__("Use Google Maps API","wp-google-maps").":</td>
                        <td>
                           <select id='wpgmza_api_version' name='wpgmza_api_version'  >
                                       <option value=\"3.14\" ".$wpgmza_api_version_selected[0].">3.14</option>
                                       <option value=\"3.15\" ".$wpgmza_api_version_selected[1].">3.15</option>
                                       <option value=\"3.exp\" ".$wpgmza_api_version_selected[2].">3.exp</option>

                                   </select>    
                       </td>
                   </tr>
                    
                </table>
            ";




    }

    if ($section == "infowindow") {
        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
        if (isset($wpgmza_settings['wpgmza_settings_image_width'])) { $wpgmza_set_img_width = $wpgmza_settings['wpgmza_settings_image_width']; }
        if (isset($wpgmza_settings['wpgmza_settings_image_height'])) { $wpgmza_set_img_height = $wpgmza_settings['wpgmza_settings_image_height']; }
        if (isset($wpgmza_settings['wpgmza_settings_use_timthumb'])) { $wpgmza_set_use_timthumb = $wpgmza_settings['wpgmza_settings_use_timthumb']; }
        if (isset($wpgmza_settings['wpgmza_settings_infowindow_links'])) { $wpgmza_settings_infowindow_links = $wpgmza_settings['wpgmza_settings_infowindow_links']; }
        if (isset($wpgmza_settings['wpgmza_settings_infowindow_address'])) { $wpgmza_settings_infowindow_address = $wpgmza_settings['wpgmza_settings_infowindow_address']; }
        if (isset($wpgmza_settings['wpgmza_settings_infowindow_link_text'])) { $wpgmza_link_text = $wpgmza_settings['wpgmza_settings_infowindow_link_text']; }
        
        
        if (!$wpgmza_link_text) { $wpgmza_link_text = __("More details","wp-google-maps"); }
        
        $wpgmza_settings_infowindow_width = $wpgmza_settings['wpgmza_settings_infowindow_width'];

        if ($wpgmza_set_use_timthumb == "yes") { $wpgmza_timchecked = "checked='checked'"; } else { $wpgmza_timchecked = ""; }
        if (!isset($wpgmza_set_img_width) || $wpgmza_set_img_width == "") { $wpgmza_set_img_width = "100"; }
        if (!isset($wpgmza_set_img_height) || $wpgmza_set_img_height == "" ) { $wpgmza_set_img_height = "100"; }
        if (!isset($wpgmza_settings_infowindow_width) || $wpgmza_settings_infowindow_width == "") { $wpgmza_settings_infowindow_width = "200"; }
        if ($wpgmza_settings_infowindow_links == "yes") { $wpgmza_linkschecked = "checked='checked'"; } else { $wpgmza_linkschecked = ""; }
        if ($wpgmza_settings_infowindow_address == "yes") { $wpgmza_addresschecked = "checked='checked'"; } else { $wpgmza_addresschecked = ""; }

        return "
                <h3>".__("InfoWindow Settings","wp-google-maps")."</h3>
                <table class='form-table'>
                    <tr>
                         <td width='200'>".__("Default Image Width","wp-google-maps").":</td>
                         <td><input id='wpgmza_settings_image_width' name='wpgmza_settings_image_width' type='text' size='4' maxlength='4' value='$wpgmza_set_img_width' /> px </td>
                    </tr>
                    <tr>
                         <td>".__("Default Image Height","wp-google-maps").":</td>
                         <td><input id='wpgmza_settings_image_height' name='wpgmza_settings_image_height' type='text' size='4' maxlength='4' value='$wpgmza_set_img_height' /> px </td>
                    </tr>
                    <tr>
                         <td>".__("Image Thumbnails","wp-google-maps").":</td>
                         <td>
                                <input name='wpgmza_settings_use_timthumb' type='checkbox' id='wpgmza_settings_use_timthumb' value='yes' $wpgmza_timchecked /> ".__("Do not use TimThumb","wp-google-maps")." <em>
                                ".__("(Tick this if you are having problems viewing your thumbnail images)","wp-google-maps")."</em>
                        </td>
                    </tr>
                    <tr>
                         <td>".__("Max InfoWindow Width","wp-google-maps").":</td>
                         <td><input id='wpgmza_settings_infowindow_width' name='wpgmza_settings_infowindow_width' type='text' size='4' maxlength='4' value='$wpgmza_settings_infowindow_width' /> px <em>".__("(Minimum: 250px)","wp-google-maps")."</em></td>
                    </tr>
                    <tr>
                         <td>".__("Other settings","wp-google-maps").":</td>
                         <td>
                                <input name='wpgmza_settings_infowindow_links' type='checkbox' id='wpgmza_settings_infowindow_links' value='yes' $wpgmza_linkschecked /> ".__("Open links in a new window","wp-google-maps")." <em>
                                ".__("(Tick this if you want to open your links in a new window)","wp-google-maps")."</em>
                                <br /><input name='wpgmza_settings_infowindow_address' type='checkbox' id='wpgmza_settings_infowindow_address' value='yes' $wpgmza_addresschecked /> ".__("Hide the address field","wp-google-maps")."<br />
                        </td>
                    </tr>
                    <tr>
                         <td>".__("Link text","wp-google-maps").":</td>
                         <td>
                                <input name='wpgmza_settings_infowindow_link_text' type='text' id='wpgmza_settings_infowindow_link_text' value='$wpgmza_link_text' /> 
                        </td>
                    </tr>

                </table>
                <br /><br />
        ";


    }
}
function wpgmza_version_check() {
  global $wpgmza_version;
  $wpgmza_vc = floatval($wpgmza_version);
  if ($wpgmza_vc < 5.01) {
      echo "<div class='error below-h1'><big><Br />Please <a href=\"plugins.php\">update</a> your WP Google Maps (basic) version to 5.01     or newer in order to make use of the new functionality.<br /><br />
          Your version: $wpgmza_version<br /><Br /></big></div>";
  }

}
function wpgmaps_head_pro() {
    global $wpgmza_tblname_maps;
    if (isset($_POST['wpgmza_savemap'])){
        global $wpdb;

        //var_dump($_POST);

        $map_id = esc_attr($_POST['wpgmza_id']);
        $map_title = esc_attr($_POST['wpgmza_title']);
        $map_height = esc_attr($_POST['wpgmza_height']);
        $map_width = esc_attr($_POST['wpgmza_width']);


        $map_width_type = esc_attr($_POST['wpgmza_map_width_type']);
        if ($map_width_type == "%") { $map_width_type = "\%"; }
        $map_height_type = esc_attr($_POST['wpgmza_map_height_type']);
        if ($map_height_type == "%") { $map_height_type = "\%"; }
        $map_start_location = esc_attr($_POST['wpgmza_start_location']);
        $map_start_zoom = intval($_POST['wpgmza_start_zoom']);
        $type = intval($_POST['wpgmza_map_type']);
        $alignment = intval($_POST['wpgmza_map_align']);
        $order_markers_by = intval($_POST['wpgmza_order_markers_by']);
        $order_markers_choice = intval($_POST['wpgmza_order_markers_choice']);
        $show_user_location = intval($_POST['wpgmza_show_user_location']);
        $directions_enabled = intval($_POST['wpgmza_directions']);
        $bicycle_enabled = intval($_POST['wpgmza_bicycle']);
        $traffic_enabled = intval($_POST['wpgmza_traffic']);
        $dbox = intval($_POST['wpgmza_dbox']);
        $dbox_width = esc_attr($_POST['wpgmza_dbox_width']);
        $default_to = esc_attr($_POST['wpgmza_default_to']);
        $listmarkers = intval($_POST['wpgmza_listmarkers']);
        $listmarkers_advanced = intval($_POST['wpgmza_listmarkers_advanced']);
        if (isset($_POST['wpgmza_filterbycat'])) { $filterbycat = intval($_POST['wpgmza_filterbycat']); } else { $filterbycat = ""; }

        $other_settings = array();
        $other_settings['store_locator_enabled'] = intval($_POST['wpgmza_store_locator']);
        $other_settings['store_locator_distance'] = intval($_POST['wpgmza_store_locator_distance']);
        $other_settings['store_locator_category'] = intval($_POST['wpgmza_store_locator_category_enabled']);

        $other_settings['sl_stroke_color'] = $_POST['sl_stroke_color'];
        $other_settings['sl_stroke_opacity'] = $_POST['sl_stroke_opacity'];
        $other_settings['sl_fill_color'] = $_POST['sl_fill_color'];
        $other_settings['sl_fill_opacity'] = $_POST['sl_fill_opacity'];

        $other_settings['weather_layer'] = intval($_POST['wpgmza_weather']);
        $other_settings['cloud_layer'] = intval($_POST['wpgmza_cloud']);
        $other_settings['transport_layer'] = intval($_POST['wpgmza_transport']);
        
        
        $other_settings_data = maybe_serialize($other_settings);

        
        
        
        $gps = explode(",",$map_start_location);
        $map_start_lat = $gps[0];
        $map_start_lng = $gps[1];
        $map_default_marker = $_POST['upload_default_marker'];
        $kml = esc_attr($_POST['wpgmza_kml']);
        $fusion = esc_attr($_POST['wpgmza_fusion']);

        $data['map_default_starting_lat'] = $map_start_lat;
        $data['map_default_starting_lng'] = $map_start_lng;
        $data['map_default_height'] = $map_height;
        $data['map_default_width'] = $map_width;
        $data['map_default_zoom'] = $map_start_zoom;
        $data['map_default_type'] = $type;
        $data['map_default_alignment'] = $alignment;
        $data['map_default_order_markers_by'] = $order_markers_by;
        $data['map_default_order_markers_choice'] = $order_markers_choice;
        $data['map_default_show_user_location'] = $show_user_location;
        $data['map_default_directions'] = $directions_enabled;
        $data['map_default_bicycle'] = $bicycle_enabled;
        $data['map_default_traffic'] = $traffic_enabled;
        $data['map_default_dbox'] = $dbox;
        $data['map_default_dbox_width'] = $dbox_width;
        $data['map_default_default_to'] = $default_to;
        $data['map_default_listmarkers'] = $listmarkers;
        $data['map_default_listmarkers_advanced'] = $listmarkers_advanced;
        $data['map_default_filterbycat'] = $filterbycat;
        $data['map_default_marker'] = $map_default_marker;
        $data['map_default_width_type'] = $map_width_type;
        $data['map_default_height_type'] = $map_height_type;





        $rows_affected = $wpdb->query( $wpdb->prepare(
                "UPDATE $wpgmza_tblname_maps SET
                map_title = %s,
                map_width = %s,
                map_height = %s,
                map_start_lat = %f,
                map_start_lng = %f,
                map_start_location = %s,
                map_start_zoom = %d,
                default_marker = %s,
                type = %d,
                alignment = %d,
                order_markers_by = %d,
                order_markers_choice = %d,
                show_user_location = %d,
                directions_enabled = %d,
                kml = %s,
                bicycle = %d,
                traffic = %d,
                dbox = %d,
                dbox_width = %s,
                default_to = %s,
                listmarkers = %d,
                listmarkers_advanced = %d,
                filterbycat = %d,
                fusion = %s,
                map_width_type = %s,
                map_height_type = %s,
                other_settings = %s
                WHERE id = %d",

                $map_title,
                $map_width,
                $map_height,
                $map_start_lat,
                $map_start_lng,
                $map_start_location,
                $map_start_zoom,
                $map_default_marker,
                $type,
                $alignment,
                $order_markers_by,
                $order_markers_choice,
                $show_user_location,
                $directions_enabled,
                $kml,
                $bicycle_enabled,
                $traffic_enabled,
                $dbox,
                $dbox_width,
                $default_to,
                $listmarkers,
                $listmarkers_advanced,
                $filterbycat,
                $fusion,
                $map_width_type,
                $map_height_type,
                $other_settings_data,
                $map_id)
        );

        //echo $wpdb->print_error();


        update_option('WPGMZA_SETTINGS', $data);


        echo "<div class='updated'>";
        _e("Your settings have been saved.","wp-google-maps");
        echo "</div>";

    }

    else if (isset($_POST['wpgmza_save_maker_location'])){
        global $wpdb;
        global $wpgmza_tblname;
        $mid = esc_attr($_POST['wpgmaps_marker_id']);
        $wpgmaps_marker_lat = esc_attr($_POST['wpgmaps_marker_lat']);
        $wpgmaps_marker_lng = esc_attr($_POST['wpgmaps_marker_lng']);

        $rows_affected = $wpdb->query( $wpdb->prepare(
                "UPDATE $wpgmza_tblname SET
                lat = %s,
                lng = %s
                WHERE id = %d",

                $wpgmaps_marker_lat,
                $wpgmaps_marker_lng,
                $mid)
        );





        //update_option('WPGMZA', $data);
        echo "<div class='updated'>";
        _e("Your marker location has been saved.","wp-google-maps");
        echo "</div>";


    }
    else if (isset($_POST['wpgmza_save_poly'])){
        global $wpdb;
        global $wpgmza_tblname_poly;
        $mid = esc_attr($_POST['wpgmaps_map_id']);
        $wpgmaps_polydata = esc_attr($_POST['wpgmza_polygon']);
        $linecolor = esc_attr($_POST['poly_line']);
        $fillcolor = esc_attr($_POST['poly_fill']);
        $line_opacity = esc_attr($_POST['poly_line_opacity']);
        if (!isset ($line_opacity) || $line_opacity == "" ) { $line_opacity = "1"; }
        $opacity = esc_attr($_POST['poly_opacity']);

        $rows_affected = $wpdb->query( $wpdb->prepare(
                "INSERT INTO $wpgmza_tblname_poly SET
                map_id = %d,
                polydata = %s,
                linecolor = %s,
                lineopacity = %s,
                fillcolor = %s,
                opacity = %s
                ",

                $mid,
                $wpgmaps_polydata,
                $linecolor,
                $line_opacity,
                $fillcolor,
                $opacity
            )
        );
        echo "<div class='updated'>";
        _e("Your polygon has been created.","wp-google-maps");
        echo "</div>";


    }
    else if (isset($_POST['wpgmza_edit_poly'])){
        global $wpdb;
        global $wpgmza_tblname_poly;
        $mid = esc_attr($_POST['wpgmaps_map_id']);
        $pid = esc_attr($_POST['wpgmaps_poly_id']);
        $wpgmaps_polydata = esc_attr($_POST['wpgmza_polygon']);
        $linecolor = esc_attr($_POST['poly_line']);
        $fillcolor = esc_attr($_POST['poly_fill']);
        $line_opacity = esc_attr($_POST['poly_line_opacity']);
        if (!isset ($line_opacity) || $line_opacity == "" ) { $line_opacity = "1"; }
        $opacity = esc_attr($_POST['poly_opacity']);

        $rows_affected = $wpdb->query( $wpdb->prepare(
                "UPDATE $wpgmza_tblname_poly SET
                polydata = %s,
                linecolor = %s,
                lineopacity = %s,
                fillcolor = %s,
                opacity = %s
                WHERE `id` = %d"
                ,

                $wpgmaps_polydata,
                $linecolor,
                $line_opacity,
                $fillcolor,
                $opacity,
                $pid
            )
        );
        echo "<div class='updated'>";
        _e("Your polygon has been saved.","wp-google-maps");
        echo "</div>";


    }
    else if (isset($_POST['wpgmza_save_polyline'])){
        global $wpdb;
        global $wpgmza_tblname_polylines;
        $mid = esc_attr($_POST['wpgmaps_map_id']);
        $wpgmaps_polydata = esc_attr($_POST['wpgmza_polyline']);
        $linecolor = esc_attr($_POST['poly_line']);
        $linethickness = esc_attr($_POST['poly_thickness']);
        $opacity = esc_attr($_POST['poly_opacity']);

        $rows_affected = $wpdb->query( $wpdb->prepare(
                "INSERT INTO $wpgmza_tblname_polylines SET
                map_id = %d,
                polydata = %s,
                linecolor = %s,
                linethickness = %s,
                opacity = %s
                ",

                $mid,
                $wpgmaps_polydata,
                $linecolor,
                $linethickness,
                $opacity
            )
        );
        echo "<div class='updated'>";
        _e("Your polyline has been created.","wp-google-maps");
        echo "</div>";


    }
    else if (isset($_POST['wpgmza_edit_polyline'])){
        global $wpdb;
        global $wpgmza_tblname_polylines;
        $mid = esc_attr($_POST['wpgmaps_map_id']);
        $pid = esc_attr($_POST['wpgmaps_poly_id']);
        $wpgmaps_polydata = esc_attr($_POST['wpgmza_polyline']);
        $linecolor = esc_attr($_POST['poly_line']);
        $linethickness = esc_attr($_POST['poly_thickness']);
        $opacity = esc_attr($_POST['poly_opacity']);

        $rows_affected = $wpdb->query( $wpdb->prepare(
                "UPDATE $wpgmza_tblname_polylines SET
                polydata = %s,
                linecolor = %s,
                linethickness = %s,
                opacity = %s
                WHERE `id` = %d"
                ,

                $wpgmaps_polydata,
                $linecolor,
                $linethickness,
                $opacity,
                $pid
            )
        );
        echo "<div class='updated'>";
        _e("Your polyline has been saved.","wp-google-maps");
        echo "</div>";


    }
    else if (isset($_POST['wpgmza_save_settings'])){
        global $wpdb;
        if (isset($_POST['wpgmza_settings_image_width'])) { $wpgmza_data['wpgmza_settings_image_width'] = esc_attr($_POST['wpgmza_settings_image_width']); }
        if (isset($_POST['wpgmza_settings_image_height'])) { $wpgmza_data['wpgmza_settings_image_height'] = esc_attr($_POST['wpgmza_settings_image_height']); }
        if (isset($_POST['wpgmza_settings_use_timthumb'])) { $wpgmza_data['wpgmza_settings_use_timthumb'] = esc_attr($_POST['wpgmza_settings_use_timthumb']); }
        if (isset($_POST['wpgmza_settings_infowindow_width'])) { $wpgmza_data['wpgmza_settings_infowindow_width'] = esc_attr($_POST['wpgmza_settings_infowindow_width']); }
        if (isset($_POST['wpgmza_settings_infowindow_links'])) { $wpgmza_data['wpgmza_settings_infowindow_links'] = esc_attr($_POST['wpgmza_settings_infowindow_links']); }
        if (isset($_POST['wpgmza_settings_infowindow_address'])) { $wpgmza_data['wpgmza_settings_infowindow_address'] = esc_attr($_POST['wpgmza_settings_infowindow_address']); }
        if (isset($_POST['wpgmza_settings_infowindow_link_text'])) { $wpgmza_data['wpgmza_settings_infowindow_link_text'] = esc_attr($_POST['wpgmza_settings_infowindow_link_text']); }
        if (isset($_POST['wpgmza_settings_map_streetview'])) { $wpgmza_data['wpgmza_settings_map_streetview'] = esc_attr($_POST['wpgmza_settings_map_streetview']); }
        if (isset($_POST['wpgmza_settings_map_zoom'])) { $wpgmza_data['wpgmza_settings_map_zoom'] = esc_attr($_POST['wpgmza_settings_map_zoom']); }
        if (isset($_POST['wpgmza_settings_map_pan'])) { $wpgmza_data['wpgmza_settings_map_pan'] = esc_attr($_POST['wpgmza_settings_map_pan']); }
        if (isset($_POST['wpgmza_settings_map_type'])) { $wpgmza_data['wpgmza_settings_map_type'] = esc_attr($_POST['wpgmza_settings_map_type']); }
        if (isset($_POST['wpgmza_settings_map_scroll'])) { $wpgmza_data['wpgmza_settings_map_scroll'] = esc_attr($_POST['wpgmza_settings_map_scroll']); }
        if (isset($_POST['wpgmza_settings_map_draggable'])) { $wpgmza_data['wpgmza_settings_map_draggable'] = esc_attr($_POST['wpgmza_settings_map_draggable']); }
        if (isset($_POST['wpgmza_settings_map_clickzoom'])) { $wpgmza_data['wpgmza_settings_map_clickzoom'] = esc_attr($_POST['wpgmza_settings_map_clickzoom']); }
        if (isset($_POST['wpgmza_settings_ugm_striptags'])) { $wpgmza_data['wpgmza_settings_ugm_striptags'] = esc_attr($_POST['wpgmza_settings_map_striptags']); }
        if (isset($_POST['wpgmza_settings_force_jquery'])) { $wpgmza_data['wpgmza_settings_force_jquery'] = esc_attr($_POST['wpgmza_settings_force_jquery']); }
        if (isset($_POST['wpgmza_settings_markerlist_category'])) { $wpgmza_data['wpgmza_settings_markerlist_category'] = esc_attr($_POST['wpgmza_settings_markerlist_category']); }
        if (isset($_POST['wpgmza_settings_markerlist_icon'])) { $wpgmza_data['wpgmza_settings_markerlist_icon'] = esc_attr($_POST['wpgmza_settings_markerlist_icon']); }
        if (isset($_POST['wpgmza_settings_markerlist_title'])) { $wpgmza_data['wpgmza_settings_markerlist_title'] = esc_attr($_POST['wpgmza_settings_markerlist_title']); }
        if (isset($_POST['wpgmza_settings_markerlist_address'])) { $wpgmza_data['wpgmza_settings_markerlist_address'] = esc_attr($_POST['wpgmza_settings_markerlist_address']); }
        if (isset($_POST['wpgmza_settings_markerlist_description'])) { $wpgmza_data['wpgmza_settings_markerlist_description'] = esc_attr($_POST['wpgmza_settings_markerlist_description']); }
        if (isset($_POST['wpgmza_settings_filterbycat_type'])) { $wpgmza_data['wpgmza_settings_filterbycat_type'] = esc_attr($_POST['wpgmza_settings_filterbycat_type']); }
        if (isset($_POST['wpgmza_settings_map_open_marker_by'])) { $wpgmza_data['wpgmza_settings_map_open_marker_by'] = esc_attr($_POST['wpgmza_settings_map_open_marker_by']); }
        if (isset($_POST['wpgmza_api_version'])) { $wpgmza_data['wpgmza_api_version'] = esc_attr($_POST['wpgmza_api_version']); }
        update_option('WPGMZA_OTHER_SETTINGS', $wpgmza_data);
        echo "<div class='updated'>";
        _e("Your settings have been saved.","wp-google-maps");
        echo "</div>";


    }



}
