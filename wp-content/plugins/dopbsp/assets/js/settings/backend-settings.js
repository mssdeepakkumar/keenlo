/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/settings/backend-settings.js
* File Version            : 1.0
* Created / Last Modified : 17 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end settings JavaScript class.
*/

var DOPBSPSettings = new function(){
    /*
     * Private variables
     */
    var $ = jQuery.noConflict();

    /*
     * Public variables
     */
    this.ajaxRequestInProgress;
    this.ajaxRequestTimeout;

    /*
     * Constructor
     */
    this.DOPBSPSettings = function(){
    };
    
    /*
     * Set settings.
     * 
     * @param id (Number): settings ID
     * @param settingsType (String): settings type
     * @param type (String): field type
     * @param field (String): field name
     * @param value (combined): field value
     * @param onBlur (Boolean): true if function has been called on blur event
     */
    this.set = function(id, 
                        settingsType,
                        type, 
                        field, 
                        value, 
                        onBlur){
        var i,
        daysAvailable = new Array(),
        hoursDefinitions = new Array(),
        fees = new Array();

        onBlur = onBlur === undefined ? false:true;
        
        if (this.ajaxRequestInProgress !== undefined 
                && !onBlur){
            this.ajaxRequestInProgress.abort();
        }

        if (this.ajaxRequestTimeout !== undefined){
            clearTimeout(this.ajaxRequestTimeout);
        }
        
        switch (type){
            case 'days-available':
                for (i=0; i<=6; i++){
                    daysAvailable.push($('#DOPBSP-settings-days-available-'+i).is(':checked') ? 'true':'false');
                }
                value = daysAvailable.join(',');
                break;
            case 'fees':
                $('#DOPBSP-settings-fees input[type=checkbox]').each(function(){
                    if ($(this).is(':checked')){
                        fee_id = $(this).attr('id').split('DOPBSP-settings-fee-')[1];
                        fees.push(fee_id);
                    }
                });
                value = fees.join(',');
                break;
            case 'hours-definitions':
                if (value !== ''){
                    value = value.split('\n');

                    for (i=0; i<value.length; i++){
                        value[i] = value[i].replace(/\s/g, "");

                        if (value[i] !== ''){
                            hoursDefinitions.push({'value': value[i]});
                        }
                    }
                }
                else{
                    hoursDefinitions.push({'value': '00:00'});
                }
                value = hoursDefinitions;
                break;
            case 'select':
                value = $('#DOPBSP-settings-'+field).val();
                break;    
            case 'switch':
                value = $('#DOPBSP-settings-'+field).is(':checked') ? 'true':'false';
                break;
        }
        
        if (onBlur 
                || type === 'days-available' 
                || type === 'fees' 
                || type === 'select' 
                || type === 'sidebar-style' 
                || type === 'switch'){
            if (!onBlur){
                DOPBSP.toggleMessages('active-info', DOPBSP.text('MESSAGES_SAVING'));
            }
            
            $.post(ajaxurl, {action: 'dopbsp_settings_set',
                             id: id,
                             settings_type: settingsType,
                             field: field,
                             value: value}, function(data){
                if (!onBlur){
                    DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_SAVING_SUCCESS'));
                }
            }).fail(function(data){
                DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
            });
        }
        else{
            DOPBSP.toggleMessages('active-info', DOPBSP.text('MESSAGES_SAVING'));

            this.ajaxRequestTimeout = setTimeout(function(){
                clearTimeout(this.ajaxRequestTimeout);

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_settings_set',
                                                              id: id,
                                                              settings_type: settingsType,
                                                              field: field,
                                                              value: value}, function(data){
                    DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };
    
    /*
     * Toggle buttons on settings page.
     * 
     * @param button (String): button class
     */
    this.toggle = function(button){
        $('#DOPBSP-column1 .settings-item.settings').removeClass('selected');
        $('#DOPBSP-column1 .settings-item.calendars').removeClass('selected');
        $('#DOPBSP-column1 .settings-item.notifications').removeClass('selected');
        $('#DOPBSP-column1 .settings-item.payments').removeClass('selected');
        $('#DOPBSP-column1 .settings-item.users').removeClass('selected');
        
        $('#DOPBSP-column1 .settings-item.'+button).addClass('selected');
    };
    
    /*
     * Toggle buttons on calendar page.
     * 
     * @param button (String): button class
     */
    this.toggleCalendar = function(button){
        $('#DOPBSP-column2 .button.calendar').removeClass('selected');
        $('#DOPBSP-column2 .button.settings').removeClass('selected');
        $('#DOPBSP-column2 .button.notifications').removeClass('selected');
        $('#DOPBSP-column2 .button.payments').removeClass('selected');
        $('#DOPBSP-column2 .button.users').removeClass('selected');
        
        $('#DOPBSP-column2 .button.'+button).addClass('selected');
    };
    
    return this.DOPBSPSettings();
};