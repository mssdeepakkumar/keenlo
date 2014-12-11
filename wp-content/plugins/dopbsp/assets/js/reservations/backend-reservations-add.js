/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/reservations/backend-reservations-add.js
* File Version            : 1.0
* Created / Last Modified : 15 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end reservations add JavaScript class.
*/

var DOPBSPReservationsAdd = new function(){
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();
        
    /*
     * Constructor
     */
    this.DOPBSPReservationsAdd = function(){
    };
    
    /*
     * Display reservations add.
     */
    this.display = function(){
        if ($('#DOPBSP-calendar-ID').val().indexOf(',') !== -1){
            return false;
        }
        
        /*
         * Clear previous content.
         */
        DOPBSP.clearColumns(2);
        $('#DOPBSP-col-column-separator2').removeAttr('style');
        $('#DOPBSP-col-column3').removeAttr('style');
        $('#DOPBSP-column-separator2').removeAttr('style');
        $('#DOPBSP-column3').removeAttr('style');
        
        /*
         * Set buttons.
         */
        $('.DOPBSP-admin .main .button.reservations-add-button').addClass('selected');
        $('.DOPBSP-admin .main .button.reservations-list-button').removeClass('selected');
        $('.DOPBSP-admin .main .button.reservations-calendar-button').removeClass('selected');
        
        /*
         * Set filters.
         */
        $('#DOPBSP-inputs-reservations-filters-calendars').addClass('last');
        $('#DOPBSP-inputs-button-reservations-filters-period').parent().css('display', 'none');
        $('#DOPBSP-inputs-reservations-filters-period').css('display', 'none');
        $('#DOPBSP-inputs-button-reservations-filters-status').parent().css('display', 'none');
        $('#DOPBSP-inputs-reservations-filters-status').css('display', 'none');
        $('#DOPBSP-inputs-button-reservations-filters-payment').parent().css('display', 'none');
        $('#DOPBSP-inputs-reservations-filters-payment').css('display', 'none');
        $('#DOPBSP-inputs-button-reservations-filters-search').parent().css('display', 'none');
        $('#DOPBSP-inputs-reservations-filters-search').css('display', 'none');
        
        DOPBSPReservationsAdd.init();
    };
    
    /*
     * Initialize reservations add calendar.
     */
    this.init = function(){
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_LOADING'));
        $('#DOPBSP-column2 .column-content').html('<div id="DOPBSP-reservations-add"></div>');
        
        $.post(ajaxurl, {action: 'dopbsp_reservations_add_get_json',
                         calendar_id: $('#DOPBSP-calendar-ID').val()}, function(data){
            data = $.trim(data);
            
            $('#DOPBSP-reservations-add').DOPBSPReservationsAdd(JSON.parse(data));
        });
    };
    
    return this.DOPBSPReservationsAdd();
};