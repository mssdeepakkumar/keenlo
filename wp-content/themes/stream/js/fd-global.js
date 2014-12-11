jQuery.event.add(window, "load", resizeFrame);
jQuery.event.add(window, "resize", resizeFrame);
jQuery.noConflict();

function resizeFrame() 
{
    
    var h = jQuery(window).height();
    var w = jQuery(window).width();    
    var trimH = h / 1.15;    
    var homeTitle = jQuery(".homeTitle").height();
    var midH = (h - homeTitle) / 3;   

    var jumboTron = jQuery("#jt").height()+48;
    

    jQuery('.article-wrap').each(function(){
        var jQuerythis = jQuery(this);
        var thisHeight = jQuery(this).height(); 
        var currTn = jQuerythis.find(".pad-blog-tn");
        jQuery(this).find(".pad-blog-tn").height(thisHeight);


    });
      jQuery("#featureImage").css('height', trimH);
      jQuery(".homeTitle").css('padding-top', midH);   


      if(w <= 600 ){
            jQuery('.secondary-nav-wrap').css('height', '0'); 
            jQuery('.secondary-nav-wrap').css('display', 'none');               
      }else{
            jQuery('.secondary-nav-wrap').css('height', 'auto'); 
            jQuery('.secondary-nav-wrap').css('display', 'block');   
      }
            var mastheadH = jQuery(".secondary-nav-wrap").height(); 
            var navH = jQuery(".navbar-fixed-top").height(); 
            var adminBarH = jQuery("#wpadminbar").height();    
            jQuery(".secondary-nav-wrap").css('padding-top', adminBarH);      
            jQuery(".navbar-fixed-top").css('top', mastheadH+adminBarH);
            jQuery("#content").css('padding-top', mastheadH+navH);
            var progTop = mastheadH+adminBarH+navH;
            jQuery('#progress').css('top', progTop);  
  

}



function getTnHeight() 
{
 //alert("Getting here");
      jQuery('.article-wrap').each(function(){
        var jQuerythis = jQuery(this);
        var thisHeight = jQuery(this).height(); 
        var currTn = jQuerythis.find(".pad-blog-tn");
        jQuery(this).find(".pad-blog-tn").height(thisHeight);


    });


};


// global keycode constant
var KEYCODE_ESC = 27;
// extending the jQuery prototype with setCursorPosition

jQuery.fn.setCursorPosition = function(pos) {
  this.each(function(index, elem) {
    if (elem.setSelectionRange) {
      elem.setSelectionRange(pos, pos);
    } else if (elem.createTextRange) {
      var range = elem.createTextRange();
      range.collapse(true);
      range.moveEnd('character', pos);
      range.moveStart('character', pos);
      range.select();
    }
  });
  return false;
};


// Public domain, really.
 


// intialize
jQuery(document).ready( function() {





  

      var mainNavH = jQuery(".navbar-default").height();
      var secondNavH = jQuery(".secondary-nav-wrap").height();   
      var progPad =   ((mainNavH-30) +  secondNavH);   
     // jQuery('#progress').css('margin-top', progPad);   


      //FitVid
      jQuery("#video-wrapper").fitVids();
      
      var mastheadH = jQuery(".secondary-nav-wrap").height(); 
      var navH = jQuery(".navbar-fixed-top").height(); 
      var adminBarH = jQuery("#wpadminbar").height();    
 
      jQuery(".secondary-nav-wrap").css('padding-top', adminBarH);      
      jQuery(".navbar-fixed-top").css('top', mastheadH+adminBarH);
      jQuery("#content").css('padding-top', mastheadH+navH);


      var progTop = mastheadH+adminBarH+navH;
     
      jQuery('#progress').css('top', progTop);  


jQuery('#myTab a').click(function (e) {
  e.preventDefault()
  jQuery(this).tab('show')
});

jQuery('.nav-pills, .nav-tabs').tabdrop();

//Tweetable
    jQuery(".tweetable").hover(
      function(){
            if (jQuery(this).data('vis') != true) {
                    jQuery(this).data('vis', true);
                    jQuery(this).find('.sharebuttons').fadeIn(200);
            }
      },
      function(){
            if (jQuery(this).data('vis') === true) {
                    jQuery(this).find('.sharebuttons').clearQueue().delay(0).fadeOut(200);
                    jQuery(this).data('vis', false);
                    jQuery(this).data('leftSet', false);
            }
      });

 //jQuery('.nt-click').click(getTnHeight() );

 jQuery(".nt-click").click(function(){ 
  //alert("click");
  setTimeout(getTnHeight, 200);
jQuery(".article-wrap").trigger("unveil");
  //jQuery( ".article-wrap:first-child" ).class( "in" );  
  //jQuery("article:first-child").addClass("in");
 // jQuery( "#masthead" ).scroll();  
 });


jQuery( ".navbar-toggle" ).click(function() {
  jQuery( ".bar-one" ).toggleClass( "bar-rotate-left" );
  jQuery( ".bar-two" ).toggleClass( "bar-fade" );   
  jQuery( ".bar-three" ).toggleClass( "bar-rotate-right" );  
});



  var jQuerysearch = jQuery('#search');
  var jQuerysearchtext = jQuery('#searchtext');

  jQuery(document).keydown(function(e) {
    if(jQuerysearch.is(':visible')) {
      switch (e.which) {
        case KEYCODE_ESC:
          jQuerysearch.fadeOut(200);
          jQuerysearchtext.blur().hide();
        break;
        default:
          jQuerysearchtext.focus();
        break;
      }
    } else {
       //0-9 & A-Z Only 
      if(event.which>=47 && event.which<=90)
      {
        if (jQuery('input:focus, textarea:focus').length == 0) { 
          jQuerysearchtext.show().focus();
          // grab the key pressed ( String.fromCharCode(e.which) ) 
          // and insert it into jQuerysearchtext.
          // then,set the cursor to the end of jQuerysearchtext.
          jQuerysearchtext.val(String.fromCharCode(e.which).toLowerCase())
                     .setCursorPosition(jQuerysearchtext.val().length);
          jQuerysearch.fadeIn(200); 
        }
      }
    }
  });

 
 jQuery(".search-cta").click(function(){ 
     // alert("search");
      jQuerysearch.fadeIn(200); 
      jQuerysearchtext.show().focus();
 });

jQuery("#search, .search-close").click(function(){ 
          jQuerysearch.fadeOut(200);
          jQuerysearchtext.blur().hide();

  
 });


});
jQuery(window).scroll(function() {

    var h = jQuery('#main').height();
    var s = jQuery(window).scrollTop();
    var w = jQuery(window).height();
    
    var t = (s / h) * w;
    
    var p = Math.ceil((s + t) / h * 110) + 1;
    
    jQuery('#bar').width(p + '%');

    if (s > 350){
      jQuery('#bar').height(50);
      jQuery('#progress').css('height', '50px');   
      jQuery('#progress').css('box-shadow' , '0px 5px 0px rgba(0,0,0,0.1)'); 
      jQuery('.title-scroll').css('opacity', '1');   
      jQuery('.title-scroll').css('display', 'block');  
    }else{
      jQuery('#bar').height(3);  
      jQuery('#progress').css('height', '3px');
      jQuery('#progress').css('box-shadow' , '0px 5px 0px rgba(0,0,0,0)'); 
      jQuery('.title-scroll').css('opacity', '0'); 
      jQuery('.title-scroll').css('display', 'none');        
    }
});
