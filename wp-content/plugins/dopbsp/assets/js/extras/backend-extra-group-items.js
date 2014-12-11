/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/extras/backend-extra-group-items.js
* File Version            : 1.0
* Created / Last Modified : 30 March 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end extra group items JavaScript class.
*/


var DOPBSPExtraGroupItems = new function(){
    /*
     * Private variables
     */
    var $ = jQuery.noConflict();
    
    /*
     * Constructor
     */
    this.DOPBSPExtraGroupItems = function(){
    };
    
    /*
     * Initialize extra group items sort.
     */
    this.init = function(){
        $('#DOPBSP-extra-groups .items').sortable({handle: '.handle',
                                                           opacity: 0.75,
                                                           placeholder: 'placeholder',
                                                           update: function(e, ui){
                                                                var ids = new Array();

                                                                DOPBSP.toggleMessages('active-info', DOPBSP.text('MESSAGES_SAVING'));
                                                                
                                                                $('#'+e.target.id+' li.group-item-wrapper').each(function(){
                                                                    if (!$(this).hasClass('placeholder')){
                                                                        ids.push($(this).attr('id').split('DOPBSP-extra-group-item-')[1]);
                                                                    }
                                                                });
                                                                
                                                                $.post(ajaxurl, {action: 'dopbsp_extra_group_items_sort',
                                                                                 ids: ids.join(',')}, function(data){
                                                                    DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_SAVING_SUCCESS'));
                                                                }).fail(function(data){
                                                                    DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
                                                                });
                                                           }});
    };
    
    return this.DOPBSPExtraGroupItems();
};