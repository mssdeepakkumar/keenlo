/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/discounts/backend-discount-item.js
* File Version            : 1.0
* Created / Last Modified : 08 April 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end discount item JavaScript class.
*/

var DOPBSPDiscountItem = new function(){
    /*
     * Private variables.
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
    this.DOPBSPDiscountItem = function(){
    };
    
    /*
     * Initialize validations.
     */
    this.init = function(){
        /*
         * Time lapse validation.
         */
        $('.DOPBSP-input-discount-item-time-lapse').unbind('input propertychange');
        $('.DOPBSP-input-discount-item-time-lapse').bind('input propertychange', function(){
            DOPPrototypes.cleanInput($(this), '0123456789.', '', '');
        });
        
        /*
         * Price validation.
         */
        $('.DOPBSP-input-discount-item-price').unbind('input propertychange');
        $('.DOPBSP-input-discount-item-price').bind('input propertychange', function(){
            DOPPrototypes.cleanInput($(this), '0123456789.', '0', '0');
        });
    };
    
    /*
     * Add discount item.
     * 
     * @param discountId (Number): discount ID
     * @param language (String): discount current selected language
     */
    this.add = function(discountId,
                        language){
        DOPBSP.toggleMessages('active', DOPBSP.text('DISCOUNTS_DISCOUNT_ADD_ITEM_ADDING'));
        
        $.post(ajaxurl, {action:'dopbsp_discount_item_add',
                         discount_id: discountId,
                         position: $('#DOPBSP-discount-items li.item-wrapper').size()+1,
                         language: language}, function(data){
            $('#DOPBSP-discount-items').append(data);
            
            DOPPrototypes.scrollToY($('#DOPBSP-discount-items li.item-wrapper:last-child').offset().top-100);
            DOPBSP.toggleMessages('success', DOPBSP.text('DISCOUNTS_DISCOUNT_ADD_ITEM_SUCCESS'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Edit discount item.
     * 
     * @param id (Number): item ID
     * @param type (String): field type
     * @param field (String): item field
     * @param value (String): item field value
     * @param onBlur (Boolean): true if function has been called on blur event
     */
    this.edit = function(id, 
                         type,
                         field,
                         value, 
                         onBlur){
        onBlur = onBlur === undefined ? false:true;
        
        if (this.ajaxRequestInProgress !== undefined 
                && !onBlur){
            this.ajaxRequestInProgress.abort();
        }

        if (this.ajaxRequestTimeout !== undefined){
            clearTimeout(this.ajaxRequestTimeout);
        }
        
        switch (field){
            case 'label':
                $('#DOPBSP-discount-item-label-preview-'+id).html(value);
                break;
            case 'multiple_select':
                value = $('#DOPBSP-discount-item-multiple_select-'+id).is(':checked') ? 'true':'false';
                break;
            case 'required':
                value = $('#DOPBSP-discount-item-required-'+id).is(':checked') ? 'true':'false';
                $('#DOPBSP-discount-item-label-preview-'+id+' .required').html(value === 'true' ? '*':'');
                break;
        }
        
        if (onBlur 
                || type === 'select' 
                || type === 'switch'){
            if (!onBlur){
                DOPBSP.toggleMessages('active-info', DOPBSP.text('MESSAGES_SAVING'));
            }
            
            $.post(ajaxurl, {action: 'dopbsp_discount_item_edit',
                             id: id,
                             field: field,
                             value: value,
                             language: $('#DOPBSP-discount-language').val()}, function(data){
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

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_discount_item_edit',
                                                              id: id,
                                                              field: field,
                                                              value: value,
                                                              language: $('#DOPBSP-discount-language').val()}, function(data){
                    DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };
    
    /*
     * Delete discount item.
     * 
     * @param id (Number): discount item ID
     */
    this.delete = function(id){
        DOPBSP.toggleMessages('active', DOPBSP.text('DISCOUNTS_DISCOUNT_DELETE_ITEM_DELETING'));

        $.post(ajaxurl, {action:'dopbsp_discount_item_delete', 
                         id: id}, function(data){
            $('#DOPBSP-discount-item-'+id).stop(true, true)
                                       .animate({'opacity':0}, 
                                       600, function(){
                $(this).remove();
            });
            DOPBSP.toggleMessages('success', DOPBSP.text('DISCOUNTS_DISCOUNT_DELETE_ITEM_SUCCESS'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Toggle discount item.
     * 
     * @param id (Number): discount item ID
     */
    this.toggle = function(id){
        if ($('#DOPBSP-discount-item-'+id).hasClass('displayed')){
            $('#DOPBSP-discount-item-'+id).removeClass('displayed');
            $('#DOPBSP-discount-item-'+id+' .preview-wrapper .buttons-wrapper .toggle .info').html(DOPBSP.text('DISCOUNTS_DISCOUNT_ITEM_SHOW_SETTINGS'));
        }
        else{
            $('#DOPBSP-discount-item-'+id).addClass('displayed');
            $('#DOPBSP-discount-item-'+id+' .preview-wrapper .buttons-wrapper .toggle .info').html(DOPBSP.text('DISCOUNTS_DISCOUNT_ITEM_HIDE_SETTINGS'));
        }
    };
    
    return this.DOPBSPDiscountItem();
};