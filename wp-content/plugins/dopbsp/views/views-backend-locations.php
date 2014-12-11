<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/views-backend-locations.php
* File Version            : 1.0
* Created / Last Modified : 28 May 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end locations views class.
*/

    if (!class_exists('DOPBSPViewsLocations')){
        class DOPBSPViewsLocations extends DOPBSPViews{
            /*
             * Constructor
             */
            function DOPBSPViewsLocations(){
            }
            
            /*
             * Returns locations template.
             * 
             * @return locations HTML page
             */
            function template(){
                global $DOPBSP;
                
                $this->getTranslation();
?>            
    <div class="wrap DOPBSP-admin">
        
<!--
    Header
-->
        <?php $this->displayHeader($DOPBSP->text('TITLE').' - '.$DOPBSP->text('LOCATIONS_TITLE').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$DOPBSP->text('SOON_TITLE')); ?>

<!-- 
    Content
-->
        <div class="main">
        </div>
    </div>       
<?php
            }
        }
    }