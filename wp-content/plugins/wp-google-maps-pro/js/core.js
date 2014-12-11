var MYMAP = new Array();
var wpgmzaTable = new Array();

var directionsDisplay = new Array();
var directionsService = new Array();
var infoWindow;

for (var entry in wpgmaps_localize) {
    if ('undefined' === typeof window.jQuery) {
        document.getElementById('wpgmza_map_'+wpgmaps_localize[entry]['id']).innerHTML = 'Error: In order for WP Google Maps to work, jQuery must be installed. A check was done and jQuery was not present. Please see the <a href="http://www.wpgmaps.com/documentation/troubleshooting/jquery-troubleshooting/" title="WP Google Maps - jQuery Troubleshooting">jQuery troubleshooting section of our site</a> for more information.';
    }
}

var user_location;

function InitMap(map_id,cat_id) {
    if ('undefined' === cat_id || cat_id === '' || !cat_id || cat_id === 0 || cat_id === "0") { cat_id = 'all'; }
    
    var myLatLng = new window.google.maps.LatLng(wpgmaps_localize[map_id]['map_start_lat'],wpgmaps_localize[map_id]['map_start_lng']);
    google = window.google;
    
    
    MYMAP[map_id].init("#wpgmza_map_"+map_id, myLatLng, parseInt(wpgmaps_localize[map_id]['map_start_zoom']), wpgmaps_localize[map_id]['type'],map_id);
    UniqueCode=Math.round(Math.random()*10000);
    if (wpgmaps_map_mashup) {
        wpgmaps_localize_mashup_ids.forEach(function(entry_mashup) {
            MYMAP[map_id].placeMarkers(wpgmaps_markerurl+entry_mashup+'markers.xml?u='+UniqueCode,map_id,cat_id,null,null,null);
        });
    } else {
        MYMAP[map_id].placeMarkers(wpgmaps_markerurl+map_id+'markers.xml?u='+UniqueCode,map_id,cat_id,null,null,null);
    }
};
function wpgmza_reinitialisetbl(map_id) {
    if (wpgmaps_localize[map_id]['order_markers_by'] === "1") { wpgmaps_order_by = parseInt(0); } 
    else if (wpgmaps_localize[map_id]['order_markers_by'] === "2") { wpgmaps_order_by = parseInt(2); } 
    else if (wpgmaps_localize[map_id]['order_markers_by'] === "3") { wpgmaps_order_by = parseInt(4); } 
    else if (wpgmaps_localize[map_id]['order_markers_by'] === "4") { wpgmaps_order_by = parseInt(5); } 
    else if (wpgmaps_localize[map_id]['order_markers_by'] === "5") { wpgmaps_order_by = parseInt(3); } 
    else { wpgmaps_order_by = 0; }
    if (wpgmaps_localize[map_id]['order_markers_choice'] === "1") { wpgmaps_order_by_choice = "asc"; } 
    else { wpgmaps_order_by_choice = "desc"; }
    wpgmzaTable[map_id].fnClearTable( 0 );
    wpgmzaTable[map_id] = jQuery('#wpgmza_table_'+map_id).dataTable({
        "bProcessing": true,
        "aaSorting": [[wpgmaps_order_by, wpgmaps_order_by_choice]],
        "oLanguage": {
                "sLengthMenu": wpgm_dt_sLengthMenu,
                "sZeroRecords": wpgm_dt_sLengthMenu,
                "sInfo": wpgm_dt_sInfo,
                "sInfoEmpty": wpgm_dt_sInfoEmpty,
                "sInfoFiltered": wpgm_dt_sInfoFiltered,
                "sFirst": wpgm_dt_sFirst,
                "sLast": wpgm_dt_sLast,
                "sNext": wpgm_dt_sNext,
                "sPrevious": wpgm_dt_sPrevious,
                "sSearch": wpgm_dt_sSearch
        }

    });
}

jQuery(function() {

    

    jQuery(document).ready(function(){

        
        
        
        if (/1\.(0|1|2|3|4|5|6|7)\.(0|1|2|3|4|5|6|7|8|9)/.test(jQuery.fn.jquery)) {
            for(var entry in wpgmaps_localize) {
                document.getElementById('wpgmza_map_'+wpgmaps_localize[entry]['id']).innerHTML = 'Error: Your version of jQuery is outdated. WP Google Maps requires jQuery version 1.7+ to function correctly. Go to Maps->Settings and check the box that allows you to over-ride your current jQuery to try eliminate this problem.';
            }
        } else {

            jQuery("body").on("click", ".wpgmaps_mlist_row", function() {
                var wpgmza_markerid = jQuery(this).attr("mid");
                var wpgmza_mapid = jQuery(this).attr("mapid");
                openInfoWindow(wpgmza_markerid);
                location.hash = "#marker" + wpgmza_markerid;
            });
            jQuery("body").on("change", "#wpgmza_filter_select", function() {
                var selectedValue = jQuery(this).find(":selected").val();
                var wpgmza_map_id = jQuery(this).attr("mid");
                InitMap(wpgmza_map_id,selectedValue);
                if (typeof jQuery("#wpgmzaTable_"+wpgmza_map_id) === "object") { 
                    if (selectedValue === 0 || selectedValue === "All" || selectedValue === "0") {
                        wpgmzaTable[wpgmza_map_id].fnFilter( '' );
                    } else { 
                        wpgmzaTable[wpgmza_map_id].fnFilter( this.options[this.selectedIndex].text );
                    }
                } 
            });      
            jQuery("body").on("click", ".wpgmza_checkbox", function() {
                /* do nothing if user has enabled store locator */
                if (typeof jQuery("#addressInput") === "object") { } else {
                
                    var wpgmza_map_id = jQuery(this).attr("mid");
                    var checkedCatValues = jQuery('.wpgmza_checkbox:checked').map(function() {
                        return this.value;
                    }).get();
                    if (checkedCatValues[0] === "0" || typeof checkedCatValues === 'undefined' || checkedCatValues.length < 1) {
                        InitMap(wpgmza_map_id,'all');
                    } else {
                        InitMap(wpgmza_map_id,checkedCatValues);
                    }
                }
                
            });                
            
        

            jQuery("body").on("click", "#wpgmza_use_my_location_from", function() {
                var wpgmza_map_id = jQuery(this).attr("mid");
                jQuery('#wpgmza_input_from_'+wpgmza_map_id).val(wpgmaps_lang_getting_location);

                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': user_location}, function(results, status) {
                  if (status === google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                      jQuery('#wpgmza_input_from_'+wpgmza_map_id).val(results[0].formatted_address);
                    }
                  }
                });
            });                    
            jQuery("body").on("click", "#wpgmza_use_my_location_to", function() {
                var wpgmza_map_id = jQuery(this).attr("mid");
                jQuery('#wpgmza_input_to_'+wpgmza_map_id).val(wpgmaps_lang_getting_location);
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': user_location}, function(results, status) {
                  if (status === google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                      jQuery('#wpgmza_input_to_'+wpgmza_map_id).val(results[0].formatted_address);
                    }
                  }
                });
            });

            jQuery('body').on('tabsactivate', function(event, ui) {
                for(var entry in wpgmaps_localize) {
                    InitMap(wpgmaps_localize[entry]['id'],'all');
                }
            });
            
            

            for(var entry in wpgmaps_localize) {
                if (wpgmaps_localize[entry]['order_markers_by'] === "1") { wpgmaps_order_by = parseInt(0); } 
                else if (wpgmaps_localize[entry]['order_markers_by'] === "2") { wpgmaps_order_by = parseInt(2); } 
                else if (wpgmaps_localize[entry]['order_markers_by'] === "3") { wpgmaps_order_by = parseInt(4); } 
                else if (wpgmaps_localize[entry]['order_markers_by'] === "4") { wpgmaps_order_by = parseInt(5); } 
                else if (wpgmaps_localize[entry]['order_markers_by'] === "5") { wpgmaps_order_by = parseInt(3); } 
                else { wpgmaps_order_by = 0; }
                if (wpgmaps_localize[entry]['order_markers_choice'] === "1") { wpgmaps_order_by_choice = "asc"; } 
                else { wpgmaps_order_by_choice = "desc"; }

                
                if (jQuery('#wpgmza_table_'+wpgmaps_localize[entry]['id']).length === 0) { } else { 
                    wpgmzaTable[wpgmaps_localize[entry]['id']] = jQuery('#wpgmza_table_'+wpgmaps_localize[entry]['id']).dataTable({
                        "bProcessing": true,
                        "aaSorting": [[wpgmaps_order_by, wpgmaps_order_by_choice]],
                        "oLanguage": {
                            "sLengthMenu": wpgm_dt_sLengthMenu,
                            "sZeroRecords": wpgm_dt_sLengthMenu,
                            "sInfo": wpgm_dt_sInfo,
                            "sInfoEmpty": wpgm_dt_sInfoEmpty,
                            "sInfoFiltered": wpgm_dt_sInfoFiltered,
                            "sFirst": wpgm_dt_sFirst,
                            "sLast": wpgm_dt_sLast,
                            "sNext": wpgm_dt_sNext,
                            "sPrevious": wpgm_dt_sPrevious,
                            "sSearch": wpgm_dt_sSearch
                        }
                     });
                }
            }
            
            
            for(var entry in wpgmaps_localize) {
                jQuery("#wpgmza_map_"+wpgmaps_localize[entry]['id']).css({
                    height:wpgmaps_localize[entry]['map_height']+''+wpgmaps_localize[entry]['map_height_type'],
                    width:wpgmaps_localize[entry]['map_width']+''+wpgmaps_localize[entry]['map_width_type']

                });            
            }
            
            // here
    
            for(var entry in wpgmaps_localize) {
                InitMap(wpgmaps_localize[entry]['id'],wpgmaps_localize_cat_ids[wpgmaps_localize[entry]['id']]);
            }
        
        }
        
        

    
    
         
        

    });
    
    
    
    
    
    
    
    
    for(var entry in wpgmaps_localize) {

    // general directions settings and variables
    directionsDisplay[wpgmaps_localize[entry]['id']];
    directionsService[wpgmaps_localize[entry]['id']] = new google.maps.DirectionsService();
    var currentDirections = null;
    var oldDirections = [];
    var new_gps;

    if (wpgmaps_localize[entry]['styling_json'] !== '' && wpgmaps_localize[entry]['styling_enabled'] === "1") {
        wpgmza_adv_styling_json = jQuery.parseJSON(wpgmaps_localize[entry]['styling_json']);
    } else {
        wpgmza_adv_styling_json = "";
    }


    MYMAP[wpgmaps_localize[entry]['id']] = {
        map: null,
        bounds: null,
        mc: null
    };

    
    if (wpgmaps_localize_global_settings['wpgmza_settings_map_draggable'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_draggable']) { wpgmza_settings_map_draggable = true; } else { wpgmza_settings_map_draggable = false;  }
    if (wpgmaps_localize_global_settings['wpgmza_settings_map_clickzoom'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_clickzoom']) { wpgmza_settings_map_clickzoom = false; } else { wpgmza_settings_map_clickzoom = true; }
    if (wpgmaps_localize_global_settings['wpgmza_settings_map_scroll'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_scroll']) { wpgmza_settings_map_scroll = true; } else { wpgmza_settings_map_scroll = false; }
    if (wpgmaps_localize_global_settings['wpgmza_settings_map_zoom'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_zoom']) { wpgmza_settings_map_zoom = true; } else { wpgmza_settings_map_zoom = false; }
    if (wpgmaps_localize_global_settings['wpgmza_settings_map_pan'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_pan']) { wpgmza_settings_map_pan = true; } else { wpgmza_settings_map_pan = false; }
    if (wpgmaps_localize_global_settings['wpgmza_settings_map_type'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_type']) { wpgmza_settings_map_type = true; } else { wpgmza_settings_map_type = false; }
    if (wpgmaps_localize_global_settings['wpgmza_settings_map_streetview'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_streetview']) { wpgmza_settings_map_streetview = true; } else { wpgmza_settings_map_streetview = false; }


    
    
    MYMAP[wpgmaps_localize[entry]['id']].init = function(selector, latLng, zoom, maptype, mapid) {
        if (maptype === "1") { 
            var myOptions = {
                zoom:zoom,
                center: latLng,
                draggable: wpgmza_settings_map_draggable,
                disableDoubleClickZoom: wpgmza_settings_map_clickzoom,
                scrollwheel: wpgmza_settings_map_scroll,
                zoomControl: wpgmza_settings_map_zoom,
                panControl: wpgmza_settings_map_pan,
                mapTypeControl: wpgmza_settings_map_type,
                streetViewControl: wpgmza_settings_map_streetview,
                mapTypeId: google.maps.MapTypeId.ROADMAP
              };
        }
        else if (maptype === "2") { 
            var myOptions = {
                zoom:zoom,
                center: latLng,
                draggable: wpgmza_settings_map_draggable,
                disableDoubleClickZoom: wpgmza_settings_map_clickzoom,
                scrollwheel: wpgmza_settings_map_scroll,
                zoomControl: wpgmza_settings_map_zoom,
                panControl: wpgmza_settings_map_pan,
                mapTypeControl: wpgmza_settings_map_type,
                streetViewControl: wpgmza_settings_map_streetview,
                mapTypeId: google.maps.MapTypeId.SATELLITE
              };

        }
        else if (maptype === "3") { 
            var myOptions = {
                zoom:zoom,
                center: latLng,
                draggable: wpgmza_settings_map_draggable,
                disableDoubleClickZoom: wpgmza_settings_map_clickzoom,
                scrollwheel: wpgmza_settings_map_scroll,
                zoomControl: wpgmza_settings_map_zoom,
                panControl: wpgmza_settings_map_pan,
                mapTypeControl: wpgmza_settings_map_type,
                streetViewControl: wpgmza_settings_map_streetview,
                mapTypeId: google.maps.MapTypeId.HYBRID
              };


        }
        else if (maptype === "4") { 
            var myOptions = {
                zoom:zoom,
                center: latLng,
                draggable: wpgmza_settings_map_draggable,
                disableDoubleClickZoom: wpgmza_settings_map_clickzoom,
                scrollwheel: wpgmza_settings_map_scroll,
                zoomControl: wpgmza_settings_map_zoom,
                panControl: wpgmza_settings_map_pan,
                mapTypeControl: wpgmza_settings_map_type,
                streetViewControl: wpgmza_settings_map_streetview,
                mapTypeId: google.maps.MapTypeId.TERRAIN
              };

        }
        else { 
            var myOptions = {
                zoom:zoom,
                center: latLng,
                draggable: wpgmza_settings_map_draggable,
                disableDoubleClickZoom: wpgmza_settings_map_clickzoom,
                scrollwheel: wpgmza_settings_map_scroll,
                zoomControl: wpgmza_settings_map_zoom,
                panControl: wpgmza_settings_map_pan,
                mapTypeControl: wpgmza_settings_map_type,
                streetViewControl: wpgmza_settings_map_streetview,
                mapTypeId: google.maps.MapTypeId.ROADMAP
              };


        }
        if (wpgm_g_e === true) {
            if (wpgmza_adv_styling_json !== "") {
                var WPGMZA_STYLING = new google.maps.StyledMapType(wpgmza_adv_styling_json,{name: "WPGMZA STYLING"});
            }

            this.map = new google.maps.Map(jQuery(selector)[0], myOptions);

            if (wpgmza_adv_styling_json !== "") {
                this.map.mapTypes.set('WPGMZA STYLING', WPGMZA_STYLING);
                this.map.setMapTypeId('WPGMZA STYLING');
            }
        } else {
            this.map = new google.maps.Map(jQuery(selector)[0], myOptions);
        }
        

        this.bounds = new google.maps.LatLngBounds();
        directionsDisplay[mapid] = new google.maps.DirectionsRenderer({
             'map': this.map,
             'preserveViewport': true,
             'draggable': true
         });
        directionsDisplay[mapid].setPanel(document.getElementById("directions_panel_"+mapid));
        
        
        google.maps.event.addListener(directionsDisplay[mapid], 'directions_changed',
          function() {
              if (currentDirections) {
                  oldDirections.push(currentDirections);
              }
              currentDirections = directionsDisplay[mapid].getDirections();
              jQuery("#directions_panel_"+mapid).show();
              jQuery("#wpgmaps_directions_notification_"+mapid).hide();
              jQuery("#wpgmaps_directions_reset_"+mapid).show();
          });
                
                
        /* insert polygon and polyline functionality */
        if (wpgmaps_localize_polygon_settings !== null) {
            if (wpgmaps_localize_polygon_settings[mapid] !== null) { 
               for(var poly_entry in wpgmaps_localize_polygon_settings[mapid]) {
                   var tmp_data = wpgmaps_localize_polygon_settings[mapid];

                   var tmp_polydata = tmp_data[poly_entry]['polydata'];


                    var WPGM_PathData = new Array();
                    for (tmp_entry2 in tmp_polydata) {
                        WPGM_PathData.push(new google.maps.LatLng(tmp_polydata[tmp_entry2][0], tmp_polydata[tmp_entry2][1]));

                    }
                    if (tmp_data[poly_entry]['lineopacity'] === null || tmp_data[poly_entry]['lineopacity'] === "") {
                        tmp_data[poly_entry]['lineopacity'] = 1;
                    }

                   var WPGM_Path = new google.maps.Polygon({
                    path: WPGM_PathData,
                    clickable: false, /* must add option for this */ 
                    strokeColor: "#"+tmp_data[poly_entry]['linecolor'],
                    fillOpacity: tmp_data[poly_entry]['opacity'],
                    strokeOpacity: tmp_data[poly_entry]['lineopacity'],
                    fillColor: "#"+tmp_data[poly_entry]['fillcolor'],
                    strokeWeight: 2
                  });
                  WPGM_Path.setMap(MYMAP[mapid].map);
                  
                  /*
                   * will bring into the next version - need to build options in the admin section to control this
                   * 
                  google.maps.event.addListener(WPGM_Path, "mouseover", function(event) {
                        this.setOptions({fillColor: "#00FF00"});
                        this.setOptions({fillOpacity: 0.5});
                        this.setOptions({strokeColor: "#00FF00"});
                        this.setOptions({strokeWeight: 2});
                        this.setOptions({strokeOpacity: 0.9});
                  });
                  google.maps.event.addListener(WPGM_Path, "click", function(event) {
                        this.setOptions({fillColor: "#00FF00"});
                        this.setOptions({fillOpacity: 0.5});
                        this.setOptions({strokeColor: "#00FF00"});
                        this.setOptions({strokeWeight: 2});
                        this.setOptions({strokeOpacity: 0.9});
                  });
                  google.maps.event.addListener(WPGM_Path, "mouseout", function(event) {
                        this.setOptions({fillColor: "#"+tmp_data[poly_entry]['fillcolor']});
                        this.setOptions({fillOpacity: tmp_data[poly_entry]['opacity']});
                        this.setOptions({strokeColor: "#"+tmp_data[poly_entry]['linecolor']});
                        this.setOptions({strokeWeight: 2});
                        this.setOptions({strokeOpacity: tmp_data[poly_entry]['lineopacity']});
                  });
                      */

               }
          
          
            }
        }
        
        if (wpgmaps_localize_polyline_settings !== null) {
            if (wpgmaps_localize_polyline_settings[mapid] !== null) { 
                for(var poly_entry in wpgmaps_localize_polyline_settings[mapid]) {
                    var tmp_data = wpgmaps_localize_polyline_settings[mapid];

                    var tmp_polydata = tmp_data[poly_entry]['polydata'];
                     var WPGM_PathData = new Array();
                     for (tmp_entry2 in tmp_polydata) {
                         WPGM_PathData.push(new google.maps.LatLng(tmp_polydata[tmp_entry2][0], tmp_polydata[tmp_entry2][1]));

                     }
                    if (tmp_data[poly_entry]['lineopacity'] === null || tmp_data[poly_entry]['lineopacity'] === "") {
                        tmp_data[poly_entry]['lineopacity'] = 1;
                    }
                    
                    var WPGM_Path = new google.maps.Polyline({
                     path: WPGM_PathData,
                     strokeColor: "#"+tmp_data[poly_entry]['linecolor'],
                     strokeOpacity: tmp_data[poly_entry]['opacity'],
                     fillColor: "#"+tmp_data[poly_entry]['fillcolor'],
                     strokeWeight: tmp_data[poly_entry]['linethickness']
                   });
                   WPGM_Path.setMap(MYMAP[mapid].map);

                }
             }
        }
        
                
        if (wpgmaps_localize[entry]['bicycle'] === "1") {
            var bikeLayer = new google.maps.BicyclingLayer();
            bikeLayer.setMap(MYMAP[mapid].map);
        }        
        if (wpgmaps_localize[entry]['traffic'] === "1") {
            var trafficLayer = new google.maps.TrafficLayer();
            trafficLayer.setMap(MYMAP[mapid].map);
        }        
        if ("undefined" !== typeof wpgmaps_localize[mapid]['other_settings']['weather_layer'] && wpgmaps_localize[mapid]['other_settings']['weather_layer'] === 1) {
            if ("undefined" === typeof google.maps.weather) { } else {
                var weatherLayer = new google.maps.weather.WeatherLayer();
                weatherLayer.setMap(MYMAP[mapid].map);
            }
        }        
        if ("undefined" !== typeof wpgmaps_localize[mapid]['other_settings']['cloud_layer'] && wpgmaps_localize[mapid]['other_settings']['cloud_layer'] === 1) {
            if ("undefined" === typeof google.maps.weather) { } else {
                var cloudLayer = new google.maps.weather.CloudLayer();
                cloudLayer.setMap(MYMAP[mapid].map);
            }
        }        
        if ("undefined" !== typeof wpgmaps_localize[mapid]['other_settings']['transport_layer'] && wpgmaps_localize[mapid]['other_settings']['transport_layer'] === 1) {
                var transitLayer = new google.maps.TransitLayer();
                transitLayer.setMap(MYMAP[mapid].map);
        }        
        if (wpgmaps_localize[entry]['kml'] !== "") {
            var wpgmaps_d = new Date();
            var wpgmaps_ms = wpgmaps_d.getTime();
            var georssLayer = new google.maps.KmlLayer(wpgmaps_localize[mapid]['kml']+'?tstamp='+wpgmaps_ms);
            georssLayer.setMap(MYMAP[mapid].map);
        }        
        if (wpgmaps_localize[entry]['fusion'] !== "") {
            var fusionlayer = new google.maps.FusionTablesLayer(wpgmaps_localize[mapid]['fusion'], {
                  suppressInfoWindows: false
            });
            fusionlayer.setMap(MYMAP[mapid].map);
        }        
    };    

    
    infoWindow = new google.maps.InfoWindow();
    if (wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']) {
        wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width'] = '250';
    }
    infoWindow.setOptions({maxWidth:wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']});

    /* deprecated version 5.22
     * google.maps.event.addDomListener(window, 'resize', function() {
        var myLatLng = new google.maps.LatLng(wpgmaps_localize[entry]['map_start_lat'],wpgmaps_localize[entry]['map_start_lng']);
        
        if ('undefined' !== typeof MYMAP[wpgmaps_localize[entry]['id']].map) {
            MYMAP[wpgmaps_localize[entry]['id']].map.setCenter(myLatLng);
        }
    });
    **/
    


    MYMAP[wpgmaps_localize[entry]['id']].placeMarkers = function(filename,map_id,cat_id,radius,searched_center,distance_type) {
        marker_array = [];
        marker_array2 = [];
        var check1 = 0;
        jQuery.get(filename, function(xml){

            jQuery(xml).find("marker").each(function(){
                var wpgmza_def_icon = wpgmaps_localize[entry]['default_marker'];
                var wpmgza_map_id = jQuery(this).find('map_id').text();
                var wpmgza_marker_id = jQuery(this).find('marker_id').text();

                var wpmgza_title = jQuery(this).find('title').text();
                var wpmgza_address = jQuery(this).find('address').text();
                var wpmgza_show_address = jQuery(this).find('address').text();
                var wpmgza_mapicon = jQuery(this).find('icon').text();
                var wpmgza_image = jQuery(this).find('pic').text();
                var wpmgza_desc  = jQuery(this).find('desc').text();
                var wpmgza_linkd = jQuery(this).find('linkd').text();
                var wpmgza_anim  = jQuery(this).find('anim').text();
                var wpmgza_category  = jQuery(this).find('category').text();
                var current_lat = jQuery(this).find('lat').text();
                var current_lng = jQuery(this).find('lng').text();
                var show_marker_radius = true;


                

                if (radius !== null) {


                    if (check1 > 0 ) { } else { 
                        var sl_stroke_color = wpgmaps_localize[map_id]['other_settings']['sl_stroke_color'];
                        if (sl_stroke_color !== "" || sl_stroke_color !== null) { } else { sl_stroke_color = 'FF0000'; }
                        var sl_stroke_opacity = wpgmaps_localize[map_id]['other_settings']['sl_stroke_opacity'];
                        if (sl_stroke_opacity !== "" || sl_stroke_opacity !== null) { } else { sl_stroke_opacity = '0.25'; }
                        var sl_fill_opacity = wpgmaps_localize[map_id]['other_settings']['sl_fill_opacity'];
                        if (sl_fill_opacity !== "" || sl_fill_opacity !== null) { } else { sl_fill_opacity = '0.15'; }
                        var sl_fill_color = wpgmaps_localize[map_id]['other_settings']['sl_fill_color'];
                        if (sl_fill_color !== "" || sl_fill_color !== null) { } else { sl_fill_color = 'FF0000'; }
                        
                        var point = new google.maps.LatLng(parseFloat(searched_center.lat()),parseFloat(searched_center.lng()));
                        MYMAP[wpgmaps_localize[entry]['id']].bounds.extend(point);
                        if (wpmgza_mapicon === null || wpmgza_mapicon === "" || wpmgza_mapicon === 0 || wpmgza_mapicon === "0") {
                            var marker = new google.maps.Marker({
                                    position: point,
                                    map: MYMAP[map_id].map,
                                    animation: google.maps.Animation.BOUNCE
                            });

                        } else {
                            var marker = new google.maps.Marker({
                                    position: point,
                                    map: MYMAP[map_id].map,
                                    icon: wpmgza_mapicon,
                                    animation: google.maps.Animation.BOUNCE
                            });
                        }
                        if (distance_type === "1") {
                            var populationOptions = {
                                    strokeColor: '#'+sl_stroke_color,
                                    strokeOpacity: sl_stroke_opacity,
                                    strokeWeight: 2,
                                    fillColor: '#'+sl_fill_color,
                                    fillOpacity: sl_fill_opacity,
                                    map: MYMAP[map_id].map,
                                    center: point,
                                    radius: parseInt(radius / 0.000621371)
                                  };
                          } else {
                              var populationOptions = {
                                    strokeColor: '#'+sl_stroke_color,
                                    strokeOpacity: sl_stroke_opacity,
                                    strokeWeight: 2,
                                    fillColor: '#'+sl_fill_color,
                                    fillOpacity: sl_fill_opacity,
                                    map: MYMAP[map_id].map,
                                    center: point,
                                    radius: parseInt(radius / 0.001)
                                  };
                          }
                        // Add the circle for this city to the map.
                        cityCircle = new google.maps.Circle(populationOptions);
                        check1 = check1 + 1;
                    }

                    if (distance_type === "1") {
                        R = 3958.7558657440545; // Radius of earth in Miles 
                    } else {
                        R = 6378.16; // Radius of earth in kilometers 
                    }
                    var dLat = toRad(searched_center.lat()-current_lat);
                    var dLon = toRad(searched_center.lng()-current_lng); 
                    var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(toRad(current_lat)) * Math.cos(toRad(searched_center.lat())) * Math.sin(dLon/2) * Math.sin(dLon/2); 
                    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
                    var d = R * c;
                    //alert("distance: "+d);
                    if (d < radius) { show_marker_radius = true; } else { show_marker_radius = false; }
                }
                var cat_is_cat;
                cat_is_cat = false;
                if( Object.prototype.toString.call( cat_id ) === '[object Array]' ) {
                    /* work with category array */
                    if (cat_id[0] === '0') { cat_id === "all"; }
                    for (var tmp_val in cat_id) {
                        if (cat_id[tmp_val] === wpmgza_category) { 
                            cat_is_cat = true;
                            break;
                        }
                    }
                } else {
                    if (cat_id === wpmgza_category) {
                        cat_is_cat = true;
                    }
                }  
                                            
                if (cat_id === 'all' || cat_is_cat) {

                    var wpmgza_infoopen  = jQuery(this).find('infoopen').text();
                    if (wpmgza_title !== "") {
                        wpmgza_title = wpmgza_title+'<br />';
                    }
                    if (wpmgza_image !== "") {
                        if (wpgmaps_localize_global_settings['wpgmza_settings_image_width'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_image_width']) { wpgmaps_localize_global_settings['wpgmza_settings_image_width'] = '100'; }
                        if (wpgmaps_localize_global_settings['wpgmza_settings_image_height'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_image_height']) { wpgmaps_localize_global_settings['wpgmza_settings_image_height'] = '100'; }
                        if (wpgmaps_localize_global_settings['wpgmza_settings_use_timthumb'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_use_timthumb']) {
                            wpmgza_image = "<img src=\""+wpgmaps_plugurl+"/timthumb.php?src="+wpmgza_image+"&h="+wpgmaps_localize_global_settings['wpgmza_settings_image_height']+"&w="+wpgmaps_localize_global_settings['wpgmza_settings_image_width']+"&zc=1\" title=\"\" alt=\"\" style=\"float:right; width:"+wpgmaps_localize_global_settings['wpgmza_settings_image_width']+"px; height:"+wpgmaps_localize_global_settings['wpgmza_settings_image_height']+"px;\" />";
                        } else {
                            wpmgza_image = "<img src=\""+wpmgza_image+"\" class=\"wpgmza_map_image\" style=\"float:right; margin:5px; height:"+wpgmaps_localize_global_settings['wpgmza_settings_image_height']+"px; width:"+wpgmaps_localize_global_settings['wpgmza_settings_image_width']+"px\" />";
                        }

                    } else { wpmgza_image = ""; }
                    if (wpmgza_linkd !== "") {
                        if (wpgmaps_localize_global_settings['wpgmza_settings_infowindow_links'] === "yes") { wpgmza_iw_links_target = "target='_BLANK'";  }
                        else { wpgmza_iw_links_target = ''; }
                        wpmgza_linkd = "<a href=\""+wpmgza_linkd+"\" "+wpgmza_iw_links_target+" title=\""+wpgmaps_lang_more_details+"\">"+wpgmaps_lang_more_details+"</a><br />";
                    }

                    if (wpmgza_mapicon === "" || !wpmgza_mapicon) { if (wpgmza_def_icon !== "") { wpmgza_mapicon = wpgmaps_localize[entry]['default_marker']; } }


                    var lat = jQuery(this).find('lat').text();
                    var lng = jQuery(this).find('lng').text();
                    var point = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));
                    MYMAP[wpgmaps_localize[entry]['id']].bounds.extend(point);
                    if (show_marker_radius === true) {
                        if (wpmgza_anim === "1") {
                            if (wpmgza_mapicon === null || wpmgza_mapicon === "" || wpmgza_mapicon === 0 || wpmgza_mapicon === "0") {
                                var marker = new google.maps.Marker({
                                        position: point,
                                        map: MYMAP[map_id].map,
                                        animation: google.maps.Animation.BOUNCE
                                });
                            } else {
                                var marker = new google.maps.Marker({
                                        position: point,
                                        map: MYMAP[map_id].map,
                                        icon: wpmgza_mapicon,
                                        animation: google.maps.Animation.BOUNCE
                                });
                            }
                        }
                        else if (wpmgza_anim === "2") {
                            if (wpmgza_mapicon === null || wpmgza_mapicon === "" || wpmgza_mapicon === 0 || wpmgza_mapicon === "0") {
                                var marker = new google.maps.Marker({
                                        position: point,
                                        map: MYMAP[map_id].map,
                                        animation: google.maps.Animation.DROP
                                });
                                
                            } else {

                                var marker = new google.maps.Marker({
                                        position: point,
                                        map: MYMAP[map_id].map,
                                        icon: wpmgza_mapicon,
                                        animation: google.maps.Animation.DROP
                                });
                            }
                        }
                        else {
                            if (wpmgza_mapicon === null || wpmgza_mapicon === "" || wpmgza_mapicon === 0 || wpmgza_mapicon === "0") {
                                var marker = new google.maps.Marker({
                                        position: point,
                                        map: MYMAP[map_id].map
                                });
                                
                            } else {
                                var marker = new google.maps.Marker({
                                        position: point,
                                        map: MYMAP[map_id].map,
                                        icon: wpmgza_mapicon
                                });
                            }
                        }

                        if (wpgmaps_localize_global_settings['wpgmza_settings_infowindow_address'] === "yes") {
                            wpmgza_show_address = "";
                        }
                        if (wpgmaps_localize[entry]['directions_enabled'] === "1") {
                            wpmgza_dir_enabled = '<a href="javascript:void(0);" id="'+map_id+'" class="wpgmza_gd" wpgm_addr_field="'+wpmgza_address+'" gps="'+parseFloat(lat)+','+parseFloat(lng)+'">'+wpgmaps_lang_get_dir+'</a>';
                        } else {
                            wpmgza_dir_enabled = '';
                        }
                        if (radius !== null) {                                 
                                    if (distance_type === "1") {
                                        d_string = "<br />"+Math.round(d,2)+" miles away<br />"; 
                                    } else {
                                        d_string = "<br />"+Math.round(d,2)+" km away<br />"; 
                                    }
                                } else { d_string = ''; }

                        if (wpmgza_image !== "") {
                            var html='<div class="wpgmza_markerbox" style=\"display:block; width:'+wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']+'px;">'
                                +wpmgza_image+
                                '<strong>'
                                +wpmgza_title+
                                '</strong>'+wpmgza_show_address+'<br /><p style="display:block; min-width:150px;">'
                                +wpmgza_desc+
                                '</p>'
                                +wpmgza_linkd+
                                d_string+
                                ''+
                                wpmgza_dir_enabled+
                                '</div>';

                        } else {
                            var html='<div class="wpgmza_markerbox" style=\"display:block;">'
                                +wpmgza_image+
                                '<strong>'
                                +wpmgza_title+
                                '</strong>'+wpmgza_show_address+'<br /><p style="display:block; min-width:150px;">'
                                +wpmgza_desc+
                                '</p>'
                                +wpmgza_linkd+
                                d_string+
                                ''+
                                wpmgza_dir_enabled+
                                '</div>';

                        }


                        if (wpmgza_infoopen === "1") {
                            //infoWindow.close();
                            infoWindow.setContent(html);
                            infoWindow.open(MYMAP[map_id].map, marker);
                        }
                        if (wpgmaps_localize_global_settings['wpgmza_settings_map_open_marker_by'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_open_marker_by'] || wpgmaps_localize_global_settings['wpgmza_settings_map_open_marker_by'] === '1') { 
                            google.maps.event.addListener(marker, 'click', function(evt) {
                                infoWindow.close();
                                infoWindow.setOptions({maxWidth:wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']});
                                infoWindow.setContent(html);
                                infoWindow.open(MYMAP[map_id].map, marker);
                                //MYMAP.map.setCenter(this.position);
                            }); 
                        } else {
                            google.maps.event.addListener(marker, 'mouseover', function(evt) {
                                infoWindow.close();
                                infoWindow.setOptions({maxWidth:wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']});
                                infoWindow.setContent(html);
                                infoWindow.open(MYMAP[map_id].map, marker);
                                //MYMAP.map.setCenter(this.position);
                            }); 
                        }

                        marker_array[wpmgza_marker_id] = marker;
                        marker_array2.push(marker);
                    }
                }

            });
            if (wpgm_g_e === true) {
                var mcOptions = {
                    gridSize: 20,
                    maxZoom: 15,
                    styles: [{
                        height: 53,
                        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m1.png",
                        width: 53
                    },
                    {
                        height: 56,
                        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m2.png",
                        width: 56
                    },
                    {
                        height: 66,
                        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m3.png",
                        width: 66
                    },
                    {
                        height: 78,
                        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m4.png",
                        width: 78
                    },
                    {
                        height: 90,
                        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m5.png",
                        width: 90
                    }] 
                };
                if (wpgmaps_localize[entry]['mass_marker_support'] === "1" || wpgmaps_localize[entry]['mass_marker_support'] === null) { 
                    MYMAP[map_id].mc = new MarkerClusterer(MYMAP[map_id].map, marker_array2, mcOptions);
                }
            }

        });
        if (wpgmaps_localize[entry]['show_user_location'] === "1") {
            // Try HTML5 geolocation
            if(navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                  user_location = new google.maps.LatLng(position.coords.latitude,
                                                   position.coords.longitude);

                  var marker = new google.maps.Marker({
                          position: user_location,
                          map: MYMAP[wpgmaps_localize[entry]['id']].map,
                          animation: google.maps.Animation.DROP
                  });     
                  google.maps.event.addListener(marker, 'click', function(evt) {
                          infoWindow.close();
                          infoWindow.setContent(wpgmaps_lang_my_location);
                          infoWindow.open(MYMAP[wpgmaps_localize[entry]['id']].map, marker);
                      });
                  marker_array[marker_array+1] = marker;
                });
             } else {
              // Browser doesn't support Geolocation
            }       
        }

    };
    
  
    

}






});




function openInfoWindow(marker_id) {
    if (wpgmaps_localize_global_settings['wpgmza_settings_map_open_marker_by'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_open_marker_by'] || wpgmaps_localize_global_settings['wpgmza_settings_map_open_marker_by'] === '1') { 
        google.maps.event.trigger(marker_array[marker_id], 'click');
    } else {
        google.maps.event.trigger(marker_array[marker_id], 'mouseover');
    }
}






function calcRoute(start,end,mapid,travelmode,avoidtolls,avoidhighways) {
    var request = {
        origin:start,
        destination:end,
        travelMode: google.maps.DirectionsTravelMode[travelmode],
        avoidHighways: avoidhighways,
        avoidTolls: avoidtolls
    };

    directionsService[mapid].route(request, function(response, status) {
      if (status === google.maps.DirectionsStatus.OK) {
        directionsDisplay[mapid].setDirections(response);
      }
    });
  }
function wpgmza_show_options(wpgmzamid) {

      jQuery("#wpgmza_options_box_"+wpgmzamid).show();
      jQuery("#wpgmza_show_options_"+wpgmzamid).hide();
      jQuery("#wpgmza_hide_options_"+wpgmzamid).show();
  }
function wpgmza_hide_options(wpgmzamid) {
      jQuery("#wpgmza_options_box_"+wpgmzamid).hide();
      jQuery("#wpgmza_show_options_"+wpgmzamid).show();
      jQuery("#wpgmza_hide_options_"+wpgmzamid).hide();
  }
function wpgmza_reset_directions(wpgmzamid) {

    jQuery("#wpgmaps_directions_editbox_"+wpgmzamid).show();
    jQuery("#directions_panel_"+wpgmzamid).hide();
    jQuery("#wpgmaps_directions_notification_"+wpgmzamid).hide();
    jQuery("#wpgmaps_directions_reset_"+wpgmzamid).hide();
  }

jQuery("body").on("click", ".wpgmza_gd", function() {
    var wpgmzamid = jQuery(this).attr("id");
    var end = jQuery(this).attr("wpgm_addr_field");
    jQuery("#wpgmaps_directions_edit_"+wpgmzamid).show();
    jQuery("#wpgmaps_directions_editbox_"+wpgmzamid).show();
    jQuery("#wpgmza_input_to_"+wpgmzamid).val(end);
    jQuery("#wpgmza_input_from_"+wpgmzamid).focus().select();

});

jQuery("body").on("click", ".wpgmaps_get_directions", function() {

     var wpgmzamid = jQuery(this).attr("id");

     var avoidtolls = jQuery('#wpgmza_tolls_'+wpgmzamid).is(':checked');
     var avoidhighways = jQuery('#wpgmza_highways_'+wpgmzamid).is(':checked');


     var wpgmza_dir_type = jQuery("#wpgmza_dir_type_"+wpgmzamid).val();
     var wpgmaps_from = jQuery("#wpgmza_input_from_"+wpgmzamid).val();
     var wpgmaps_to = jQuery("#wpgmza_input_to_"+wpgmzamid).val();
     if (wpgmaps_from === "" || wpgmaps_to === "") { alert(wpgmaps_lang_error1); }
     else { calcRoute(wpgmaps_from,wpgmaps_to,wpgmzamid,wpgmza_dir_type,avoidtolls,avoidhighways); jQuery("#wpgmaps_directions_editbox_"+wpgmzamid).hide("slow"); jQuery("#wpgmaps_directions_notification_"+wpgmzamid).show("slow");  }
});





function searchLocations(map_id) {
    var address = document.getElementById("addressInput").value;
    var checkedCatValues = jQuery('.wpgmza_checkbox:checked').map(function() {
        return this.value;
    }).get();
    if (checkedCatValues === "" || checkedCatValues.length < 1 || checkedCatValues === 0 || checkedCatValues === "0") { checkedCatValues = 'all'; }

    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({address: address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
            searchLocationsNear(map_id,checkedCatValues,results[0].geometry.location);
      } else {
           alert(address + ' not found');
      }
    });
  }

function clearLocations() {
    infoWindow.close();
}




function searchLocationsNear(mapid,category,center_searched) {
    clearLocations();
    var distance_type = document.getElementById("wpgmza_distance_type").value;
    var radius = document.getElementById('radiusSelect').value;
    if (parseInt(category) === 0) { category = 'all'; }
    if (category === "0") { category = 'all'; }
    if (category === "Not found") { category = 'all'; }
    if (category === null) { category = 'all'; }
    if (category.length < 1) { category = 'all'; }

    if (distance_type === "1") {
        if (radius === "1") { zoomie = 14; }
        else if (radius === "5") { zoomie = 12; }
        else if (radius === "10") { zoomie = 11; }
        else if (radius === "25") { zoomie = 9; }
        else if (radius === "50") { zoomie = 8; }
        else if (radius === "75") { zoomie = 8; }
        else if (radius === "100") { zoomie = 7; }
        else if (radius === "150") { zoomie = 7; }
        else if (radius === "200") { zoomie = 6; }
        else if (radius === "300") { zoomie = 6; }
        else { zoomie = 14; }
    } else {
        if (radius === "1") { zoomie = 14; }
        else if (radius === "5") { zoomie = 12; }
        else if (radius === "10") { zoomie = 11; }
        else if (radius === "25") { zoomie = 10; }
        else if (radius === "50") { zoomie = 9; }
        else if (radius === "75") { zoomie = 9; }
        else if (radius === "100") { zoomie = 8; }
        else if (radius === "150") { zoomie = 8; }
        else if (radius === "200") { zoomie = 7; }
        else if (radius === "300") { zoomie = 7; }
        else { zoomie = 14; }
    }
    MYMAP[mapid].init("#wpgmza_map_"+mapid, center_searched, zoomie, 3,mapid);
    MYMAP[mapid].placeMarkers(wpgmaps_markerurl+mapid+'markers.xml?u='+UniqueCode,mapid,category,radius,center_searched,distance_type);
}

function toRad(Value) {
    /** Converts numeric degrees to radians */
    return Value * Math.PI / 180;
}   
