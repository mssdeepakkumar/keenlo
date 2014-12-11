/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/forms/backend-forms.js
* File Version            : 1.0
* Created / Last Modified : 24 March 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end forms JavaScript class.
*/

var DOPBSPForms = new function(){
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();
    
    /*
     * Constructor
     */
    this.DOPBSPForms = function(){
    };

    /*
     * Display forms list.
     */
    this.display = function(){
        DOPBSP.clearColumns(1);
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_LOADING'));

        $.post(ajaxurl, {action: 'dopbsp_forms_display'}, function(data){
            $('#DOPBSP-column1 .column-content').html(data);
            $('.DOPBSP-admin .main').css('display', 'block');
            DOPBSP.toggleMessages('success', DOPBSP.text('FORMS_LOAD_SUCCESS'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    return this.DOPBSPForms();
};