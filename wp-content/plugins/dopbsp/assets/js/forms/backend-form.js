/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/forms/backend-form.js
* File Version            : 1.0
* Created / Last Modified : 08 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end form JavaScript class.
*/


var DOPBSPForm = new function(){
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
    this.DOPBSPForm = function(){
    };
    
    /*
     * Display form.
     * 
     * @param id (Number): form ID
     * @param language (String): form current editing language
     * @param clearForm (Boolean): clear current form data diplay
     */
    this.display = function(id,
                            language,
                            clearForm){
        var HTML = new Array();
        console.log(language);
        language = language === undefined ? ($('#DOPBSP-form-language').val() === undefined ? '':$('#DOPBSP-form-language').val()):language;
        clearForm = clearForm === undefined ? true:false;
        language = clearForm ? '':language;
        
        if (clearForm){
            DOPBSP.clearColumns(2);
        }
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_LOADING'));
        
        $('#DOPBSP-column1 .column-content li').removeClass('selected');
        $('#DOPBSP-form-ID-'+id).addClass('selected');
        $('#DOPBSP-form-ID').val(id);
        
        $.post(ajaxurl, {action: 'dopbsp_form_display', 
                         id: id,
                         language: language}, function(data){
            HTML.push('<a href="javascript:DOPBSP.confirmation(\'FORMS_DELETE_FORM_CONFIRMATION\', \'DOPBSPForm.delete('+id+')\')" class="button delete"><span class="info">'+DOPBSP.text('FORMS_DELETE_FORM_SUBMIT')+'</span></a>');
            HTML.push('<a href="'+DOPBSP_CONFIG_HELP_DOCUMENTATION_URL+'" target="_blank" class="button help">');
            HTML.push(' <span class="info help">');
            HTML.push(DOPBSP.text('FORMS_FORM_ADD_FIELD_HELP')+'<br /><br />');
            HTML.push(DOPBSP.text('FORMS_FORM_EDIT_FIELD_HELP')+'<br /><br />');
            HTML.push(DOPBSP.text('FORMS_FORM_DELETE_FIELD_HELP')+'<br /><br />');
            HTML.push(DOPBSP.text('FORMS_FORM_SORT_FIELD_HELP')+'<br /><br />');
            HTML.push(DOPBSP.text('HELP_VIEW_DOCUMENTATION'));
            HTML.push(' </span>');
            HTML.push('</a>');
            
            $('#DOPBSP-column2 .column-header').html(HTML.join(''));
            $('#DOPBSP-column2 .column-content').html(data);
            
            DOPBSPFormFields.init();
            DOPBSPFormFieldSelectOptions.init();
            DOPBSP.toggleMessages('success', DOPBSP.text('FORMS_FORM_LOADED'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Add form.
     */
    this.add = function(){
        DOPBSP.clearColumns(2);
        DOPBSP.toggleMessages('active', DOPBSP.text('FORMS_ADD_FORM_ADDING'));

        $.post(ajaxurl, {action: 'dopbsp_form_add'}, function(data){
            $('#DOPBSP-column1 .column-content').html(data);
            DOPBSP.toggleMessages('sucess', DOPBSP.text('FORMS_ADD_FORM_SUCCESS'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Edit form.
     * 
     * @param id (Number): form ID
     * @param type (String): field type
     * @param field (String): field name
     * @param value (String): field value
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
                $('#DOPBSP-form-ID-'+id+' .name').html(value);
                break;
        }
        
        if (onBlur 
                || type === 'select' 
                || type === 'switch'){
            if (!onBlur){
                DOPBSP.toggleMessages('active-info', DOPBSP.text('MESSAGES_SAVING'));
            }
            
            $.post(ajaxurl, {action: 'dopbsp_form_edit',
                             id: id,
                             field: field,
                             value: value}, function(data){
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

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_form_edit',
                                                              id: id,
                                                              field: field,
                                                              value: value}, function(data){
                    DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };


    /*
     * Delete form.
     * 
     * @param id (Number): form ID
     */
    this.delete = function(id){
        DOPBSP.toggleMessages('active', DOPBSP.text('FORMS_DELETE_FORM_DELETING'));

        $.post(ajaxurl, {action: 'dopbsp_form_delete', 
                         id: id}, function(data){
            DOPBSP.clearColumns(2);

            $('#DOPBSP-form-ID-'+id).stop(true, true)
                                    .animate({'opacity':0}, 
                                    600, function(){
                $(this).remove();

                if (data === '0'){
                    $('#DOPBSP-column1 .column-content').html('<ul><li class="no-data">'+DOPBSP.text('FORMS_NO_FORMS')+'</li></ul>');
                }
                DOPBSP.toggleMessages('hide', DOPBSP.text('FORMS_DELETE_FORM_SUCCESS'));
            });
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    return this.DOPBSPForm();
};