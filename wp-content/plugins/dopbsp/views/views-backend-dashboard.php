<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/views-backend-dashboard.php
* File Version            : 1.0
* Created / Last Modified : 28 May 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end dashboard views class.
*/

    if (!class_exists('DOPBSPViewsDashboard')){
        class DOPBSPViewsDashboard extends DOPBSPViews{
            /*
             * Constructor
             */
            function DOPBSPViewsDashboard(){
            }
            
            /*
             * Returns dashboard template.
             * 
             * @return calendars HTML page
             */
            function template(){
                global $DOPBSP;
                
                $this->getTranslation();
?>            
    <div class="wrap DOPBSP-admin">
        
<!-- 
    Header
-->
        <?php $this->displayHeader($DOPBSP->text('TITLE').' - '.$DOPBSP->text('DASHBOARD_TITLE').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$DOPBSP->text('SOON_TITLE')); ?>

<!--
    Content
-->
        <div class="main">
            <script type="text/javascript">
                window.location.href = '<?php echo admin_url('admin.php?page=dopbsp-calendars'); ?>';
            </script>
        </div>
    </div>       
<?php
            }
        }
    }