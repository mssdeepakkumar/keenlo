/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/coupons/backend-coupon.js
* File Version            : 1.0
* Created / Last Modified : 13 May 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end coupon JavaScript class.
*/


var DOPBSPCoupon = new function(){
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
    this.DOPBSPCoupon = function(){
    };
    
    /*
     * Display coupon.
     * 
     * @param id (Number): coupon ID
     * @param language (String): coupon current editing language
     * @param clearCoupon (Boolean): clear coupon extra data diplay
     */
    this.display = function(id,
                            language,
                            clearCoupon){
        var HTML = new Array();
        
        language = language === undefined ? ($('#DOPBSP-coupon-language').val() === undefined ? '':$('#DOPBSP-coupon-language').val()):language;
        clearCoupon = clearCoupon === undefined ? true:false;
        language = clearCoupon ? '':language;
        
        if (clearCoupon){
            DOPBSP.clearColumns(2);
        }
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_LOADING'));
        
        $('#DOPBSP-column1 .column-content li').removeClass('selected');
        $('#DOPBSP-coupon-ID-'+id).addClass('selected');
        $('#DOPBSP-coupon-ID').val(id);
        
        $.post(ajaxurl, {action: 'dopbsp_coupon_display', 
                         id: id,
                         language: language}, function(data){
            HTML.push('<a href="javascript:DOPBSP.confirmation(\'COUPONS_DELETE_COUPON_CONFIRMATION\', \'DOPBSPCoupon.delete('+id+')\')" class="button delete"><span class="info">'+DOPBSP.text('COUPONS_DELETE_COUPON_SUBMIT')+'</span></a>');
            HTML.push('<a href="'+DOPBSP_CONFIG_HELP_DOCUMENTATION_URL+'" target="_blank" class="button help">');
            HTML.push(' <span class="info help">');
            HTML.push(DOPBSP.text('COUPONS_COUPON_HELP')+'<br /><br />');
            HTML.push(DOPBSP.text('HELP_VIEW_DOCUMENTATION'));
            HTML.push(' </span>');
            HTML.push('</a>');
            
            $('#DOPBSP-column2 .column-header').html(HTML.join(''));
            $('#DOPBSP-column2 .column-content').html(data);
            
            $('#DOPBSP-coupon-start_date').datepicker();
            $('#DOPBSP-coupon-end_date').datepicker();
            
            DOPBSPCoupon.init();
            DOPBSP.toggleMessages('success', DOPBSP.text('COUPONS_COUPON_LOADED'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    /*
     * Initialize events and validations.
     */
    this.init = function(){
        /*
         * Price validation.
         */
        var dayNames = [DOPBSP.text('DAY_MONDAY'),
                        DOPBSP.text('DAY_TUESDAY'),
                        DOPBSP.text('DAY_WEDNESDAY'),
                        DOPBSP.text('DAY_THURSDAY'),
                        DOPBSP.text('DAY_FRIDAY'),
                        DOPBSP.text('DAY_SATURDAY'),
                        DOPBSP.text('DAY_SUNDAY')],
        dayShortNames = [DOPBSP.text('SHORT_DAY_MONDAY'),
                         DOPBSP.text('SHORT_DAY_TUESDAY'),
                         DOPBSP.text('SHORT_DAY_WEDNESDAY'),
                         DOPBSP.text('SHORT_DAY_THURSDAY'),
                         DOPBSP.text('SHORT_DAY_FRIDAY'),
                         DOPBSP.text('SHORT_DAY_SATURDAY'),
                         DOPBSP.text('SHORT_DAY_SUNDAY')],
        monthNames = [DOPBSP.text('MONTH_JANUARY'),
                      DOPBSP.text('MONTH_FEBRUARY'),
                      DOPBSP.text('MONTH_MARCH'),
                      DOPBSP.text('MONTH_APRIL'),
                      DOPBSP.text('MONTH_MAY'),
                      DOPBSP.text('MONTH_JUNE'),
                      DOPBSP.text('MONTH_JULY'),
                      DOPBSP.text('MONTH_AUGUST'),
                      DOPBSP.text('MONTH_SEPTEMBER'),
                      DOPBSP.text('MONTH_OCTOBER'),
                      DOPBSP.text('MONTH_NOVEMBER'),
                      DOPBSP.text('MONTH_DECEMBER')],
        monthShortNames = [DOPBSP.text('SHORT_MONTH_JANUARY'),
                           DOPBSP.text('SHORT_MONTH_FEBRUARY'),
                           DOPBSP.text('SHORT_MONTH_MARCH'),
                           DOPBSP.text('SHORT_MONTH_APRIL'),
                           DOPBSP.text('SHORT_MONTH_MAY'),
                           DOPBSP.text('SHORT_MONTH_JUNE'),
                           DOPBSP.text('SHORT_MONTH_JULY'),
                           DOPBSP.text('SHORT_MONTH_AUGUST'),
                           DOPBSP.text('SHORT_MONTH_SEPTEMBER'),
                           DOPBSP.text('SHORT_MONTH_OCTOBER'),
                           DOPBSP.text('SHORT_MONTH_NOVEMBER'),
                           DOPBSP.text('SHORT_MONTH_DECEMBER')],
        startDate,
        minDate;
        
        /*
         * Start date.
         */
        $('#DOPBSP-coupon-start_date').datepicker('destroy');                      
        $('#DOPBSP-coupon-start_date').datepicker({beforeShow: function(input, inst){
                                                        $('#ui-datepicker-div').removeClass('DOPBSP-admin-datepicker')
                                                                               .addClass('DOPBSP-admin-datepicker');
                                                  },
                                                  dateFormat: 'yy-mm-dd',
                                                  dayNames: dayNames,
                                                  dayNamesMin: dayShortNames,
                                                  minDate: 0,
                                                  monthNames: monthNames,
                                                  monthNamesMin: monthShortNames,
                                                  nextText: '',
                                                  prevText: ''});
                           
        $('#DOPBSP-coupon-start_date').unbind('change');
        $('#DOPBSP-coupon-start_date').bind('change', function(){
            $('#DOPBSP-coupon-end_date').val('');
            DOPBSPCoupon.init();
        });
        
        /*
         * End date.
         */
        startDate = $('#DOPBSP-coupon-start_date'); 
        minDate = startDate.val() === '' ? 0:DOPPrototypes.getDatesDifference(DOPPrototypes.getToday(), startDate.val(), 'days', 'integer');
            
        $('#DOPBSP-coupon-end_date').datepicker('destroy');                      
        $('#DOPBSP-coupon-end_date').datepicker({beforeShow: function(input, inst){
                                                    $('#ui-datepicker-div').removeClass('DOPBSP-admin-datepicker')
                                                                           .addClass('DOPBSP-admin-datepicker');
                                                },
                                                dateFormat: 'yy-mm-dd',
                                                dayNames: dayNames,
                                                dayNamesMin: dayShortNames,
                                                minDate: minDate,
                                                monthNames: monthNames,
                                                monthNamesMin: monthShortNames,
                                                nextText: '',
                                                prevText: ''});
        
        $('.ui-datepicker').removeClass('notranslate').addClass('notranslate');

        /*
         * Number of coupons.
         */
        $('#DOPBSP-coupon-no_coupons').unbind('input propertychange');
        $('#DOPBSP-coupon-no_coupons').bind('input propertychange', function(){
            DOPPrototypes.cleanInput($(this), '0123456789', '', '');
        });
        
        /*
         * Price
         */
        $('#DOPBSP-coupon-price').unbind('input propertychange');
        $('#DOPBSP-coupon-price').bind('input propertychange', function(){
            DOPPrototypes.cleanInput($(this), '0123456789.', '0', '0');
        });
    };

    /*
     * Add coupon.
     */
    this.add = function(){
        DOPBSP.clearColumns(2);
        DOPBSP.toggleMessages('active', DOPBSP.text('COUPONS_ADD_COUPON_ADDING'));

        $.post(ajaxurl, {action: 'dopbsp_coupon_add'}, function(data){
            $('#DOPBSP-column1 .column-content').html(data);
            DOPBSP.toggleMessages('success', DOPBSP.text('COUPONS_ADD_COUPON_SUCCESS'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Edit coupon.
     * 
     * @param id (Number): coupon ID
     * @param type (String): field type
     * @param field (String): coupon field
     * @param value (String): coupon field value
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
                $('#DOPBSP-coupon-ID-'+id+' .name').html(value);
                break;
        }
        
        if (onBlur 
                || type === 'select' 
                || type === 'switch'){
            if (!onBlur){
                DOPBSP.toggleMessages('active-info', DOPBSP.text('MESSAGES_SAVING'));
            }
            
            $.post(ajaxurl, {action: 'dopbsp_coupon_edit',
                             id: id,
                             field: field,
                             value: value,
                             language: $('#DOPBSP-coupon-language').val()}, function(data){
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

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_coupon_edit',
                                                              id: id,
                                                              field: field,
                                                              value: value,
                                                              language: $('#DOPBSP-coupon-language').val()}, function(data){
                    DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };


    /*
     * Delete coupon.
     * 
     * @param id (Number): coupon ID
     */
    this.delete = function(id){
        DOPBSP.toggleMessages('active', DOPBSP.text('COUPONS_DELETE_COUPON_DELETING'));

        $.post(ajaxurl, {action: 'dopbsp_coupon_delete', 
                         id: id}, function(data){
            DOPBSP.clearColumns(2);

            $('#DOPBSP-coupon-ID-'+id).stop(true, true)
                                      .animate({'opacity':0}, 
                                      600, function(){
                $(this).remove();

                if (data === '0'){
                    $('#DOPBSP-column1 .column-content').html('<ul><li class="no-data">'+DOPBSP.text('COUPONS_NO_COUPONS')+'</li></ul>');
                }
                DOPBSP.toggleMessages('success', DOPBSP.text('COUPONS_DELETE_COUPON_SUCCESS'));
            });
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    /*
     * Generate coupon code.
     * 
     * @param id (Number): coupon ID
     */
    this.generateCode = function(id){
        var code = DOPPrototypes.getRandomString(16);
        
        $('#DOPBSP-coupon-code').val(code);
        DOPBSPCoupon.edit(id,
                          'text',
                          'code',
                          code);
    };

    return this.DOPBSPCoupon();
};