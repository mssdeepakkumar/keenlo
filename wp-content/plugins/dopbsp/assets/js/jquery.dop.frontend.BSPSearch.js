(function($){
    $.fn.DOPBSPSearch = function(calendars,min_all,max_all,currency,currency_code){
         min_all = parseInt(min_all);
         min_all = 0;
         max_all = parseInt(max_all);
         console.log(min_all,max_all);
         prototypes = {
             convertDate: function(date){
                 var year = date.split('/')[2],
                     month = date.split('/')[0],
                     day = date.split('/')[1],
                     date = year+'-'+month+'-'+day;
             
                    if (year == undefined || month == undefined || day == undefined){
                        return 0;
                    }
                 
                 return date;
             },
            getRate: function(rating){ // Generate Rating
                var ratingHTML = new Array();
                
                switch(rating){
                    case -1:
                        ratingHTML.push('');
                        break;
                    case 1:
                        ratingHTML.push('<div class="DOPBSPSearch-star-orange"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-gray"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-gray"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-gray"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-gray"></div>');
                        break;
                    case 2:
                        ratingHTML.push('<div class="DOPBSPSearch-star-orange"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-orange"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-gray"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-gray"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-gray"></div>');
                        break;
                    case 3:
                        ratingHTML.push('<div class="DOPBSPSearch-star-orange"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-orange"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-orange"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-gray"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-gray"></div>');
                        break;
                    case 4:
                        ratingHTML.push('<div class="DOPBSPSearch-star-orange"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-orange"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-orange"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-orange"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-gray"></div>');
                        break;
                    case 5:
                        ratingHTML.push('<div class="DOPBSPSearch-star-orange"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-orange"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-orange"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-orange"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-orange"></div>');
                        break;
                    default:
                        ratingHTML.push('<div class="DOPBSPSearch-star-gray"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-gray"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-gray"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-gray"></div>');
                        ratingHTML.push('<div class="DOPBSPSearch-star-gray"></div>');
                        break;
                }
                
                return ratingHTML.join('');
            },
            generatePages: function(calendars,no_per_page,current_page){ // Generate Pages Links
                var linksHTML = new Array(),
                    no_pages = parseInt(calendars/no_per_page),
                    i = 0;
                    
                    if (current_page > 1) {
                        var previous = parseInt(current_page)-1;
                        linksHTML.push('<li onclick="javascript:methods_search.changePage('+previous+');" style="margin-right:15px;"><</li>');
                    }
                    
                    if (no_pages > 0) { 
                        
                        for(i=0; i<=no_pages; i++){
                            var j=i+1;
                            
                            if (j == current_page) {
                                linksHTML.push('<li class="selected" onclick="javascript:methods_search.changePage('+j+');" style="margin-right:2px;" selected="selected">'+j+'</li>');
                            } else {
                                linksHTML.push('<li onclick="javascript:methods_search.changePage('+j+');" style="margin-right:2px;">'+j+'</li>');
                            }
                        }
                        
                    } else {
                        linksHTML.push('<li class="selected" onclick="javascript:methods_search.changePage(1);" style="margin-right:15px;" selected="selected">1</li>');
                    }
                    
                    if ((current_page-1) < no_pages) {
                        var next = parseInt(current_page)+1;
                        linksHTML.push('<li onclick="javascript:methods_search.changePage('+next+');" style="margin-left:15px;">></li>');
                    }
                    
                    return linksHTML.join('');
            }
         };
         
        // GET DATA 
        var Data = {'min_price': min_all,
                    'max_price': max_all,
                    'start_date': prototypes.convertDate($("#DOPBSP_start_date").val()),
                    'end_date': prototypes.convertDate($("#DOPBSP_end_date").val()),
                    'start_hour': $("#DOPBSP_start_hour").val(),
                    'end_hour': $("#DOPBSP_end_hour").val(),
                    'sort_by': $("#DOPBSP_sort_by").val(),
                    'calendars_per_page': $("#DOPBSP_no_calendars").val(),
                    'current_page': $("#DOPBSP_curr_page").val(),
                    'no_calendars_message': $("#DOPBSP_no_calendars_message").val()
                   };
         
         methods_search = {
             Init: function(){
                // DATE
                $('.DOPBSP-date').datepicker({
                    onSelect: function(dateText) {
                      // Display
                      methods_search.display();
                    } 
                });
                $("#ui-datepicker-div").addClass("DOPBSPCalendar-datepicker");
                  

                // SLIDER
                $("#DOPBSP-price").slider({
                    range: true,
                    step:1,
                    min: parseInt(min_all),
                    max: parseInt(max_all),
                    values: [ parseInt(min_all), parseInt(max_all) ],
                    slide: function( event, ui ) {
                        $("#DOPSPSearch-min-price-info").html(ui.values[0]+currency_code);
                        $("#DOPSPSearch-max-price-info").html(ui.values[1]+currency_code);
                        // Display
                        methods_search.display();
                    }
                 });
                 
                 $('.ui-slider-handle').eq(1).css({'margin-left': '-.2em'});
                 
                // HOURS
                $('.DOPBSP-hour-select').unbind('change');
                $('.DOPBSP-hour-select').bind('change',function(){
                    // Display
                    methods_search.display();
                });
                 
                 // SLIDER PRICE INFO
                 $("#DOPBSP-price .ui-slider-handle").eq(0).append('<span id="DOPSPSearch-min-price-info" class="DOPBSPSearch-price-info">'+min_all+currency_code+'</span>');
                 $("#DOPBSP-price .ui-slider-handle").eq(1).append('<span id="DOPSPSearch-max-price-info" class="DOPBSPSearch-price-info" style="left:-5px;">'+max_all+currency_code+'</span>');
                 
             },
             display: function(){
                
                // GET DATA 
                var Data = {'min_price': parseInt($("#DOPBSP-price").slider("values", 0)),
                            'max_price': parseInt($("#DOPBSP-price").slider("values", 1)),
                            'start_date': prototypes.convertDate($("#DOPBSP_start_date").val()),
                            'end_date': prototypes.convertDate($("#DOPBSP_end_date").val()),
                            'start_hour': $("#DOPBSP_start_hour").val(),
                            'end_hour': $("#DOPBSP_end_hour").val(),
                            'sort_by': $("#DOPBSP_sort_by").val(),
                            'calendars_per_page': $("#DOPBSP_no_calendars").val(),
                            'current_page': $("#DOPBSP_curr_page").val(),
                            'no_calendars_message': $("#DOPBSP_no_calendars_message").val()
                           },
                    no_calendars = 0,
                    displayed = 0;
            
                    
                // EMPTY RESULTS
                $('#DOPBSPSearch-Results').html('');
                $('#DOPBSPSearch-Pages').html('');
                var calendarsNew = JSON.parse(calendars);
                // GET CALENDRS
                $.each(calendarsNew, function(index){
                   var availability = calendarsNew[index]['availability'].replace(new RegExp('"', 'g'), ""),
                       availability = availability.replace(new RegExp(';;;', 'g'), '"');
                   var calendarData = {'calendar_id': calendarsNew[index]['calendar_id'],
                                       'calendar_user_id': calendarsNew[index]['user_id'],
                                       'calendar_post_id': calendarsNew[index]['post_id'],
                                       'calendar_name': calendarsNew[index]['name'],
                                       'calendar_description': calendarsNew[index]['description'],
                                       'calendar_image': calendarsNew[index]['image'],
                                       'calendar_link': calendarsNew[index]['link'],
                                       'calendar_rating': parseInt(calendarsNew[index]['rating']),
                                       'calendar_min_price': parseInt(calendarsNew[index]['min_price']),
                                       'calendar_max_price': parseInt(calendarsNew[index]['max_price']),
                                       'calendar_availability': JSON.parse(availability),
                                       'calendar_currency_code': currency_code,
                                       'calendar_view_text': 'View',
                                       'calendar_start_text': 'Start at'
                                    };
                       
                    if (methods_search.checkCalendar(calendarData,Data) > 0){
                        var skip_calendars = (parseInt(Data['current_page'])-1)*parseInt(Data['calendars_per_page']);
                        
                        if (no_calendars >= skip_calendars && displayed < parseInt(Data['calendars_per_page'])) {
                            methods_search.displayCalendar(calendarData);
                            displayed++;
                        }
                        no_calendars++;
                    }
                          
                });
                
                if (no_calendars < 1) {
                    $('#DOPBSPSearch-Results').html($('#DOPBSP_no_calendars_message').val());
                }
                
                // Pagination
                $('#DOPBSPSearch-Pages').html(prototypes.generatePages(no_calendars,Data['calendars_per_page'],Data['current_page']));
                
             },
             checkHour: function(start_hour,end_hour,hours){
                var found = 0;
                
                if (typeof hours != 'undefined') {
                    $.each(hours, function(index){
                        
                        if (start_hour <= hours[index]['start-hour'] && end_hour >= hours[index]['end-hour']){
                            found = 1;
                            return found;
                        }
                    });
                } else {
                    found = 1;
                }
                
                return found;
             },
             checkCalendar: function(calendarData,Data){
                var found = 0;
            
                $.each(calendarData['calendar_availability'], function(index){
                    var calendar = calendarData['calendar_availability'][index];
                    
                    if (parseInt(calendarData['calendar_max_price']) >= parseInt(Data['min_price']) && parseInt(Data['max_price']) >= parseInt(calendarData['calendar_min_price'])) {//   // parseInt(Data['min_price']) >= parseInt(calendarData['calendar_min_price']) && 
                        
                        if (typeof calendar['date'] == 'undefined') {// Days Calendar
                            
                            if (new Date(Data['start_date']).getTime() > new Date(0).getTime() && new Date(Data['end_date']).getTime() > new Date(0).getTime()) {

                                 if (new Date(Data['start_date']).getTime() >= new Date(calendar['start-date']).getTime() && new Date(Data['end_date']).getTime() <= new Date(calendar['end-date']).getTime()) {
                                     found = 1;
                                 }
                            } else {
                                if (new Date(Data['start_date']).getTime() > new Date(0).getTime()) { // Display all > start date

                                    if (new Date(Data['start_date']).getTime() >= new Date(calendar['start-date']).getTime()){
                                        found = 1;
                                    }

                                } else if (new Date(Data['end_date']).getTime() > new Date(0).getTime()) { // Display all < end date

                                    if (new Date(Data['end_date']).getTime() <= new Date(calendar['end-date']).getTime()){
                                        found = 1;
                                    }

                                } else { // Display all calendars
                                    found = 1;
                                }
                            }
                        } else {// Hours Calendar
                            var hours = calendar['hours'];
                            
                            
                            if (new Date(Data['start_date']).getTime() > new Date(0).getTime() && new Date(Data['start_date']).getTime() > new Date(0).getTime()){
                                if (new Date(Data['start_date']).getTime() <= new Date(calendar['date']).getTime() && new Date(Data['end_date']).getTime() >= new Date(calendar['date']).getTime()){
                                    console.log(Data['start_hour'],Data['end_hour'],hours);
                                    if (methods_search.checkHour(Data['start_hour'],Data['end_hour'],hours) > 0) {
                                        found = 1;
                                    }
                                }
                            } else if (new Date(Data['start_date']).getTime() > new Date(0).getTime()){
                                if (new Date(Data['start_date']).getTime() <= new Date(calendar['date']).getTime()){
                                    if (methods_search.checkHour(Data['start_hour'],Data['end_hour'],hours) > 0) {
                                        found = 1;
                                    }
                                }
                                
                            } else if(new Date(Data['end_date']).getTime() > new Date(0).getTime()){
                                if (new Date(Data['end_date']).getTime() >= new Date(calendar['date']).getTime()){
                                    if (methods_search.checkHour(Data['start_hour'],Data['end_hour'],hours) > 0) {
                                        found = 1;
                                    }
                                }
                            } else {
                                if (methods_search.checkHour(Data['start_hour'],Data['end_hour'],hours) > 0) {
                                    found = 1;
                                }
                            }
                        }
                        
                    }
                    
                });
                
                return found;
                
             },
             displayCalendar: function(calendarData){
                var calendarHTML = new Array();

                calendarHTML.push('<li>');
                calendarHTML.push(' <img src="'+calendarData['calendar_image']+'" class="DOPBSPSearch-Result-image"/>');
                calendarHTML.push(' <div class="DOPBSPSearch-Result-title">'+calendarData['calendar_name']+'</div>');
                calendarHTML.push(' <div class="DOPBSPSearch-Result-rating">'+prototypes.getRate(calendarData['calendar_rating'])+'</div>');
                calendarHTML.push(' <div class="DOPBSPSearch-Result-start">'+calendarData['calendar_start_text']+' <span class="start-price">'+calendarData['calendar_min_price']+calendarData['calendar_currency_code']+'</span></div>');
                calendarHTML.push(' <div class="DOPBSPSearch-Result-description">'+calendarData['calendar_description']+'</div>');
                calendarHTML.push(' <a href="'+calendarData['calendar_link']+'" class="DOPBSPSearch-Result-view">'+calendarData['calendar_view_text']+'</div>');
                calendarHTML.push('</li>');
                
                $('#DOPBSPSearch-Results').append(calendarHTML.join(''));
             },
            changePage: function(page){
                $('#DOPBSP_curr_page').val(page);
                // Display
                methods_search.display();
            }
         };
         
         // Init Search
         methods_search.Init();
         
         // Display
         methods_search.display();
};
})(jQuery);