/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/backend.js
* File Version            : 1.0
* Created / Last Modified : 31 May 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end JavaScript class.
*/

var DOPBSP = new function(){
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();

    /*
     * Public variables.
     */
    this.messagesTimeout = 0;

    /*
     * Constructor
     */
    this.DOPBSP = function(){
        $(document).ready(function(){
            if (typeof DOPBSP_curr_page !== 'undefined'){
                switch (DOPBSP_curr_page){
                    case 'Calendars':
                        DOPBSPCalendars.display();
                        break;
                    case 'Coupons':
                        DOPBSPCoupons.display();
                        break;
                    case 'Dashboard':
//                        DOPBSPDashboard.display();
                        break;
                    case 'Discounts':
                        DOPBSPDiscounts.display();
                        break;
                    case 'Emails':
                        DOPBSPEmails.display();
                        break;
                    case 'Events':
//                        DOPBSPEvents.display();
                        break;
                    case 'Extras':
                        DOPBSPExtras.display();
                        break;
                    case 'Fees':
                        DOPBSPFees.display();
                        break;
                    case 'Forms':
                        DOPBSPForms.display();
                        break;
                    case 'Locations':
//                        DOPBSPLocations.display();
                        break;
                    case 'Reservations':
                        DOPBSPReservations.display();
                        break;
                    case 'Rules':
                        DOPBSPRules.display();
                        break;
                    case 'Settings':
                        break;
                    case 'Templates':
//                        DOPBSPTemplates.display();
                        break;
                    case 'Translation':
                        if (DOPPrototypes.getCookie('DOPBSP-translation-redirect') === 'languages'){
                            DOPPrototypes.deleteCookie('DOPBSP-translation-redirect', '/');
                            DOPBSPTranslation.displayLanguages();
                        }
                        else{
                            DOPBSPTranslation.display();
                        }
                        break;
                    case 'Settings Post':
                        dopbspShowUsersCustomPostsPermissions.display();
                        break;
                }
            }
        });
        
        $(document).scroll(function(){
            if ($(document).scrollTop() > 0){
                $('#DOPBSP-go-top').css('display', 'block');
            }
            else{
                $('#DOPBSP-go-top').css('display', 'none');
            }
        });
    };
    
    /*
     * Clear columns content.
     * 
     * @param no (Number): column number from which the clear will start
     */
    this.clearColumns = function(no){
        if (no <= 1){
            $('#DOPBSP-column1 .column-content').html('');
        }
        
        if (no <= 2){
            $('#DOPBSP-col-column2').removeClass('calendar');
            $('#DOPBSP-column2 .column-header').html('');
            $('#DOPBSP-column2 .column-content').html('');
        }
        
        if (no <= 3){
            $('#DOPBSP-column3 .column-header').html('');
            $('#DOPBSP-column3 .column-content').html('');       
        }
    };
    
    /*
     * Confirm an action.
     * 
     * @param message (String): confirmation message
     * @param yesAction (String): function to be executed if you click "Yes"
     * @param noAction (String): function to be executed if you click "No"
     */
    this.confirmation = function(message,
                                 yesAction,
                                 noAction){
        var text = DOPBSP.text(message);
        
        yesAction = yesAction === undefined ? '':yesAction;
        noAction = noAction === undefined ? '':noAction;
        
        $('#DOPBSP-messages-box').removeClass('active')
                                 .removeClass('active-info')
                                 .removeClass('error')
                                 .removeClass('success');
        $('#DOPBSP-messages-box .message').html('');
        
        $('#DOPBSP-messages-background').addClass('active');
        $('#DOPBSP-confirmation-box').addClass('active');
        $('#DOPBSP-confirmation-box .message').html(text);
        
        $('#DOPBSP-confirmation-box .button-yes').unbind('click');
        $('#DOPBSP-confirmation-box .button-yes').bind('click', function(){
            $('#DOPBSP-messages-background').removeClass('active');
            $('#DOPBSP-confirmation-box').removeClass('active');
            $('#DOPBSP-confirmation-box .message').html('');
            
            if (yesAction !== ''){
                eval(yesAction);
            }
        });
        
        $('#DOPBSP-confirmation-box .button-no').unbind('click');
        $('#DOPBSP-confirmation-box .button-no').bind('click', function(){
            $('#DOPBSP-messages-background').removeClass('active');
            $('#DOPBSP-confirmation-box').removeClass('active');
            $('#DOPBSP-confirmation-box .message').html('');
            
            if (noAction !== ''){
                eval(noAction);
            }
        });
    };
    
    /*
     * Get translation textt.
     * 
     * @param key (String): translation key
     * 
     * @return translation text
     */
    this.text = function(key){
        return DOPBSP_translation_text[key];
    };
    
    /*
     * Toggle inputs groups.
     * 
     * @param id (String): inputs groups ID
     */
    this.toggleInputs = function(id){
        if ($('#DOPBSP-inputs-button-'+id).parent().hasClass('display')){
            $('#DOPBSP-inputs-button-'+id).parent()
                                          .removeClass('display')
                                          .addClass('hide');
            $('#DOPBSP-inputs-'+id).stop(true, false)
                                   .fadeIn(300, function(){
            });
        }
        else{
            $('#DOPBSP-inputs-'+id).stop(true, false)
                                   .fadeOut(300, function(){
                $('#DOPBSP-inputs-button-'+id).parent()
                                              .removeClass('hide')
                                              .addClass('display');
            });
        }
    };
    
    /*
     * Toggle messages.
     * 
     * @param action (String): box action
     *                         "active" informs you that an action is taking place and blocks you from taking other actions
     *                         "active-info" informs you that an action is taking place, but doesn't block you from taking other actions
     *                         "error" error message
     *                         "success" success message
     * @param message (String): the message
     */
    this.toggleMessages = function(action, 
                                   message){
        action === undefined ? 'none':action;
        message === undefined ? '':action;
        
        clearTimeout(this.messagesTimeout);
        $('#DOPBSP-messages-background').removeClass('active');
        $('#DOPBSP-messages-box').removeClass('active')
                                 .removeClass('active-info')
                                 .removeClass('error')
                                 .removeClass('success')
                                 .addClass(action);
        $('#DOPBSP-messages-box .message').html(message);
            
        switch (action){
            case 'active':
                $('#DOPBSP-messages-background').addClass('active');
                break;
            case 'success':
                this.messagesTimeout = setTimeout(function(){
                     $('#DOPBSP-messages-box').removeClass('success');
                     $('#DOPBSP-messages-box .message').html('');
                }, 2000);
                break;
        }
    };
    
    return this.DOPBSP();
};