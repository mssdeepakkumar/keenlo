/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/backend-translation.js
* File Version            : 1.0
* Created / Last Modified : 08 April 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end translation JavaScript class.
*/

var DOPBSPTranslation = new function(){
    /*
     * Private variables
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
    this.DOPBSPTranslation = function(){
    };
    
    /*
     * Change back end language.
     */
    this.change = function(){
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_SAVING'));
        
        $.post(ajaxurl, {action: 'dopbsp_translation_change',
                         language: $('#DOPBSP-admin-translation').val()}, function(data){
            window.location.reload();
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Display translation.
     */
    this.display = function(){
        $('#DOPBSP-translation-manage-translation').css('display', 'none');
        $('#DOPBSP-translation-manage-language').css('display', 'block');
        $('#DOPBSP-translation-manage-text-group').css('display', 'block');
        $('#DOPBSP-translation-manage-search').css('display', 'block');
        $('#DOPBSP-translation-manage-languages').css('display', 'block');
        $('#DOPBSP-translation-reset').css('display', 'block');
        $('#DOPBSP-translation-search').val('');
        $('#DOPBSP-translation-check').css('display', 'block');
        
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_LOADING'));
        $('#DOPBSP-translation-content').html('');

        $.post(ajaxurl, {action: 'dopbsp_translation_display',
                         language: $('#DOPBSP-translation-language').val(),
                         text_group: $('#DOPBSP-translation-text-group').val()}, function(data){
            $('#DOPBSP-translation-content').html(data);
            $('.DOPBSP-admin .main').css('display', 'block');
            DOPBSP.toggleMessages('success', DOPBSP.text('TRANSLATION_LOADED'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Edit translation.
     * 
     * @param id (Number): translation field ID
     * @param language (String): language to be translated
     * @param value (String): new translation
     * @param onBlur (Boolean): true if function has been called on blur event
     */
    this.edit = function(id, 
                         language, 
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
        
        if (onBlur){
            $.post(ajaxurl, {action: 'dopbsp_translation_edit',
                             id: id,
                             language: language,
                             value: value}, function(data){
            }).fail(function(data){
                DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
            });
        }
        else{
            DOPBSP.toggleMessages('active-info', DOPBSP.text('MESSAGES_SAVING'));
        
            this.ajaxRequestTimeout = setTimeout(function(){
                clearTimeout(this.ajaxRequestTimeout);

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_translation_edit',
                                                              id: id,
                                                              language: language,
                                                              value: value}, function(data){
                    DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };

    /*
     * Search translation fields.
     */
    this.search = function(){
        var search = $('#DOPBSP-translation-search').val().toLowerCase();

        $('#DOPBSP-translation-content tr').each(function(){
            if ($('td:first-child', this).html().toLowerCase().indexOf(search) !== -1
                || $('textarea', this).val().toLowerCase().indexOf(search) !== -1
                || search === ''){
                $(this).removeAttr('style');
            }
            else{
                $(this).css('display','none');
            }
        });
    };

    /*
     * Reset translation.
     */
    this.reset = function(){
        DOPBSP.toggleMessages('active', DOPBSP.text('TRANSLATION_RESETING'));
        $('#DOPBSP-translation-content').html('');

        $.post(ajaxurl, {action: 'dopbsp_translation_reset',
                         ajax_request: true}, function(data){
            DOPBSP.toggleMessages('active', DOPBSP.text('TRANSLATION_RESET_SUCCESS'));

            setTimeout(function(){
                window.location.reload();
            }, 100);
        });
    };
    
    /*
     * Check if translation is used in plugin.
     */
    this.check = function(){
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_LOADING'));
        $('#DOPBSP-translation-content').html('');
        
        $.post(ajaxurl, {action: 'dopbsp_translation_check'}, function(data){
            $('#DOPBSP-translation-content').addClass('checked')
                                            .html(data);
            DOPBSP.toggleMessages('success', '!');
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    /*
     * Display languages.
     */
    this.displayLanguages = function(){
        $('.DOPBSP-admin .main').css('display', 'block');
        $('#DOPBSP-translation-manage-translation').css('display', 'block');
        $('#DOPBSP-translation-manage-language').css('display', 'none');
        $('#DOPBSP-translation-manage-text-group').css('display', 'none');
        $('#DOPBSP-translation-manage-search').css('display', 'none');
        $('#DOPBSP-translation-manage-languages').css('display', 'none');
        $('#DOPBSP-translation-reset').css('display', 'none');
        $('#DOPBSP-translation-check').css('display', 'none');
        
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_LOADING'));
        $('#DOPBSP-translation-content').html('');

        $.post(ajaxurl, {action: 'dopbsp_translation_display_languages'}, function(data){
            $('#DOPBSP-translation-content').html(data);
            DOPBSP.toggleMessages('success', DOPBSP.text('TRANSLATION_MANAGE_LANGUAGES_LOADED'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Set language to be used.
     * 
     * @param language (String): language code
     */
    this.setLanguage = function(language){
        if ($('#DOPBSP-translation-language-'+language).is(':checked')){
            DOPBSPTranslation.saveLanguage(language);
        }
        else{
            DOPBSP.confirmation('TRANSLATION_MANAGE_LANGUAGES_REMOVE_CONFIGURATION', "DOPBSPTranslation.saveLanguage('"+language+"')", "$('#DOPBSP-translation-language-"+language+"').attr('checked', 'checked');");
        }
    };
    
    /*
     * Enable/disable language.
     * 
     * @param language (String): language code
     */
    this.saveLanguage = function(language){
        DOPBSP.toggleMessages('active', $('#DOPBSP-translation-language-'+language).is(':checked') ? DOPBSP.text('TRANSLATION_MANAGE_LANGUAGES_SETING'):DOPBSP.text('TRANSLATION_MANAGE_LANGUAGES_REMOVING'));

        $.post(ajaxurl, {action: 'dopbsp_translation_set_language',
                         language: language,
                         value: $('#DOPBSP-translation-language-'+language).is(':checked') ? 'true':'false'}, function(data){
            DOPBSP.toggleMessages('active', $('#DOPBSP-translation-language-'+language).is(':checked') ? DOPBSP.text('TRANSLATION_MANAGE_LANGUAGES_SET_SUCCESS'):DOPBSP.text('TRANSLATION_MANAGE_LANGUAGES_REMOVE_SUCCESS'));
            DOPPrototypes.setCookie('DOPBSP-translation-redirect', 'languages', 1);

            setTimeout(function(){
                window.location.reload();
            }, 2000);
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    return this.DOPBSPTranslation();
};