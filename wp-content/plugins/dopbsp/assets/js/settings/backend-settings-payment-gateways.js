/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/settings/backend-settings-payment-gateways.js
* File Version            : 1.0
* Created / Last Modified : 17 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end payment gateways settings JavaScript class.
*/

var DOPBSPSettingsPaymentGateways = new function(){
    /*
     * Private variables
     */
    var $ = jQuery.noConflict();

    /*
     * Constructor
     */
    this.DOPBSPSettingsPaymentGateways = function(){
    };
    
    /*
     * Display payment gateways settings.
     * 
     * @param id (Number): calendar ID
     */
    this.display = function(id){
        DOPBSP.clearColumns(3);
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_LOADING'));
        DOPBSPSettings.toggle('payments');
        DOPBSPSettings.toggleCalendar('payments');

        $.post(ajaxurl, {action: 'dopbsp_settings_payment_gateways_display',
                         id: id}, function(data){
            DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_LOADING_SUCCESS'));
            $('#DOPBSP-column2 .column-content').html(data);
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    return this.DOPBSPSettingsPaymentGateways();
};