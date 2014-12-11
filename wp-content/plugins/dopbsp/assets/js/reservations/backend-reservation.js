/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/reservations/backend-reservations.js
* File Version            : 1.0
* Created / Last Modified : 18 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end reservation JavaScript class.
*/


var DOPBSPReservation = new function(){
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();
    
    /*
     * Constructor
     */ 
    this.DOPBSPReservation = function(){
    };
    
    /*
     * Initialize reservation.
     */
    this.init = function(){
        $('.DOPBSP-admin .main table.content-wrapper .reservations-list li .reservation-body').isotope({itemSelector: '.data-module'});
    };

    /*
     * Approve reservation.
     * 
     * @param id (Number): reservation ID
     */
    this.approve = function(id){
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_SAVING'));

        $.post(ajaxurl, {action:'dopbsp_reservation_approve',
                         reservation_id: id}, function(data){
            data = $.trim(data);
                    
            if (data === 'unavailable'){  
                DOPBSP.toggleMessages('error', DOPBSP.text('RESERVATIONS_APPROVE_UNAVAILABLE'));
            }
            else if (data === 'unavailable-coupon'){  
                DOPBSP.toggleMessages('error', DOPBSP.text('RESERVATIONS_APPROVE_UNAVAILABLE_COUPON'));
            }
            else{
                $('#DOPBSP-reservation'+id+' .reservation-head .icon').removeClass('approved')
                                                                      .removeClass('canceled')
                                                                      .removeClass('expired')
                                                                      .removeClass('pending')
                                                                      .removeClass('rejected')
                                                                      .addClass('approved');
                $('#DOPBSP-reservation'+id+' .reservation-head .status-info').removeClass('approved')
                                                                             .removeClass('canceled')
                                                                             .removeClass('expired')
                                                                             .removeClass('pending')
                                                                             .removeClass('rejected')
                                                                             .addClass('approved')
                                                                             .html(DOPBSP.text('RESERVATIONS_RESERVATION_STATUS_APPROVED'));
                $('#DOPBSP-reservation'+id+' .reservation-head .button-approve').css('display', 'none');
                $('#DOPBSP-reservation'+id+' .reservation-head .button-cancel').css('display', 'block');
                $('#DOPBSP-reservation'+id+' .reservation-head .button-delete').css('display', 'none');
                $('#DOPBSP-reservation'+id+' .reservation-head .button-reject').css('display', 'none');

                DOPBSP.toggleMessages('success', DOPBSP.text('RESERVATIONS_RESERVATION_APPROVE_SUCCESS'));
            }
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });             
    };

    /*
     * Cancel reservation.
     * 
     * @param id (Number): reservation ID
     */
    this.cancel = function(id){
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_SAVING'));

        $.post(ajaxurl, {action:'dopbsp_reservation_cancel',
                         reservation_id: id}, function(data){
            $('#DOPBSP-reservation'+id+' .reservation-head .icon').removeClass('approved')
                                                                  .removeClass('canceled')
                                                                  .removeClass('expired')
                                                                  .removeClass('pending')
                                                                  .removeClass('rejected')
                                                                  .addClass('canceled');
            $('#DOPBSP-reservation'+id+' .reservation-head .status-info').removeClass('approved')
                                                                         .removeClass('canceled')
                                                                         .removeClass('expired')
                                                                         .removeClass('pending')
                                                                         .removeClass('rejected')
                                                                         .addClass('canceled')
                                                                         .html(DOPBSP.text('RESERVATIONS_RESERVATION_STATUS_CANCELED'));
            $('#DOPBSP-reservation'+id+' .reservation-head .button-approve').css('display', 'block');
            $('#DOPBSP-reservation'+id+' .reservation-head .button-cancel').css('display', 'none');
            $('#DOPBSP-reservation'+id+' .reservation-head .button-delete').css('display', 'block');
            $('#DOPBSP-reservation'+id+' .reservation-head .button-reject').css('display', 'none');
            
            DOPBSP.toggleMessages('success', DOPBSP.text('RESERVATIONS_RESERVATION_CANCEL_SUCCESS'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });             
    };

    /*
     * Delete reservation.
     * 
     * @param id (Number): reservation ID
     */
    this.delete = function(id){
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_SAVING'));

        $.post(ajaxurl, {action:'dopbsp_reservation_delete',
                         reservation_id: id}, function(data){
            $('#DOPBSP-reservation'+id).fadeOut(300, function(){
                $(this).remove();
                DOPBSP.toggleMessages('success', DOPBSP.text('RESERVATIONS_RESERVATION_DELETE_SUCCESS'));
            });
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });             
    };

    /*
     * Reject reservation.
     * 
     * @param id (Number): reservation ID
     */
    this.reject = function(id){
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_SAVING'));

        $.post(ajaxurl, {action:'dopbsp_reservation_reject',
                         reservation_id: id}, function(data){
            $('#DOPBSP-reservation'+id+' .reservation-head .icon').removeClass('approved')
                                                        .removeClass('canceled')
                                                        .removeClass('expired')
                                                        .removeClass('pending')
                                                        .removeClass('rejected')
                                                        .addClass('rejected');
            $('#DOPBSP-reservation'+id+' .reservation-head .status-info').removeClass('approved')
                                                               .removeClass('canceled')
                                                               .removeClass('expired')
                                                               .removeClass('pending')
                                                               .removeClass('rejected')
                                                               .addClass('rejected')
                                                               .html(DOPBSP.text('RESERVATIONS_RESERVATION_STATUS_REJECTED'));
            $('#DOPBSP-reservation'+id+' .reservation-head .button-approve').css('display', 'block');
            $('#DOPBSP-reservation'+id+' .reservation-head .button-cancel').css('display', 'none');
            $('#DOPBSP-reservation'+id+' .reservation-head .button-delete').css('display', 'block');
            $('#DOPBSP-reservation'+id+' .reservation-head .button-reject').css('display', 'none');
            
            DOPBSP.toggleMessages('success', DOPBSP.text('RESERVATIONS_RESERVATION_REJECT_SUCCESS'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });             
    };
    
    return this.DOPBSPReservation();
};