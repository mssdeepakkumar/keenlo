<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/fees/views-backend-fees.php
* File Version            : 1.0
* Created / Last Modified : 17 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end fees views class.
*/

    if (!class_exists('DOPBSPViewsFees')){
        class DOPBSPViewsFees extends DOPBSPViews{
            /*
             * Constructor
             */
            function DOPBSPViewsFees(){
            }
            
            /*
             * Returns fees template.
             * 
             * @param args (array): function arguments
             * 
             * @return fees HTML page
             */
            function template($args = array()){
                global $DOPBSP;
                
                $this->getTranslation();
?>            
    <div class="wrap DOPBSP-admin">
        
<!--
    Header
-->
        <?php $this->displayHeader($DOPBSP->text('TITLE').' - '.$DOPBSP->text('FEES_TITLE')); ?>
        <input type="hidden" name="DOPBSP-fee-ID" id="DOPBSP-fee-ID" value="" />
        
<!--
    Content
-->
        <div class="main">
            <table class="content-wrapper">
                <colgroup>
                    <col id="DOPBSP-col-column1" class="column1" />
                    <col id="DOPBSP-col-column-separator1" class="separator" />
                    <col id="DOPBSP-col-column2" class="column2" />
                </colgroup>
                <tbody>
                    <tr>
                        <td class="column" id="DOPBSP-column1">
                            <div class="column-header">
<?php 
                if (isset($_GET['page']) 
                        && $DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-booking-system')){ 
?>                  
                                <a href="javascript:DOPBSPFee.add()" class="button add"><span class="info"><?php echo $DOPBSP->text('FEES_ADD_FEE_SUBMIT'); ?></span></a>
                                <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="button help"><span class="info help"><?php echo $DOPBSP->text('FEES_HELP').'<br /><br />'.$DOPBSP->text('FEES_ADD_FEE_HELP').'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
<?php
                }
                else{
?>           
                             <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="button help"><span class="info help"><?php echo $DOPBSP->text('FEES_HELP').'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
<?php
                }
?>                           
                                <br class="DOPBSP-clear" />
                            </div>
                            <div class="column-content">&nbsp;</div>
                        </td>
                        <td id="DOPBSP-column-separator1" class="separator"></td>
                        <td id="DOPBSP-column2" class="column">
                            <div class="column-header">&nbsp;</div>
                            <div class="column-content">&nbsp;</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>       
<?php
            }
        }
    }