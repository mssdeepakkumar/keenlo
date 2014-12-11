/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/emails/backend-emails.js
* File Version            : 1.0
* Created / Last Modified : 31 May 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end emails JavaScript class.
*/

var DOPBSPEmails = new function(){
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();
    
    /*
     * Display emails list.
     */
    this.DOPBSPEmails = function(){
    };

    /*
     * Display emails list.
     */
    this.display = function(){
        DOPBSP.clearColumns(1);
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_LOADING'));
        
        $.post(ajaxurl, {action: 'dopbsp_emails_display'}, function(data){
            $('#DOPBSP-column1 .column-content').html(data);
            $('.DOPBSP-admin .main').css('display', 'block');
            DOPBSP.toggleMessages('success', DOPBSP.text('EMAILS_LOAD_SUCCESS'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    return this.DOPBSPEmails();
};