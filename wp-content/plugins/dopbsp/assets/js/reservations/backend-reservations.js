/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/reservations/backend-reservations.js
* File Version            : 1.0
* Created / Last Modified : 15 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end reservations JavaScript class.
*/

var DOPBSPReservations = new function(){
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();
        
    /*
     * Constructor
     */
    this.DOPBSPReservations = function(){
    };
    
    /*
     * Display reservations.
     */
    this.display = function(){
        $('.DOPBSP-admin .main').css('display', 'block');  
        
        if ($('#DOPBSP-calendar-ID').val().indexOf(',') !== -1){
            $('.DOPBSP-admin .main .button.reservations-add-button').addClass('dopbsp-disabled');
            $('.DOPBSP-admin .main .button.reservations-calendar-button').addClass('dopbsp-disabled');
        }
        else{
            $('.DOPBSP-admin .main .button.reservations-add-button').removeClass('dopbsp-disabled');
            $('.DOPBSP-admin .main .button.reservations-calendar-button').removeClass('dopbsp-disabled');
        }
        
        if ($('#DOPBSP-calendar-ID').val().indexOf(',') !== -1){
            DOPBSPReservationsList.display();
        }
        else if ($('.DOPBSP-admin .main .button.reservations-add-button').hasClass('selected')){
            DOPBSPReservationsAdd.display();
        }
        else if ($('.DOPBSP-admin .main .button.reservations-calendar-button').hasClass('selected')){
            DOPBSPReservationsCalendar.display();
        }
        else if ($('.DOPBSP-admin .main .button.reservations-list-button').hasClass('selected')){
            DOPBSPReservationsList.display();
        }
        else{
            if (DOPPrototypes.getCookie('DOPBSP_reservations_view') === 'calendar'){
                DOPBSPReservationsCalendar.display();
            }
            else{
                DOPBSPReservationsList.display();
            }
        }
    };
    
    return this.DOPBSPReservations();
};