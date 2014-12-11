/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/coupons/backend-coupons.js
* File Version            : 1.0
* Created / Last Modified : 13 May 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end coupons JavaScript class.
*/

var DOPBSPCoupons = new function(){
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();
    
    /*
     * Display coupons list.
     */
    this.DOPBSPCoupons = function(){
    };

    /*
     * Display coupons list.
     */
    this.display = function(){
        DOPBSP.clearColumns(1);
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_LOADING'));
        
        $.post(ajaxurl, {action: 'dopbsp_coupons_display'}, function(data){
            $('#DOPBSP-column1 .column-content').html(data);
            $('.DOPBSP-admin .main').css('display', 'block');
            DOPBSP.toggleMessages('success', DOPBSP.text('COUPONS_LOAD_SUCCESS'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    return this.DOPBSPCoupons();
};