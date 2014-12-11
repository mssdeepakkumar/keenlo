(function() {
    tinymce.create('tinymce.plugins.oscitasSlidetastic', {
        init : function(ed, url) {
            ed.addButton('oscitasslidetastic', {
                title : 'Slidetastic Shortcode',
                image : url+'/icon.png',
                onclick : function() {
                    create_oscitas_slidetastic();
                    jQuery.fancybox({
                        'type' : 'inline',
                        'title' : 'Slidetastic Simple Carousel Shortcode',
                        'href' : '#oscitas-form-slidetastic',
                        helpers:  {
                            title : {
                                type : 'over',
                                position:'top'
                            }
                        }
                        
                    });
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Slidetastic Simple Carousel Shortcode",
                author : 'Heath Taskis',
                authorurl : 'http://www.fdthemes.com/',
                infourl : 'http://www.fdthemes.com/',
                version : "2.0.0"
            };
        }
    });
    tinymce.PluginManager.add('oscitasslidetastic', tinymce.plugins.oscitasSlidetastic);
})();

function create_oscitas_slidetastic(){
    if(jQuery('#oscitas-form-slidetastic').length){
        jQuery('#oscitas-form-slidetastic').remove();
    }
    // creates a form to be displayed everytime the button is clicked
    // you should achieve this using AJAX instead of direct html code like this
    var form = jQuery('<div id="oscitas-form-slidetastic"><table id="oscitas-table" class="form-table">\
				<th><label for="oscitas-label-content">Upload Image:</label></th>\
				<td id="osc_slidetastic_upload"><input id="oscitas-slidetastic-src" type="hidden" name="oscitas-thumbnail-src"  value="" />\
                                <input id="_btn" class="upload_slidetastic_button" type="button" value="Upload Image" />\
				</td>\
			</tr>\
                        <tr>\
				<th><label for="oscitas-slidetastic-shape">Image Shape:</label></th>\
				<td><select name="oscitas-slidetastic-shape" id="oscitas-slidetastic-shape">\
                                <option value="img-rounded">Rounded</option>\
                                <option value="img-circle">Circle</option>\
                                <option value="img-thumbnail">Thumbnail</option>\
                                </select>\
				</td>\
			</tr>\
                        <tr>\
				<th><label for="oscitas-slidetastic-class">Custom Class:</label></th>\
				<td><input type="text" name="line" id="oscitas-slidetastic-class" value=""/><br />\
				</td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="oscitas-slidetastic-submit" class="button-primary" value="Insert Image" name="submit" />\
		</p>\
		</div>');
    
    var table = form.find('table');
    form.appendTo('body').hide();

    
    form.find('.upload_slidetastic_button').click(function() {
        jQuery('.fancybox-overlay').css('z-index',100);
        jQuery('html').addClass('Slidetastic');
        formfield = jQuery(this).prev().attr('id');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        return false;
    });

    window.original_send_to_editor = window.send_to_editor;

    window.send_to_editor = function(html) {
        if (formfield) {
            if (jQuery(html).find('img').length) {
                fileurl = jQuery('img', html).attr('src');
            } else if (jQuery(html).attr('src')) {
                fileurl = jQuery(html).attr('src');
            }
            jQuery('#' + formfield).val(fileurl);
            tb_remove();
            form.find('#osc_slidetastic_upload img').remove();
            form.find('#osc_slidetastic_upload').append('<img src="'+fileurl+'">')
            jQuery('html').removeClass('Slidetastic');

        } else {
            window.original_send_to_editor(html);
        }

    };
        
		
    // handles the click event of the submit button
    form.find('#oscitas-slidetastic-submit').click(function(){
      var shortcode='';
        var shape=form.find('#oscitas-slidetastic-shape').val();
        var cusclass='';
        if(table.find('#oscitas-slidetastic-class').val()!=''){
            cusclass= ' class="'+table.find('#oscitas-slidetastic-class').val()+'"';
        }
        if(form.find('#oscitas-slidetastic-src').val()!=''){
             shortcode = '[slidetastic'+cusclass+' src="'+form.find('#oscitas-slidetastic-src').val()+'" shape="'+shape+'"]';
        }
        // inserts the shortcode into the active editor
        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
        // closes fancybox
        jQuery.fancybox.close();
    });
}

