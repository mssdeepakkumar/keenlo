/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/backend-widget.js
* File Version            : 1.0
* Created / Last Modified : 10 April 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end widget JavaScript class.
*/

var DOPBSPWidget = new function(){
/*
 * Private variables.
 */
    var $ = jQuery.noConflict();

    /*
     * Constructor
     */
    this.DOPBSPWidget = function(){
    };
    
    this.display = function(id,
                            selection){
        $('#DOPBSP-widget-id-'+id).css('display', 'none');
        $('#DOPBSP-widget-lang-'+id).css('display', 'none');

        switch (selection){
            case 'calendar':
                $('#DOPBSP-widget-id-'+id).css('display', 'block');
                $('#DOPBSP-widget-lang-'+id).css('display', 'block');
                break;
            case 'sidebar':
                $('#DOPBSP-widget-id-'+id).css('display', 'block');
                break;
        }
    };
    
    return this.DOPBSPWidget();
};