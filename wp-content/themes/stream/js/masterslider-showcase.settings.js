    // MASTER SLIDER SETTINGS //
    var slider = new MasterSlider();
    slider.setup('masterslider2' , {
      width:800,
      height:500,
      autoplay: true,
      autohide: true,
      //space:100,
      fullwidth:true,
      centerControls:false,
      speed:18,
      loop:true,
      view:'flow'

      //view:'basic'      
    });
    slider.control('arrows'); 
    slider.control('bullets' ,{autohide:false});  