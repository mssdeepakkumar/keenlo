
function setCookie(cname,cvalue,exdays)
{
	var d = new Date();
	d.setTime(d.getTime()+(exdays*24*60*60*1000));
	var expires = "expires="+d.toGMTString();
	document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname)
{
	var name = cname + "=";
	var ca = document.cookie.split(";");
	for(var i=0; i<ca.length; i++) 
	  {
	  var c = ca[i].trim();
	  if (c.indexOf(name)==0) return c.substring(name.length,c.length);
	  }
	return "";
}

function open_popup(id,effect){
	jQuery("#wpep_back_"+id).show();
	jQuery("#wpep_back_"+id).addClass("animated "+effect);
	jQuery("html").css("overflow", "hidden");
}

function close_popup(id,effect){
	jQuery("#wpep_back_"+id).addClass("animated "+effect);
	window.setTimeout(function(){
		jQuery("#wpep_back_"+id).attr('class','wpep_back');
		jQuery("#wpep_back_"+id).hide();
	},1000);
	jQuery("html").css("overflow", "auto");
	
}

function hide_delay(id,effect,delay){
	setTimeout(function(){
		close_popup(id,effect);
	},(delay+1)*1000);
	i=0;
	setInterval(function(){
		jQuery('.wpep_time').html(delay-i);
		i=i+1;
	},1000);
	
}


