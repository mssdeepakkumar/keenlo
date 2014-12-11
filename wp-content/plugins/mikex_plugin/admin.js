 jQuery(document).ready(function() {
    
    jQuery('#mikex-settings').submit(function() {
        var postURL = jQuery(this).attr('action');
        var serializedSettings = jQuery(this).serialize();
        
        //Post the serialized form data into the action URL in the form
        jQuery.post(postURL, serializedSettings);
        
        //Update the form stated to 'Updated!'
        jQuery('.update-status').text('Updated!');
        
        //We do not want the form submitted so we return false
        return false;
    });
    
    //Remove the 'Updated!' status when an input is focused upon
    jQuery('#mikex-settings input').focus(function() {
         jQuery('.update-status').text('');
    });
    
});
 