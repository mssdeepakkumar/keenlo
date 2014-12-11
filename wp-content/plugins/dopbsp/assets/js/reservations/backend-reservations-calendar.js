/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/reservations/backend-reservations-calendar.js
* File Version            : 1.0
* Created / Last Modified : 15 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end reservations calendar JavaScript class.
*/

var DOPBSPReservationsCalendar = new function(){
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();
        
    /*
     * Constructor
     */
    this.DOPBSPReservationsCalendar = function(){
    };
    
    /*
     * Display reservations calendar.
     */
    this.display = function(){
        DOPPrototypes.setCookie('DOPBSP_reservations_view', 'calendar', 60);
        
        /*
         * Clear previous content.
         */
        DOPBSP.clearColumns(2);
        $('#DOPBSP-col-column-separator2').css('display', 'none');
        $('#DOPBSP-col-column3').css('display', 'none');
        $('#DOPBSP-column-separator2').css('display', 'none');
        $('#DOPBSP-column3').css('display', 'none');
        
        /*
         * Set buttons.
         */
        $('.DOPBSP-admin .main .button.reservations-calendar-button').addClass('selected');
        $('.DOPBSP-admin .main .button.reservations-add-button').removeClass('selected');
        $('.DOPBSP-admin .main .button.reservations-list-button').removeClass('selected');
        
//        DOPBSPReservationsAdd.init();
    };
    
    return this.DOPBSPReservationsCalendar();
};