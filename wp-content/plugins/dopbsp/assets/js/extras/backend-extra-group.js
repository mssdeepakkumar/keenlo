/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/extras/backend-extra-group.js
* File Version            : 1.0
* Created / Last Modified : 08 April 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end extra group JavaScript class.
*/

var DOPBSPExtraGroup = new function(){
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
    this.DOPBSPExtraGroup = function(){
    };
    
    /*
     * Add extra group.
     * 
     * @param extraId (Number): extra ID
     * @param language (String): extra current selected language
     */
    this.add = function(extraId,
                        language){
        DOPBSP.toggleMessages('active', DOPBSP.text('EXTRAS_EXTRA_ADD_GROUP_ADDING'));
        
        $.post(ajaxurl, {action:'dopbsp_extra_group_add',
                         extra_id: extraId,
                         position: $('#DOPBSP-extra-groups li.group-wrapper').size()+1,
                         language: language}, function(data){
            $('#DOPBSP-extra-groups').append(data);
            
            DOPPrototypes.scrollToY($('#DOPBSP-extra-groups li.group-wrapper:last-child').offset().top-100);
            DOPBSP.toggleMessages('success', DOPBSP.text('EXTRAS_EXTRA_ADD_GROUP_SUCCESS'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Edit extra group.
     * 
     * @param id (Number): group ID
     * @param type (String): field type
     * @param field (String): group field
     * @param value (String): group field value
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
                $('#DOPBSP-extra-group-label-preview-'+id).html(value);
                break;
            case 'multiple_select':
                value = $('#DOPBSP-extra-group-multiple_select-'+id).is(':checked') ? 'true':'false';
                break;
            case 'required':
                value = $('#DOPBSP-extra-group-required-'+id).is(':checked') ? 'true':'false';
                $('#DOPBSP-extra-group-label-preview-'+id+' .required').html(value === 'true' ? '*':'');
                break;
        }
        
        if (onBlur 
                || type === 'select' 
                || type === 'switch'){
            if (!onBlur){
                DOPBSP.toggleMessages('active-info', DOPBSP.text('MESSAGES_SAVING'));
            }
            
            $.post(ajaxurl, {action: 'dopbsp_extra_group_edit',
                             id: id,
                             field: field,
                             value: value,
                             language: $('#DOPBSP-extra-language').val()}, function(data){
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

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_extra_group_edit',
                                                              id: id,
                                                              field: field,
                                                              value: value,
                                                              language: $('#DOPBSP-extra-language').val()}, function(data){
                    DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };
    
    /*
     * Delete extra group.
     * 
     * @param id (Number): extra group ID
     */
    this.delete = function(id){
        DOPBSP.toggleMessages('active', DOPBSP.text('EXTRAS_EXTRA_DELETE_GROUP_DELETING'));

        $.post(ajaxurl, {action:'dopbsp_extra_group_delete', 
                         id: id}, function(data){
            $('#DOPBSP-extra-group-'+id).stop(true, true)
                                       .animate({'opacity':0}, 
                                       600, function(){
                $(this).remove();
            });
            DOPBSP.toggleMessages('success', DOPBSP.text('EXTRAS_EXTRA_DELETE_GROUP_SUCCESS'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Toggle extra group.
     * 
     * @param id (Number): extra group ID
     */
    this.toggle = function(id){
        if ($('#DOPBSP-extra-group-'+id).hasClass('displayed')){
            $('#DOPBSP-extra-group-'+id).removeClass('displayed');
            $('#DOPBSP-extra-group-'+id+' .preview-wrapper .buttons-wrapper .toggle .info').html(DOPBSP.text('EXTRAS_EXTRA_GROUP_SHOW_SETTINGS'));
        }
        else{
            $('#DOPBSP-extra-group-'+id).addClass('displayed');
            $('#DOPBSP-extra-group-'+id+' .preview-wrapper .buttons-wrapper .toggle .info').html(DOPBSP.text('EXTRAS_EXTRA_GROUP_HIDE_SETTINGS'));
        }
    };
    
    return this.DOPBSPExtraGroup();
};