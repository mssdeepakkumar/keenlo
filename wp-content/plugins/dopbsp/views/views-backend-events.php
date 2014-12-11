<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/views-backend-events.php
* File Version            : 1.0
* Created / Last Modified : 28 May 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end events views class.
*/

    if (!class_exists('DOPBSPViewsEvents')){
        class DOPBSPViewsEvents extends DOPBSPViews{
            /*
             * Constructor
             */
            function DOPBSPViewsEvents(){
            }
            
            /*
             * Returns events template.
             * 
             * @return events HTML page
             */
            function template(){
                global $DOPBSP;
                
                $this->getTranslation();
?>            
    <div class="wrap DOPBSP-admin">
        
<!--
    Header
-->
        <?php $this->displayHeader($DOPBSP->text('TITLE').' - '.$DOPBSP->text('EVENTS_TITLE').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$DOPBSP->text('SOON_TITLE')); ?>

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