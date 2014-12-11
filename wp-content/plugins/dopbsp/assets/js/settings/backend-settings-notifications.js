/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/settings/backend-settings-notifications.js
* File Version            : 1.0
* Created / Last Modified : 17 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end notifications settings JavaScript class.
*/

var DOPBSPSettingsNotifications = new function(){
    /*
     * Private variables
     */
    var $ = jQuery.noConflict();

    /*
     * Constructor
     */
    this.DOPBSPSettingsNotifications = function(){
    };
    
    /*
     * Display notifications settings.
     * 
     * @param id (Number): calendar ID
     */
    this.display = function(id){
        DOPBSP.clearColumns(3);
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_LOADING'));
        DOPBSPSettings.toggle('notifications');
        DOPBSPSettings.toggleCalendar('notifications');

        $.post(ajaxurl, {action: 'dopbsp_settings_notifications_display',
                         id: id}, function(data){
            DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_LOADING_SUCCESS'));
            $('#DOPBSP-column2 .column-content').html(data);
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    return this.DOPBSPSettingsNotifications();
};