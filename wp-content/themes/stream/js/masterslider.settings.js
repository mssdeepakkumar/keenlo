		// MASTER SLIDER SETTINGS //
		var slider = new MasterSlider();
		slider.setup('masterslider' , {
			width:1100,
			height:625,
			autoplay: true,
			autohide: true,
			//space:100,
			fullwidth:true,
			centerControls:false,
			speed:18,
			loop:true,
     		 hideLayers: false,			
			view:'flow'
			//view:'basic'			
		});
		slider.control('arrows');	
		slider.control('bullets' ,{autohide:false});	