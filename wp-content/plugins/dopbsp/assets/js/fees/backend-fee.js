/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/fees/backend-fee.js
* File Version            : 1.0
* Created / Last Modified : 20 May 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end fee JavaScript class.
*/


var DOPBSPFee = new function(){
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
    this.DOPBSPFee = function(){
    };
    
    /*
     * Display fee.
     * 
     * @param id (Number): fee ID
     * @param language (String): fee current editing language
     * @param clearFee (Boolean): clear fee extra data diplay
     */
    this.display = function(id,
                            language,
                            clearFee){
        var HTML = new Array();
        
        language = language === undefined ? ($('#DOPBSP-fee-language').val() === undefined ? '':$('#DOPBSP-fee-language').val()):language;
        clearFee = clearFee === undefined ? true:false;
        language = clearFee ? '':language;
        
        if (clearFee){
            DOPBSP.clearColumns(2);
        }
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_LOADING'));
        
        $('#DOPBSP-column1 .column-content li').removeClass('selected');
        $('#DOPBSP-fee-ID-'+id).addClass('selected');
        $('#DOPBSP-fee-ID').val(id);
        
        $.post(ajaxurl, {action: 'dopbsp_fee_display', 
                         id: id,
                         language: language}, function(data){
            HTML.push('<a href="javascript:DOPBSP.confirmation(\'FEES_DELETE_FEE_CONFIRMATION\', \'DOPBSPFee.delete('+id+')\')" class="button delete"><span class="info">'+DOPBSP.text('FEES_DELETE_FEE_SUBMIT')+'</span></a>');
            HTML.push('<a href="'+DOPBSP_CONFIG_HELP_DOCUMENTATION_URL+'" target="_blank" class="button help">');
            HTML.push(' <span class="info help">');
            HTML.push(DOPBSP.text('FEES_FEE_HELP')+'<br /><br />');
            HTML.push(DOPBSP.text('HELP_VIEW_DOCUMENTATION'));
            HTML.push(' </span>');
            HTML.push('</a>');
            
            $('#DOPBSP-column2 .column-header').html(HTML.join(''));
            $('#DOPBSP-column2 .column-content').html(data);
            
            DOPBSPFee.init();
            DOPBSP.toggleMessages('success', DOPBSP.text('FEES_FEE_LOADED'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    /*
     * Initialize validations.
     */
    this.init = function(){
        /*
         * Price validation.
         */
        $('.DOPBSP-input-fee-price').unbind('input propertychange');
        $('.DOPBSP-input-fee-price').bind('input propertychange', function(){
            DOPPrototypes.cleanInput($(this), '0123456789.', '0', '0');
        });
    };

    /*
     * Add fee.
     */
    this.add = function(){
        DOPBSP.clearColumns(2);
        DOPBSP.toggleMessages('active', DOPBSP.text('FEES_ADD_FEE_ADDING'));

        $.post(ajaxurl, {action: 'dopbsp_fee_add'}, function(data){
            $('#DOPBSP-column1 .column-content').html(data);
            DOPBSP.toggleMessages('sucess', DOPBSP.text('FEES_ADD_FEE_SUCCESS'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Edit fee.
     * 
     * @param id (Number): fee ID
     * @param type (String): field type
     * @param field (String): group field
     * @param value (String): group value
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
            case 'name':
                $('#DOPBSP-fee-ID-'+id+' .name').html(value);
                break;
        }
        
        switch (type){
            case 'switch':
                value = $('#DOPBSP-fee-'+field+'-'+id).is(':checked') ? 'true':'false';
                break;
        }
        
        if (onBlur 
                || type === 'select' 
                || type === 'switch'){
            if (!onBlur){
                DOPBSP.toggleMessages('active-info', DOPBSP.text('MESSAGES_SAVING'));
            }
            
            $.post(ajaxurl, {action: 'dopbsp_fee_edit',
                             id: id,
                             field: field,
                             value: value,
                             language: $('#DOPBSP-fee-language').val()}, function(data){
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

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_fee_edit',
                                                              id: id,
                                                              field: field,
                                                              value: value,
                                                              language: $('#DOPBSP-fee-language').val()}, function(data){
                    DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };


    /*
     * Delete fee.
     * 
     * @param id (Number): fee ID
     */
    this.delete = function(id){
        DOPBSP.toggleMessages('active', DOPBSP.text('FEES_DELETE_FEE_DELETING'));

        $.post(ajaxurl, {action: 'dopbsp_fee_delete', 
                         id: id}, function(data){
            DOPBSP.clearColumns(2);

            $('#DOPBSP-fee-ID-'+id).stop(true, true)
                                    .animate({'opacity':0}, 
                                    600, function(){
                $(this).remove();

                if (data === '0'){
                    $('#DOPBSP-column1 .column-content').html('<ul><li class="no-data">'+DOPBSP.text('FEES_NO_FEES')+'</li></ul>');
                }
                DOPBSP.toggleMessages('hide', DOPBSP.text('FEES_DELETE_FEE_SUCCESS'));
            });
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    return this.DOPBSPFee();
};