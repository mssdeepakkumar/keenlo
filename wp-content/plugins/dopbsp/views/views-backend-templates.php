<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/views-backend-templates.php
* File Version            : 1.0
* Created / Last Modified : 28 April 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end templates views class.
*/

    if (!class_exists('DOPBSPViewsTemplates')){
        class DOPBSPViewsTemplates extends DOPBSPViews{
            /*
             * Constructor
             */
            function DOPBSPViewsTemplates(){
            }
            
            /*
             * Returns templates template.
             * 
             * @return templates HTML page
             */
            function template(){
                global $DOPBSP;
                
                $this->getTranslation();
?>            
    <div class="wrap DOPBSP-admin">
        
<!--
    Header
-->
        <?php $this->displayHeader($DOPBSP->text('TITLE').' - '.$DOPBSP->text('TEMPLATES_TITLE').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$DOPBSP->text('SOON_TITLE')); ?>

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