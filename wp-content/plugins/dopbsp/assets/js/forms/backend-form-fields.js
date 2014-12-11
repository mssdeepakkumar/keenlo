/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/forms/backend-form-fields.js
* File Version            : 1.0
* Created / Last Modified : 29 March 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end form fields JavaScript class.
*/


var DOPBSPFormFields = new function(){
    /*
     * Private variables
     */
    var $ = jQuery.noConflict();
    
    /*
     * Constructor
     */
    this.DOPBSPFormFields = function(){
    };
    
    /*
     * Initialize form fields sort.
     */
    this.init = function(){
        $('#DOPBSP-form-fields').sortable({handle: '.handle',
                                           opacity: 0.75,
                                           placeholder: 'placeholder',
                                           update: function(e, ui){
                                                var ids = new Array();
                                                
                                                DOPBSP.toggleMessages('active-info', DOPBSP.text('MESSAGES_SAVING'));
                                                
                                                $('#'+e.target.id+' li.field-wrapper').each(function(){
                                                    if (!$(this).hasClass('placeholder')){
                                                        ids.push($(this).attr('id').split('DOPBSP-form-field-')[1]);
                                                    }
                                                });
                                               
                                                $.post(ajaxurl, {action: 'dopbsp_form_fields_sort',
                                                                 ids: ids.join(',')}, function(data){
                                                    DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_SAVING_SUCCESS'));
                                                }).fail(function(data){
                                                    DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
                                                });
                                           }});
    };
    
    return this.DOPBSPFormFields();
};