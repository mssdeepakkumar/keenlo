/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/rules/backend-rule.js
* File Version            : 1.0
* Created / Last Modified : 15 May 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end rule JavaScript class.
*/


var DOPBSPRule = new function(){
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
    this.DOPBSPRule = function(){
    };
    
    /*
     * Display rule.
     * 
     * @param id (Number): rule ID
     * @param language (String): rule current editing language
     * @param clearRule (Boolean): clear rule extra data diplay
     */
    this.display = function(id,
                            language,
                            clearRule){
        var HTML = new Array();
        
        language = language === undefined ? ($('#DOPBSP-rule-language').val() === undefined ? '':$('#DOPBSP-rule-language').val()):language;
        clearRule = clearRule === undefined ? true:false;
        language = clearRule ? '':language;
        
        if (clearRule){
            DOPBSP.clearColumns(2);
        }
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_LOADING'));
        
        $('#DOPBSP-column1 .column-content li').removeClass('selected');
        $('#DOPBSP-rule-ID-'+id).addClass('selected');
        $('#DOPBSP-rule-ID').val(id);
        
        $.post(ajaxurl, {action: 'dopbsp_rule_display', 
                         id: id,
                         language: language}, function(data){
            HTML.push('<a href="javascript:DOPBSP.confirmation(\'RULES_DELETE_RULE_CONFIRMATION\', \'DOPBSPRule.delete('+id+')\')" class="button delete"><span class="info">'+DOPBSP.text('RULES_DELETE_RULE_SUBMIT')+'</span></a>');
            HTML.push('<a href="'+DOPBSP_CONFIG_HELP_DOCUMENTATION_URL+'" target="_blank" class="button help">');
            HTML.push(' <span class="info help">');
            HTML.push(DOPBSP.text('RULES_RULE_HELP')+'<br /><br />');
            HTML.push(DOPBSP.text('HELP_VIEW_DOCUMENTATION'));
            HTML.push(' </span>');
            HTML.push('</a>');
            
            $('#DOPBSP-column2 .column-header').html(HTML.join(''));
            $('#DOPBSP-column2 .column-content').html(data);
            
            $('#DOPBSP-rule-start_date').datepicker();
            $('#DOPBSP-rule-end_date').datepicker();
            
            DOPBSPRule.init();
            DOPBSP.toggleMessages('success', DOPBSP.text('RULES_RULE_LOADED'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    /*
     * Initialize events and validations.
     */
    this.init = function(){
        /*
         * Number of rules.
         */
        $('#DOPBSP-rule-time_lapse_min').unbind('input propertychange');
        $('#DOPBSP-rule-time_lapse_min').bind('input propertychange', function(){
            DOPPrototypes.cleanInput($(this), '0123456789.', '1', '1');
        });
        
        /*
         * Price
         */
        $('#DOPBSP-rule-time_lapse_max').unbind('input propertychange');
        $('#DOPBSP-rule-time_lapse_max').bind('input propertychange', function(){
            DOPPrototypes.cleanInput($(this), '0123456789.', '0', '0');
        });
    };

    /*
     * Add rule.
     */
    this.add = function(){
        DOPBSP.clearColumns(2);
        DOPBSP.toggleMessages('active', DOPBSP.text('RULES_ADD_RULE_ADDING'));

        $.post(ajaxurl, {action: 'dopbsp_rule_add'}, function(data){
            $('#DOPBSP-column1 .column-content').html(data);
            DOPBSP.toggleMessages('success', DOPBSP.text('RULES_ADD_RULE_SUCCESS'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Edit rule.
     * 
     * @param id (Number): rule ID
     * @param type (String): field type
     * @param field (String): rule field
     * @param value (String): rule field value
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
                $('#DOPBSP-rule-ID-'+id+' .name').html(value);
                break;
        }
        
        if (onBlur 
                || type === 'select' 
                || type === 'switch'){
            if (!onBlur){
                DOPBSP.toggleMessages('active-info', DOPBSP.text('MESSAGES_SAVING'));
            }
            
            $.post(ajaxurl, {action: 'dopbsp_rule_edit',
                             id: id,
                             field: field,
                             value: value,
                             language: $('#DOPBSP-rule-language').val()}, function(data){
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

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_rule_edit',
                                                              id: id,
                                                              field: field,
                                                              value: value,
                                                              language: $('#DOPBSP-rule-language').val()}, function(data){
                    DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };


    /*
     * Delete rule.
     * 
     * @param id (Number): rule ID
     */
    this.delete = function(id){
        DOPBSP.toggleMessages('active', DOPBSP.text('RULES_DELETE_RULE_DELETING'));

        $.post(ajaxurl, {action: 'dopbsp_rule_delete', 
                         id: id}, function(data){
            DOPBSP.clearColumns(2);

            $('#DOPBSP-rule-ID-'+id).stop(true, true)
                                      .animate({'opacity':0}, 
                                      600, function(){
                $(this).remove();

                if (data === '0'){
                    $('#DOPBSP-column1 .column-content').html('<ul><li class="no-data">'+DOPBSP.text('RULES_NO_RULES')+'</li></ul>');
                }
                DOPBSP.toggleMessages('success', DOPBSP.text('RULES_DELETE_RULE_SUCCESS'));
            });
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    return this.DOPBSPRule();
};