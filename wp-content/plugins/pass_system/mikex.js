jQuery(document).ready(function() {
        //When the text span is clicked
        jQuery('.mikex-span').click(function() {
            
            //Define the newcolor
            newColor = jQuery(this).attr('newColor');
            
            //Change the color
            jQuery(this).css('color', newColor);    
        });
});