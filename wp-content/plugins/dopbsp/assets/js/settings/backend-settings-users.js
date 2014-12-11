/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/settings/backend-settings-users.js
* File Version            : 1.0
* Created / Last Modified : 17 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end users settings JavaScript class.
*/

var DOPBSPSettingsUsers = new function(){
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
    this.DOPBSPSettingsUsers = function(){
    };
    
    /*
     * Display users settings.
     */
    this.display = function(){
        DOPBSP.clearColumns(2);
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_LOADING'));
        DOPBSPSettings.toggle('users');
        DOPBSPSettings.toggleCalendar('users');

        $.post(ajaxurl, {action: 'dopbsp_settings_users_display'}, function(data){
            DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_LOADING_SUCCESS'));
            $('#DOPBSP-column2 .column-content').html(data);
            DOPBSPSettingsUsers.get(0);
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Get users list by search parameters.
     */
    this.get = function(){
        DOPBSP.toggleMessages('active-info', DOPBSP.text('MESSAGES_LOADING'));

        if (this.ajaxRequestInProgress !== undefined){
            this.ajaxRequestInProgress.abort();
        }
        
        this.ajaxRequestTimeout = setTimeout(function(){
            clearTimeout(this.ajaxRequestTimeout);

            this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_settings_users_get',
                                                          number: '',
                                                          offset : '',
                                                          order: $('#DOPBSP-settings-users-permissions-filters-order').val(),
                                                          orderby: $('#DOPBSP-settings-users-permissions-filters-order-by').val(),
                                                          role: $('#DOPBSP-settings-users-permissions-filters-role').val(),
                                                          search: $('#DOPBSP-settings-users-permissions-filters-search').val()}, function(data){
                DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_LOADING_SUCCESS'));
                $('#DOPBSP-users-list').html(data);
            }).fail(function(data){
                DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
            });
        }, 600);
    };
    
    /*
     * Set users permissions.
     * 
     * @param id (Number): user ID (if 0 general permissions are set)
     * @param slug (String): permission slug
     */
    this.set = function(id,
                        slug){
        DOPBSP.toggleMessages('active-info', DOPBSP.text('MESSAGES_SAVING'));
        
        $.post(ajaxurl, {action: 'dopbsp_settings_users_set',
                         id: id,
                         slug: slug,
                         value: $('#DOPBSP-settings-users-permissions-'+slug+(id !== 0 ? '-'+id:'')).is(':checked') ? 1:0}, function(data){
            DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_SAVING_SUCCESS'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    return this.DOPBSPSettingsUsers();
};