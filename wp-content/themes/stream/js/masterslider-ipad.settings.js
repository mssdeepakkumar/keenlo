    // MASTER SLIDER SETTINGS //
    var slider = new MasterSlider();
    slider.setup('mastersliderIpad' , {
      width:800,
      height:500,
      autoplay: true,
      autohide: true,

      //space:100,
      fullwidth:true,
      centerControls:false,
      speed:18,
      loop:true,
      view:'basic'

      //view:'basic'      
    });
    slider.control('arrows'); 
    slider.control('bullets' ,{autohide:false});  