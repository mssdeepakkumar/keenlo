
/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/jquery.dop.backend.BSPReservationsCalendar.js
* File Version            : 1.0
* Created / Last Modified : 09 February 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end reservations calendar jQuery plugin plugin.
*/

(function($){
    $.fn.DOPBookingSystemPROReservations = function(options){
        var Data = {'AddtMonthViewText': 'Add Month View',
                    'AdultsLabel': 'Adults',
                    'ButtonApproveLabel': 'Approve',
                    'ButtonCancelLabel': 'Cancel',
                    'ButtonCloseLabel': 'Close',
                    'ButtonDeleteLabel': 'Delete',
                    'ButtonJumpToDayLabel': 'Jump to day',
                    'ButtonRejectLabel': 'Reject',
                    'CheckInLabel': 'Check In',
                    'CheckOutLabel': 'Check Out',
                    'ChildrenLabel': 'Children',
                    'ClikToEditLabel': 'Click to edit the reservations',
                    'Currency': '$',
                    'DateCreatedLabel': 'Date Created',
                    'DateType': 1,
                    'DayNames': ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                    'DepositLabel': 'Deposit',
                    'DiscountLabel': 'Discount',
                    'DiscountInfoLabel': 'discount',
                    'FirstDay': 1,
                    'HourEndLabel': 'End Hour',
                    'HoursAMPM': false,
                    'HoursEnabled': false,
                    'HourStartLabel': 'Start Hour',
                    'ID': 0,
                    'MonthNames': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    'NextMonthText': 'Next Month',
                    'NoItemsLabel': 'No Items',
                    'PaymentMethodLabel': 'Payment Method',
                    'PeopleLabel': 'People',
                    'PreviousMonthText': 'Previous Month',
                    'PriceLabel': 'Price',
                    'Reinitialize': true,
                    'RemoveMonthViewText': 'Remove Month View',
                    'StatusApprovedLabel': 'Approved',
                    'StatusCanceledLabel': 'Canceled',
                    'StatusExpiredLabel': 'Expired',
                    'StatusLabel': 'Status',
                    'StatusPendingLabel': 'Pending',
                    'StatusRejectedLabel': 'Rejected',
                    'TransactionIDLabel': 'Transaction ID'},
        Container = this,

        ReservationsData = new Array(),
        Reservations = new Array(),

        StartDate = new Date(),
        StartYear = StartDate.getFullYear(),
        StartMonth = StartDate.getMonth()+1,
        StartDay = StartDate.getDate(),
        CurrYear = StartYear,
        CurrMonth = StartMonth,

        AddtMonthViewText = 'Add Month View',
        AdultsLabel = 'Adults',
        ButtonApproveLabel = 'Approve',
        ButtonCancelLabel = 'Cancel',
        ButtonCloseLabel = 'Close',
        ButtonDeleteLabel = 'Delete',
        ButtonJumpToDayLabel = 'Jump to day',
        ButtonRejectLabel = 'Reject',
        CheckInLabel = 'Check In',
        CheckOutLabel = 'Check Out',
        ChildrenLabel = 'Children',
        ClikToEditLabel = 'Click to edit the reservations',
        Currency = '$',
        DateCreatedLabel = 'Date Created',
        DateType = 1,
        DayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        DepositLabel = 'Deposit',
        DiscountLabel = 'Discount',
        DiscountInfoLabel = 'discount',
        FirstDay = 1,
        HourEndLabel = 'End Hour',
        HoursAMPM = false,
        HoursEnabled = false,
        HourStartLabel = 'Start Hour',
        ID = 0,
        LeftToPayLabel = 'Left to pay',
        MonthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        NextMonthText = 'Next Month',
        NoItemsLabel = 'No Items',
        PaymentMethodLabel = 'Payment Method',
        PeopleLabel = 'People',
        PreviousMonthText = 'Previous Month',
        PriceLabel = 'Price',
        RemoveMonthViewText = 'Remove Month View',
        StatusApprovedLabel = 'Approved',
        StatusCanceledLabel = 'Canceled',
        StatusExpiredLabel = 'Expired',
        StatusLabel = 'Status',
        StatusPendingLabel = 'Pending',
        StatusRejectedLabel = 'Rejected',
        TransactionIDLabel = 'Transaction ID',
        
        noMonths = 1,
        dayNo = 0,
        currentReservation = 0,
        currentReservationID = 0,
        
        infoXPos = 0,
        infoYPos = 0,
        
        methods = {            
                    init:function( ){// Init Plugin.
                        return this.each(function(){
                            if (options){
                                $.extend(Data, options);
                            }
                            
                            if (!$(Container).hasClass('dopbsp-initialized') 
                                    || Data['Reinitialize']){
                                $(Container).addClass('dopbsp-initialized');
                                methods.parseData();
                            }
                        });
                    },
                    parseData:function(){
                        AddtMonthViewText = Data['AddtMonthViewText'];
                        AdultsLabel = Data['AdultsLabel'];
                        ButtonApproveLabel = Data['ButtonApproveLabel'];
                        ButtonCancelLabel = Data['ButtonCancelLabel'];
                        ButtonCloseLabel = Data['ButtonCloseLabel'];
                        ButtonDeleteLabel = Data['ButtonDeleteLabel'];
                        ButtonJumpToDayLabel = Data['ButtonJumpToDayLabel'];
                        ButtonRejectLabel = Data['ButtonRejectLabel'];
                        CheckInLabel = Data['CheckInLabel'];
                        CheckOutLabel = Data['CheckOutLabel'];
                        ChildrenLabel = Data['ChildrenLabel'];
                        ClikToEditLabel = Data['ClikToEditLabel'];
                        Currency = Data['Currency'];
                        DateCreatedLabel = Data['DateCreatedLabel'];
                        DateType = parseInt(Data['DateType'], 10);
                        DayNames = Data['DayNames'];
                        DepositLabel = Data['DepositLabel'],
                        DiscountLabel = Data['DiscountLabel'],
                        DiscountInfoLabel = Data['DiscountInfoLabel'],
                        FirstDay = Data['FirstDay'];
                        HourEndLabel = Data['HourEndLabel'];
                        HoursAMPM = Data['HoursAMPM'] === 'true' ? true:false;
                        HoursEnabled = Data['HoursEnabled'] === 'true' ? true:false;
                        HourStartLabel = Data['HourStartLabel'];
                        ID = Data['ID'];
                        LeftToPayLabel = Data['LeftToPayLabel'],
                        MonthNames = Data['MonthNames'];
                        NextMonthText = Data['NextMonthText'];
                        NoItemsLabel = Data['NoItemsLabel'];
                        PaymentMethodLabel = 'Payment Method',
                        PeopleLabel = Data['PeopleLabel'];
                        PreviousMonthText = Data['PreviousMonthText'];
                        PriceLabel = Data['PriceLabel'];
                        RemoveMonthViewText = Data['RemoveMonthViewText'];
                        StatusApprovedLabel = Data['StatusApprovedLabel'];
                        StatusCanceledLabel = Data['StatusCanceledLabel'];
                        StatusExpiredLabel = Data['StatusExpiredLabel'];
                        StatusLabel = Data['StatusLabel'];
                        StatusPendingLabel = Data['StatusPendingLabel'];
                        StatusRejectedLabel = Data['StatusRejectedLabel'];
                        TransactionIDLabel = Data['TransactionIDLabel'];
                        
                        methods.parseCalendarData();
                    },
                    parseCalendarData:function(){
                        $.post(ajaxurl, {action: 'dopbsp_get_calendar_reservations',
                                         calendar_id: ID}, function(data){
                            if ($.trim(data) !== ''){
                                ReservationsData = JSON.parse($.trim(data));
                            }
                            
                            DOPBSPReservations.toggleMessages('hide', '');
                            methods.initCalendar();
                        });
                    },

                    initCalendar:function(){// Init  Calendar
                        var HTML = new Array(), 
                        no;
                        
                        HTML.push('<div class="DOPBookingSystemPROReservations_Container">');                        
                        HTML.push('    <div class="DOPBookingSystemPROReservations_Navigation">');
                        HTML.push('        <div class="add_btn" title="'+AddtMonthViewText+'"></div>');                        
                        HTML.push('        <div class="remove_btn" title="'+RemoveMonthViewText+'"></div>');
                        HTML.push('        <div class="previous_btn" title="'+PreviousMonthText+'"></div>');
                        HTML.push('        <div class="next_btn" title="'+NextMonthText+'"></div>');
                        HTML.push('        <div class="month_year"></div>');
                        HTML.push('        <table class="week">');
                        HTML.push('            <tr>');
                        HTML.push('                <td class="day"></td>');
                        HTML.push('                <td class="day"></td>');
                        HTML.push('                <td class="day"></td>');
                        HTML.push('                <td class="day"></td>');
                        HTML.push('                <td class="day"></td>');
                        HTML.push('                <td class="day"></td>');
                        HTML.push('                <td class="day"></td>');
                        HTML.push('            </tr>');
                        HTML.push('        </table>');
                        HTML.push('    </div>');
                        HTML.push('    <div class="DOPBookingSystemPROReservations_Calendar"></div>');
                        HTML.push('</div>');
                        
                        Container.html(HTML.join(''));
                        $('#DOPBookingSystemPROReservations_Info'+ID).remove();
                        $('body').append('<div class="DOPBookingSystemPROReservations_Info" id="DOPBookingSystemPROReservations_Info'+ID+'"></div>');
                        
                        no = FirstDay-1;
                        
                        $('.DOPBookingSystemPROReservations_Navigation .week .day', Container).each(function(){
                            no++;
                            
                            if (no === 7){
                                no = 0;
                            }
                            $(this).html(DayNames[no]);
                        });
                        
                        methods.initSettings();
                    },
                    initSettings:function(){// Init  Settings
                        methods.initFilters();
                        methods.initNavigation();
                        methods.initInfo();
                        methods.initReservations();
                    },
                    initFilters:function(){// Init Filters
                        // Actions
                        $('#DOPBSP-reset-reservations-filter').unbind('click');
                        $('#DOPBSP-reset-reservations-filter').bind('click', function(){
                            methods.resetFilters();
                        });
                        
                        // Period Filters
                        if (HoursEnabled){
                            $('#DOPBSP-reservations-start-hour').unbind('change');
                            $('#DOPBSP-reservations-start-hour').bind('change', function(){
                                $('#DOPBSP-reservations-end-hour').html('');
                                
                                $('#DOPBSP-reservations-start-hour option').each(function(){
                                    if ($(this).attr('value') >= $('#DOPBSP-reservations-start-hour').val()){
                                        $('#DOPBSP-reservations-end-hour').append('<option value="'+$(this).attr('value')+'">'+$(this).html()+'</option>');
                                    }
                                });
                                $('#DOPBSP-reservations-end-hour [value="24:00"]').attr('selected', 'selected');
                                
                                methods.showReservations();
                            });
                        
                            $('#DOPBSP-reservations-end-hour').unbind('change');
                            $('#DOPBSP-reservations-end-hour').bind('change', function(){
                                methods.showReservations();
                            });
                        }
                        
                        // Status Filters
                        $('#DOPBSP-reservations-pending').unbind('click');
                        $('#DOPBSP-reservations-pending').bind('click', function(){
                            methods.showReservations();
                        });
                        
                        $('#DOPBSP-reservations-approved').unbind('click');
                        $('#DOPBSP-reservations-approved').bind('click', function(){
                            methods.showReservations();
                        });
                        
                        $('#DOPBSP-reservations-rejected').unbind('click');
                        $('#DOPBSP-reservations-rejected').bind('click', function(){
                            methods.showReservations();
                        });
                        
                        $('#DOPBSP-reservations-canceled').unbind('click');
                        $('#DOPBSP-reservations-canceled').bind('click', function(){
                            methods.showReservations();
                        });
                        
                        // Payment Filters
                        $('#DOPBSP-reservations-payment-none').unbind('click');
                        $('#DOPBSP-reservations-payment-none').bind('click', function(){
                            methods.showReservations();
                        });    

                        $('#DOPBSP-reservations-payment-arrival').unbind('click');
                        $('#DOPBSP-reservations-payment-arrival').bind('click', function(){
                            methods.showReservations();
                        });

                        $('#DOPBSP-reservations-payment-paypal').unbind('click');
                        $('#DOPBSP-reservations-payment-paypal').bind('click', function(){
                            methods.showReservations();
                        });
                    },
                    resetFilters:function(){
                        // Period    
                        $('#DOPBSP-reservations-start-hour [value="00:00"]').attr('selected', 'selected');
                        $('#DOPBSP-reservations-end-hour [value="24:00"]').attr('selected', 'selected');

                        // Status
                        $('#DOPBSP-reservations-pending').removeAttr('checked');
                        $('#DOPBSP-reservations-approved').removeAttr('checked');
                        $('#DOPBSP-reservations-rejected').removeAttr('checked');
                        $('#DOPBSP-reservations-canceled').removeAttr('checked');
                        $('#DOPBSP-reservations-expired').removeAttr('checked');

                        // Payment
                        $('#DOPBSP-reservations-payment-none').removeAttr('checked');
                        $('#DOPBSP-reservations-payment-arrival').removeAttr('checked');
                        $('#DOPBSP-reservations-payment-paypal').removeAttr('checked');

                        methods.showReservations();
                    },
                    initNavigation:function(){// Init Navigation
                        if (!DOPPrototypes.isTouchDevice()){
                            $('.DOPBookingSystemPROReservations_Navigation .previous_btn', Container).hover(function(){
                                $(this).addClass('hover');
                            }, function(){
                                $(this).removeClass('hover');
                            });

                            $('.DOPBookingSystemPROReservations_Navigation .next_btn', Container).hover(function(){
                                $(this).addClass('hover');
                            }, function(){
                                $(this).removeClass('hover');
                            });

                            $('.DOPBookingSystemPROReservations_Navigation .add_btn', Container).hover(function(){
                                $(this).addClass('hover');
                            }, function(){
                                $(this).removeClass('hover');
                            });

                            $('.DOPBookingSystemPROReservations_Navigation .remove_btn', Container).hover(function(){
                                $(this).addClass('hover');
                            }, function(){
                                $(this).removeClass('hover');
                            });
                        }
                        
                        $('.DOPBookingSystemPROReservations_Navigation .previous_btn', Container).click(function(){
                            methods.generateCalendar(StartYear, CurrMonth-1);

                            if (CurrMonth === StartMonth){
                                $('.DOPBookingSystemPROReservations_Navigation .previous_btn', Container).css('display', 'none');
                            }
                        });
                        
                        $('.DOPBookingSystemPROReservations_Navigation .next_btn', Container).click(function(){
                            methods.generateCalendar(StartYear, CurrMonth+1);
                            $('.DOPBookingSystemPROReservations_Navigation .previous_btn', Container).css('display', 'block');
                        });
                        
                        $('.DOPBookingSystemPROReservations_Navigation .add_btn', Container).click(function(){
                            noMonths++;
                            methods.generateCalendar(StartYear, CurrMonth);
                            $('.DOPBookingSystemPROReservations_Navigation .remove_btn', Container).css('display', 'block');
                        });
                        
                        
                        $('.DOPBookingSystemPROReservations_Navigation .remove_btn', Container).click(function(){
                            noMonths--;
                            methods.generateCalendar(StartYear, CurrMonth);
                            
                            if(noMonths === 1){
                                $('.DOPBookingSystemPROReservations_Navigation .remove_btn', Container).css('display', 'none');
                            }
                        });
                    },
                    initReservations:function(){
                        var i;
                        
                        for (i=0; i<ReservationsData.length; i++){
                            ReservationsData[i].level = 0;
                            ReservationsData[i].info = ReservationsData[i].info === '' ? new Array():JSON.parse(ReservationsData[i].info);
                        }
                        
                        methods.showReservations();
                    },
                    showReservations:function(){
                        var i, 
                        isOK = false,
                        showStartHour = $('#DOPBSP-reservations-start-hour').val(),
                        showEndHour = $('#DOPBSP-reservations-end-hour').val(),
                        showPending = $('#DOPBSP-reservations-pending').is(':checked') ? true:false,
                        showApproved = $('#DOPBSP-reservations-approved').is(':checked') ? true:false,
                        showRejected = $('#DOPBSP-reservations-rejected').is(':checked') ? true:false,
                        showCanceled = $('#DOPBSP-reservations-canceled').is(':checked') ? true:false,
                        showPaymentNone = $('#DOPBSP-reservations-payment-none').is(':checked') ? true:false,
                        showPaymentArrival = $('#DOPBSP-reservations-payment-arrival').is(':checked') ? true:false,
                        showPaymentPayPal = $('#DOPBSP-reservations-payment-paypal').is(':checked') ? true:false;
                        
                        if (!showPending 
                                && !showApproved 
                                && !showRejected 
                                && !showCanceled){
                            showPending = true;
                            showApproved = true;
                            showRejected = true;
                            showCanceled = true;
                        }
                        
                        if (!showPaymentNone 
                                && !showPaymentArrival 
                                && !showPaymentPayPal){
                            showPaymentNone = true;
                            showPaymentArrival = true;
                            showPaymentPayPal = true;
                        }
                        
                        Reservations = [];
                        
                        for (i=0; i<ReservationsData.length; i++){
                            isOK = true;
                            
                            if (HoursAMPM 
                                    && (ReservationsData[i]['end_hour'] < showStartHour 
                                            || showEndHour < ReservationsData[i]['start_hour'])){
                                isOK = false;
                            }
                            
                            switch (ReservationsData[i]['status']){
                                case 'pending':
                                    if (!showPending){
                                        isOK = false;
                                    }
                                    break;
                                case 'approved':
                                    if (!showApproved){
                                        isOK = false;
                                    }
                                    break;
                                case 'rejected':
                                    if (!showRejected){
                                        isOK = false;
                                    }
                                    break;
                                case 'canceled':
                                    if (!showCanceled){
                                        isOK = false;
                                    }
                                    break;
                            }
                            
                            switch (ReservationsData[i]['payment_method']){
                                case '0':
                                    if (!showPaymentNone){
                                        isOK = false;
                                    }
                                    break;
                                case '1':
                                    if (!showPaymentArrival){
                                        isOK = false;
                                    }
                                    break;
                                case '2':
                                    if (!showPaymentPayPal){
                                        isOK = false;
                                    }
                                    break;
                            }
                            
                            if (isOK){
                                Reservations.push(ReservationsData[i]);
                            }
                        }
                        
                        for (i=0; i<Reservations.length; i++){
                            Reservations[i]['level'] = 0;
                        }
                        
                        methods.generateCalendar(StartYear, CurrMonth);
                    },
                    
                    generateCalendar:function(year, month){// Init Calendar   
                        var i;
                        
                        CurrYear = new Date(year, month, 0).getFullYear();
                        CurrMonth = parseInt(month, 10);    
                                                
                        $('.DOPBookingSystemPROReservations_Navigation .month_year', Container).html(MonthNames[(CurrMonth%12 !== 0 ? CurrMonth%12:12)-1]+' '+CurrYear);                        
                        $('.DOPBookingSystemPROReservations_Calendar', Container).html('');                        
                        
                        for (i=1; i<=noMonths; i++){
                            methods.initMonth(CurrYear, month = month%12 !== 0 ? month%12:12, i);
                            month++;
                            
                            if (month % 12 === 1){
                                CurrYear++;
                                month = 1;
                            }                            
                        }
                    },
                    initMonth:function(year, month, position){// Init Month
                        var i, 
                        d, 
                        cyear, 
                        cmonth, 
                        cday, 
                        start, 
                        totalDays = 0,
                        noDays = new Date(year, month, 0).getDate(),
                        noDaysPreviousMonth = new Date(year, month-1, 0).getDate(),
                        firstDay = new Date(year, month-1, 2-FirstDay).getDay(),
                        lastDay = new Date(year, month-1, noDays-FirstDay+1).getDay(),
                        monthHTML = new Array();
                                 
                        dayNo = 0;
                        
                        monthHTML.push('<table class="DOPBookingSystemPROReservations_Month">');
                        monthHTML.push('    <tbody>');
                        
                        if (position > 1){
                            monthHTML.push('<div class="month_year">'+MonthNames[(month%12 !== 0 ? month%12:12)-1]+' '+year+'</div>');
                        }
                                                
                        if (firstDay === 0){
                            start = 7;
                        }
                        else{
                            start = firstDay;
                        }
                        
                        for (i=start-1; i>=1; i--){
                            totalDays++;
                            
                            d = new Date(year, month-2, noDaysPreviousMonth-i+1);
                            cyear = d.getFullYear();
                            cmonth = DOPPrototypes.getLeadingZero(d.getMonth()+1);
                            cday = DOPPrototypes.getLeadingZero(d.getDate());
                            
                            if (StartYear === year 
                                    && StartMonth === month){
                                monthHTML.push(methods.initDay('past_day', 
                                                               ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                               d.getDate()));            
                            }
                            else{
                                monthHTML.push(methods.initDay('last_month'+(position>1 ?  ' mask':''), 
                                                               position > 1 ? ID+'_'+cyear+'-'+cmonth+'-'+cday+'_last':ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                               d.getDate()));
                            }
                        }
                        
                        for (i=1; i<=noDays; i++){
                            totalDays++;
                            
                            d = new Date(year, month-1, i);
                            cyear = d.getFullYear();
                            cmonth = DOPPrototypes.getLeadingZero(d.getMonth()+1);
                            cday = DOPPrototypes.getLeadingZero(d.getDate());
                            
                            if (StartYear === year 
                                    && StartMonth === month 
                                    && StartDay > d.getDate()){
                                monthHTML.push(methods.initDay('past_day', 
                                                               ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                               d.getDate()));    
                            }
                            else{
                                monthHTML.push(methods.initDay('curr_month', 
                                                               ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                               d.getDate()));
                            }
                        }

                        if (totalDays+7 < 42){
                            for (i=1; i<=14-lastDay; i++){
                                d = new Date(year, month, i);
                                cyear = d.getFullYear();
                                cmonth = DOPPrototypes.getLeadingZero(d.getMonth()+1);
                                cday = DOPPrototypes.getLeadingZero(d.getDate());
                            
                                monthHTML.push(methods.initDay('next_month'+(position<noMonths ?  ' hide':''), 
                                                               position<noMonths ? ID+'_'+cyear+'-'+cmonth+'-'+cday+'_next':ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                               d.getDate()));
                            }
                        }
                        else{
                            for (i=1; i<=7-lastDay; i++){
                                d = new Date(year, month, i);
                                cyear = d.getFullYear();
                                cmonth = DOPPrototypes.getLeadingZero(d.getMonth()+1);
                                cday = DOPPrototypes.getLeadingZero(d.getDate());
                                
                                monthHTML.push(methods.initDay('next_month'+(position<noMonths ?  ' hide':''), 
                                                               position < noMonths ? ID+'_'+cyear+'-'+cmonth+'-'+cday+'_next':ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                               d.getDate()));
                            }
                        }

                        monthHTML.push('    </tbody>');
                        monthHTML.push('</table>');
                        
                        $('.DOPBookingSystemPROReservations_Calendar', Container).append(monthHTML.join(''));
                        
                        methods.initDayEvents();
                    },
                    
                    initDay:function(type, id, day){// Init Day
                        var i, 
                        j, 
                        k, 
                        dayHTML = Array(),
                        date = id.split('_')[1],
                        blocks = new Array(),
                        levels = new Array(),
                        info = '';
                        
                        dayNo++;
                        
                        for (i=0; i<(Reservations.length > 5 ? Reservations.length:5); i++){
                            levels[i] = false;
                            blocks[i] = '<div class="block">';
                            blocks[i] += '<div class="bind-left"></div>';
                            blocks[i] += '<div class="bind-content"></div>';
                            blocks[i] += '<div class="bind-right"></div>';
                            blocks[i] += '</div>';
                        }
                        
                        if (dayNo % 7 === 1){
                            dayHTML.push('<tr>');
                        }                       
                        dayHTML.push('<td class="DOPBookingSystemPROReservations_Day '+type+'" id="reservations_'+id+'">');
                        dayHTML.push('  <div class="header">'+day+'</div>');
                        dayHTML.push('  <div class="content">');
                        
                        for (i=0; i<Reservations.length; i++){
                            info = Reservations[i]['start_hour'] === '' ? '':(HoursAMPM ? DOPPrototypes.getAMPM(Reservations[i]['start_hour']):Reservations[i]['start_hour']);
                            info += Reservations[i]['end_hour'] === '' ? '':'-'+(HoursAMPM ? DOPPrototypes.getAMPM(Reservations[i]['end_hour']):Reservations[i]['end_hour']);
                            
                            for (k=0; k<Reservations[i]['info'].length; k++){
                                info += ' '+Reservations[i]['info'][k]['value'];
                            }
                            
                            if ((Reservations[i]['check_in'] <= date 
                                            && date <= Reservations[i]['check_out']) 
                                    || (Reservations[i]['check_in'] === date 
                                            && Reservations[i]['check_out'] === '')){
                                if (Reservations[i]['level'] === 0){
                                    for (j=0; j<Reservations.length; j++){
                                        if (!levels[j]){
                                            levels[j] = true;
                                            Reservations[i]['level'] = j;
                                            
                                            blocks[j] = '';
                                            blocks[j] += '<div class="block">';
                                            blocks[j] += '<div class="bind-left '+(Reservations[i]['check_in'] < date ? 'reservation-block-'+Reservations[i]['id']+' '+Reservations[i]['status']:'')+'" id="reservations_'+id+'_left_'+i+'"></div>';
                                            blocks[j] += '<div class="bind-content reservation-block-'+Reservations[i]['id']+' '+Reservations[i]['status']+'" id="reservations_'+id+'_content_'+i+'">'+(Reservations[i]['check_in'] === date ? info:'')+'</div>';
                                            blocks[j] += '<div class="bind-right '+(date < Reservations[i]['check_out'] ? 'reservation-block-'+Reservations[i]['id']+' '+Reservations[i]['status']:'')+'" id="reservations_'+id+'_right_'+i+'"></div>';
                                            blocks[j] += '</div>';
                                            break;
                                        }
                                    }
                                }
                                else{
                                    levels[Reservations[i]['level']] = true;
                                    blocks[Reservations[i]['level']] = '';
                                    blocks[Reservations[i]['level']] += '<div class="block">';
                                    blocks[Reservations[i]['level']] += '<div class="bind-left '+(Reservations[i]['check_in'] < date ? 'reservation-block-'+Reservations[i]['id']+' '+Reservations[i]['status']:'')+'" id="reservations_'+id+'_left_'+i+'"></div>';
                                    blocks[Reservations[i]['level']] += '<div class="bind-content reservation-block-'+Reservations[i]['id']+' '+Reservations[i]['status']+'" id="reservations_'+id+'_left_'+i+'">'+(Reservations[i]['check_in'] === date ? info:'')+'</div>';
                                    blocks[Reservations[i]['level']] += '<div class="bind-right '+(date < Reservations[i]['check_out'] ? 'reservation-block-'+Reservations[i]['id']+' '+Reservations[i]['status']:'')+'" id="reservations_'+id+'_left_'+i+'"></div>';
                                    blocks[Reservations[i]['level']] += '</div>';
                                }
                            }
                        }
                        
                        for (i=blocks.length; i>=5; i--){
                            if (!levels[i]){
                                blocks.splice(i, 1);
                            }
                            else{
                                break;
                            }
                        }
                        
                        dayHTML.push(blocks.join(''));
                        dayHTML.push('  </div>');
                        dayHTML.push('</td>');
                        
                        if (dayNo % 7 === 0){
                            dayHTML.push('</tr>');
                        }
                        
                        return dayHTML.join('');
                    },                    
                    initDayEvents:function(){// Init Events for the days of the Calendar.
                        $('.DOPBookingSystemPROReservations_Day .bind-left.pending,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.pending,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.pending,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.approved,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.approved,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.approved,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.rejected,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.rejected,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.rejected,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.canceled,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.canceled,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.canceled,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.expired,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.expired,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.expired', Container).hover(function(){
                            if (!$('#DOPBookingSystemPROReservations_Info'+ID).hasClass('is-editable')){
                                methods.showInfo(parseInt($(this).attr('id').split('_')[4], 10));
                            }
                        }, function(){
                            methods.hideInfo();
                        });
                        
                        $('.DOPBookingSystemPROReservations_Day .bind-left.pending,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.pending,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.pending,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.approved,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.approved,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.approved,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.rejected,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.rejected,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.rejected,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.canceled,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.canceled,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.canceled,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.expired,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.expired,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.expired', Container).unbind('click');
                        $('.DOPBookingSystemPROReservations_Day .bind-left.pending,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.pending,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.pending,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.approved,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.approved,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.approved,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.rejected,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.rejected,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.rejected,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.canceled,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.canceled,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.canceled,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.expired,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.expired,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.expired', Container).bind('click', function(){
                            if (!$('#DOPBookingSystemPROReservations_Info'+ID).hasClass('is-editable')){
                                $('#DOPBookingSystemPROReservations_Info'+ID).addClass('is-editable');
                            }
                            else{
                                $('#DOPBookingSystemPROReservations_Info'+ID).removeClass('is-editable');
                            }
                            methods.showInfo(parseInt($(this).attr('id').split('_')[4], 10));
                            methods.moveInfo();
                        });
                    },
                    
                    initInfo:function(){
                        $(document).mousemove(function(e){
                            infoXPos = e.pageX+30;
                            infoYPos = e.pageY;

                            if ($(window).width() < infoXPos+$('#DOPBookingSystemPROReservations_Info'+ID).width()+parseInt($('#DOPBookingSystemPROReservations_Info'+ID).css('padding-left'))+parseInt($('#DOPBookingSystemPROReservations_Info'+ID).css('padding-right'))){
                                infoXPos = infoXPos-$('#DOPBookingSystemPROReservations_Info'+ID).width()-parseInt($('#DOPBookingSystemPROReservations_Info'+ID).css('padding-left'))-parseInt($('#DOPBookingSystemPROReservations_Info'+ID).css('padding-right'))-60;
                            }

                            if ($(document).scrollTop()+$(window).height() < infoYPos+$('#DOPBookingSystemPROReservations_Info'+ID).height()+parseInt($('#DOPBookingSystemPROReservations_Info'+ID).css('padding-top'))+parseInt($('#DOPBookingSystemPROReservations_Info'+ID).css('padding-bottom'))+10){
                                infoYPos = $(document).scrollTop()+$(window).height()-$('#DOPBookingSystemPROReservations_Info'+ID).height()-parseInt($('#DOPBookingSystemPROReservations_Info'+ID).css('padding-top'))-parseInt($('#DOPBookingSystemPROReservations_Info'+ID).css('padding-bottom'))-10;
                            }
                            
                            methods.moveInfo();
                        }); 
                    },
                    moveInfo:function(){
                        if (!$('#DOPBookingSystemPROReservations_Info'+ID).hasClass('is-editable')){
                            $('#DOPBookingSystemPROReservations_Info'+ID).css({'left': infoXPos, 'top': infoYPos});
                        }
                    },
                    showInfo:function(reservationNo){
                        var HTML = new Array(), 
                        i, 
                        j, 
                        status, 
                        value,
                        approveEvent = false,
                        rejectEvent = false,
                        cancelEvent = false,
                        deleteEvent = false,
                        jumpEvent = false,
                        dcHourFull = Reservations[reservationNo]['date_created'].split(' ')[1],
                        dcHour = dcHourFull.split(':')[0]+':'+dcHourFull.split(':')[1],
                        dcDate = Reservations[reservationNo]['date_created'].split(' ')[0],
                        dcYear = dcDate.split('-')[0],
                        dcMonth = dcDate.split('-')[1],
                        dcMonthText = MonthNames[parseInt(dcMonth, 10)-1],
                        dcDay = dcDate.split('-')[2],
                        ciYear = Reservations[reservationNo]['check_in'].split('-')[0],
                        ciMonth = Reservations[reservationNo]['check_in'].split('-')[1],
                        ciMonthText = MonthNames[parseInt(ciMonth, 10)-1],
                        ciDay = Reservations[reservationNo]['check_in'].split('-')[2],
                        coYear = Reservations[reservationNo]['check_out'] !== '' ? Reservations[reservationNo]['check_out'].split('-')[0]:'',
                        coMonth = Reservations[reservationNo]['check_out'] !== '' ? Reservations[reservationNo]['check_out'].split('-')[1]:'',
                        coMonthText = Reservations[reservationNo]['check_out'] !== '' ? MonthNames[parseInt(coMonth, 10)-1]:'',
                        coDay = Reservations[reservationNo]['check_out'] !== '' ? Reservations[reservationNo]['check_out'].split('-')[2]:'';
                        
                        switch (Reservations[reservationNo]['status']){
                            case 'pending':
                                status = StatusPendingLabel;
                                break;
                            case 'approved':
                                status = StatusApprovedLabel;
                                break;
                            case 'rejected':
                                status = StatusRejectedLabel;
                                break;
                            case 'canceled':
                                status = StatusCanceledLabel;
                                break;
                            default:
                                status = StatusExpiredLabel;
                        }
                        
                        HTML.push('<div class="info-container">');
                        HTML.push('     <label>ID</label>');
                        HTML.push('     <div class="value">'+Reservations[reservationNo]['id']+'</div>');
                        HTML.push('     <br class="DOPBSP-clear" />');
                        HTML.push('</div>');
                        HTML.push('<div class="info-container">');
                        HTML.push('     <label>'+StatusLabel+'</label>');
                        HTML.push('     <div class="value">'+status+'</div>');
                        HTML.push('     <br class="DOPBSP-clear" />');
                        HTML.push('</div>');
                        HTML.push('<div class="info-container">');
                        HTML.push('     <label>'+DateCreatedLabel+'</label>');
                        HTML.push('     <div class="value">'+(DateType === 1 ? dcMonthText+' '+dcDay+', '+dcYear:dcDay+' '+dcMonthText+' '+dcYear)+' '+(HoursAMPM ? DOPPrototypes.getAMPM(dcHour):dcHour)+'</div>');
                        HTML.push('     <br class="DOPBSP-clear" />');
                        HTML.push('</div>');
                        HTML.push('<br />');
                        
                        HTML.push('<div class="info-container">');
                        HTML.push('     <label>'+CheckInLabel+'</label>');
                        HTML.push('     <div class="value">'+(DateType === 1 ? ciMonthText+' '+ciDay+', '+ciYear:ciDay+' '+ciMonthText+' '+ciYear)+'</div>');
                        HTML.push('     <br class="DOPBSP-clear" />');
                        HTML.push('</div>');
                        
                        if (Reservations[reservationNo]['check_out'] !== ''){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+CheckOutLabel+'</label>');
                            HTML.push('     <div class="value">'+(DateType === 1 ? coMonthText+' '+coDay+', '+coYear:coDay+' '+coMonthText+' '+coYear)+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        
                        if (Reservations[reservationNo]['start_hour'] !== ''){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+HourStartLabel+'</label>');
                            HTML.push('     <div class="value">'+(HoursAMPM ? DOPPrototypes.getAMPM(Reservations[reservationNo]['start_hour']):Reservations[reservationNo]['start_hour'])+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        
                        if (Reservations[reservationNo]['end_hour'] !== ''){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+HourEndLabel+'</label>');
                            HTML.push('     <div class="value">'+(HoursAMPM ? DOPPrototypes.getAMPM(Reservations[reservationNo]['end_hour']):Reservations[reservationNo]['end_hour'])+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        HTML.push('<br />');
                        
                        if (Reservations[reservationNo]['payment_method'] !== '0'){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+PaymentMethodLabel+'</label>');
                            HTML.push('     <div class="value">'+(Reservations[reservationNo]['payment_method'] === '1' ? 'Arrival':'PayPal')+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        
                        if (Reservations[reservationNo]['paypal_transaction_id'] !== ''){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+TransactionIDLabel+'</label>');
                            HTML.push('     <div class="value">'+Reservations[reservationNo]['paypal_transaction_id']+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        
//                        if (NoItemsEnabled){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+NoItemsLabel+'</label>');
                            HTML.push('     <div class="value">'+Reservations[reservationNo]['no_items']+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
//                        }
                        
                        if (Reservations[reservationNo]['no_people'] !== '' 
                                && parseFloat(Reservations[reservationNo]['no_people']) !== 0){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+(Reservations[reservationNo]['no_children'] === '' ? PeopleLabel:AdultsLabel)+'</label>');
                            HTML.push('     <div class="value">'+Reservations[reservationNo]['no_people']+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        
                        if (Reservations[reservationNo]['no_children'] !== '' 
                                && parseFloat(Reservations[reservationNo]['no_children']) !== 0){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+ChildrenLabel+'</label>');
                            HTML.push('     <div class="value">'+Reservations[reservationNo]['no_children']+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        
                        if (parseFloat(Reservations[reservationNo]['price']) !== 0){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+PriceLabel+'</label>');
                            HTML.push('     <div class="value">'+Currency+DOPPrototypes.getWithDecimals(Reservations[reservationNo]['price'])+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        
                        if (parseFloat(Reservations[reservationNo]['deposit']) !== 0){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+DepositLabel+'</label>');
                            HTML.push('     <div class="value">'+Currency+DOPPrototypes.getWithDecimals(Reservations[reservationNo]['deposit'])+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+LeftToPayLabel+'</label>');
                            HTML.push('     <div class="value">'+Currency+DOPPrototypes.getWithDecimals(Reservations[reservationNo]['price']-Reservations[reservationNo]['deposit'])+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        
                        if (parseFloat(Reservations[reservationNo]['total_price']) !== 0 
                                && parseFloat(Reservations[reservationNo]['total_price']) !== parseFloat(Reservations[reservationNo]['price'])){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+DiscountLabel+'</label>');
                            HTML.push('     <div class="value">'+Currency+DOPPrototypes.getWithDecimals(Reservations[reservationNo]['total_price'])+'('+Reservations[reservationNo]['discount']+' % '+DiscountInfoLabel+')</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        HTML.push('<br />');
                        
                        if (Reservations[reservationNo]['info'].length > 0){
                            for (i=0; i<Reservations[reservationNo]['info'].length; i++){
                                HTML.push('<div class="info-container">');
                                HTML.push('     <label>'+Reservations[reservationNo]['info'][i]['name']+'</label>');
                                HTML.push('     <div class="value">');
                                
                                if (Object.prototype.toString.call(Reservations[reservationNo]['info'][i]['value']) === '[object Array]'){
                                    for (j=0; j<Reservations[reservationNo]['info'][i]['value'].length; j++){
                                        value = Reservations[reservationNo]['info'][i]['value'][j]['translation'];
                                        
                                        if (j === 1){
                                            HTML.push((DOPPrototypes.validEmail(value) ? '<a href="mailto:'+value+'">'+value+'</a>':value)+'</div>');
                                        }
                                        else{
                                            HTML.push(', '+(DOPPrototypes.validEmail(value) ? '<a href="mailto:'+value+'">'+value+'</a>':value)+'</div>');
                                        }
                                    }
                                }
                                else{
                                    if (Reservations[reservationNo]['info'][i]['value'] === 'true'){
                                        value = 'Checked';
                                    }
                                    else if (Reservations[reservationNo]['info'][i]['value'] === 'false'){
                                        value = 'Unchecked';
                                    }
                                    else{
                                        value = Reservations[reservationNo]['info'][i]['value'];
                                    }
                                    HTML.push((DOPPrototypes.validEmail(value) ? '<a href="mailto:'+value+'">'+value+'</a>':value)+'</div>');
                                }
                                HTML.push('     <br class="DOPBSP-clear" />');
                                HTML.push('</div>');
                            }
                        }
                        
                        HTML.push('<div class="instructions-container">['+ClikToEditLabel+']</div>');
                        HTML.push('<div class="buttons-container">');
                        
                        switch (Reservations[reservationNo]['status']){
                            case 'pending':
                                HTML.push('<a href="javascript:void(0)" class="DOPBookingSystemPROReservations_ReservationApprove" id="DOPBookingSystemPROReservations_ReservationApprove'+ID+'">'+ButtonApproveLabel+'</a>');                  
                                HTML.push('<a href="javascript:void(0)" class="DOPBookingSystemPROReservations_ReservationReject" id="DOPBookingSystemPROReservations_ReservationReject'+ID+'">'+ButtonRejectLabel+'</a>');
                                approveEvent = true;
                                rejectEvent = true;
                                jumpEvent = true;
                                break;
                            case 'approved':
                                HTML.push('<a href="javascript:void(0)" class="DOPBookingSystemPROReservations_ReservationCancel" id="DOPBookingSystemPROReservations_ReservationCancel'+ID+'">'+ButtonCancelLabel+'</a>');
                                cancelEvent = true;
                                jumpEvent = true;
                                break;
                            case 'rejected':
                                HTML.push('<a href="javascript:void(0)" class="DOPBookingSystemPROReservations_ReservationApprove" id="DOPBookingSystemPROReservations_ReservationApprove'+ID+'">'+ButtonApproveLabel+'</a>');                  
                                HTML.push('<a href="javascript:void(0)" class="DOPBookingSystemPROReservations_ReservationDelete" id="DOPBookingSystemPROReservations_ReservationDelete'+ID+'">'+ButtonDeleteLabel+'</a>');                  
                                approveEvent = true;
                                deleteEvent = true;
                                jumpEvent = true;
                                break;
                            case 'canceled':
                                HTML.push('<a href="javascript:void(0)" class="DOPBookingSystemPROReservations_ReservationApprove" id="DOPBookingSystemPROReservations_ReservationApprove'+ID+'">'+ButtonApproveLabel+'</a>');                  
                                HTML.push('<a href="javascript:void(0)" class="DOPBookingSystemPROReservations_ReservationDelete" id="DOPBookingSystemPROReservations_ReservationDelete'+ID+'">'+ButtonDeleteLabel+'</a>');                  
                                approveEvent = true;
                                deleteEvent = true;
                                jumpEvent = true;
                                break;
                        }
                        
                        if ($('#DOPBSP-reservations-without-calendar').val() === undefined){
                            HTML.push('<a href="javascript:void(0)" class="DOPBookingSystemPROReservations_ReservationJump" id="DOPBookingSystemPROReservations_ReservationJump'+ID+'">'+ButtonJumpToDayLabel+'</a>');
                        }
                        HTML.push('<a href="javascript:void(0)" class="DOPBookingSystemPROReservations_ReservationClose" id="DOPBookingSystemPROReservations_ReservationClose'+ID+'">'+ButtonCloseLabel+'</a>');
                        HTML.push('</div>');
                        
                        $('#DOPBookingSystemPROReservations_Info'+ID).html(HTML.join(''));
                        methods.initInfoEvents(reservationNo, Reservations[reservationNo]['id'], approveEvent, rejectEvent, cancelEvent, deleteEvent, jumpEvent);
                        $('#DOPBookingSystemPROReservations_Info'+ID).css('display', 'block');                         
                    },
                    initInfoEvents:function(no, id, approve, reject, cancel, delete_e, jump){
                        currentReservation = no;
                        currentReservationID = id;
                        approve = approve === undefined ? false:approve;
                        reject = reject === undefined ? false:reject;
                        cancel = cancel === undefined ? false:cancel;
                        delete_e = delete_e === undefined ? false:delete_e;
                        jump = jump === undefined ? false:jump;
                        
                        if (approve){
                            methods.initApproveReservation();
                        }
                        
                        if (reject){
                            methods.initRejectReservation();
                        }
                        
                        if (cancel){
                            methods.initCancelReservation();
                        }
                        
                        if (delete_e){
                            methods.initDeleteReservation();
                        }
                        
                        if (jump){
                            $('#DOPBookingSystemPROReservations_ReservationJump'+ID).unbind('click');
                            $('#DOPBookingSystemPROReservations_ReservationJump'+ID).bind('click', function(){
                                var i, 
                                checkIn;

                                for (i=0; i<Reservations.length; i++){
                                    if (Reservations[i]['id'] === currentReservationID){
                                        checkIn = Reservations[i]['check_in'];
                                        break;
                                    }
                                }
                                $('#calendar_jump_to_day').val(checkIn);
                            });
                        }
                        
                        $('#DOPBookingSystemPROReservations_ReservationClose'+ID).unbind('click');
                        $('#DOPBookingSystemPROReservations_ReservationClose'+ID).bind('click', function(){
                            $('#DOPBookingSystemPROReservations_Info'+ID).removeClass('is-editable');
                            methods.hideInfo();
                        });
                        
                    },
                    hideInfo:function(){
                        $('#DOPBookingSystemPROReservations_Info'+ID).css('display', 'none');                        
                    },
                    
                    initApproveReservation:function(){   
                        $('#DOPBookingSystemPROReservations_ReservationApprove'+ID).unbind('click');
                        $('#DOPBookingSystemPROReservations_ReservationApprove'+ID).bind('click', function(){
                            if (confirm(DOPBSP.text('RESERVATIONS_APPROVE_CONFIRMATION'))){
                                var wasPending = $('.reservation-block-'+currentReservationID).hasClass('pending') ? true:false,
                                noReservations = 0;

                                $('.reservation-block-'+currentReservationID).removeClass('pending').removeClass('rejected').removeClass('canceled').removeClass('expired').addClass('approved');
                                Reservations[currentReservation]['status'] = 'approved';
                                $('#DOPBookingSystemPROReservations_Info'+ID).removeClass('is-editable');
                                methods.hideInfo();

                                DOPBSPReservations.toggleMessages('show', DOPBSP.text('SAVE'));

                                $.post(ajaxurl, {action:'dopbsp_approve_reservation', calendar_id:ID, reservation_id: currentReservationID}, function(data){
                                    if (wasPending){
                                        noReservations = $('#DOPBSP-new-reservations span').html() === '' ? 0:parseInt($('#DOPBSP-new-reservations span').html(), 10)-1;

                                        if (noReservations === 0){                                            
                                            $('#DOPBSP-new-reservations').removeClass('new');
                                            $('#DOPBSP-new-reservations span').html('');
                                        }
                                        else{                                            
                                            $('#DOPBSP-new-reservations span').html(noReservations);
                                        }
                                    }
                                    
                                    if ($('#calendar_refresh').val() !== undefined){
                                        $('#calendar_refresh').val('true');
                                    }
                                    DOPBSPReservations.toggleMessages('hide', DOPBSP.text('RESERVATIONS_APPROVE_SUCCESS'));
                                });   
                            }
                        });                             
                    },
                    initRejectReservation:function(){
                            $('#DOPBookingSystemPROReservations_ReservationReject'+ID).unbind('click');
                            $('#DOPBookingSystemPROReservations_ReservationReject'+ID).bind('click', function(){
                                if (confirm(DOPBSP.text('RESERVATIONS_REJECT_CONFIRMATION'))){
                                    var wasPending = $('.reservation-block-'+currentReservationID).hasClass('pending') ? true:false,
                                    noReservations = 0;

                                    $('.reservation-block-'+currentReservationID).removeClass('pending').removeClass('approved').removeClass('canceled').removeClass('expired').addClass('rejected');
                                    Reservations[currentReservation]['status'] = 'rejected';
                                    $('#DOPBookingSystemPROReservations_Info'+ID).removeClass('is-editable');
                                    methods.hideInfo();

                                    DOPBSPReservations.toggleMessages('show', DOPBSP.text('SAVE'));

                                    $.post(ajaxurl, {action:'dopbsp_reject_reservation', calendar_id:ID, reservation_id:currentReservationID}, function(data){
                                        if (wasPending){
                                            noReservations = $('#DOPBSP-new-reservations span').html() === '' ? 0:parseInt($('#DOPBSP-new-reservations span').html(), 10)-1;

                                            if (noReservations === 0){                                            
                                                $('#DOPBSP-new-reservations').removeClass('new');
                                                $('#DOPBSP-new-reservations span').html('');
                                            }
                                            else{                                            
                                                $('#DOPBSP-new-reservations span').html(noReservations);
                                            }
                                        }
                                        DOPBSPReservations.toggleMessages('hide', DOPBSP.text('RESERVATIONS_REJECT_SUCCESS'));
                                    });
                                }
                            });
                    },
                    initCancelReservation:function(){
                        $('#DOPBookingSystemPROReservations_ReservationCancel'+ID).unbind('click');
                        $('#DOPBookingSystemPROReservations_ReservationCancel'+ID).bind('click', function(){
                            if (confirm(DOPBSP.text('RESERVATIONS_CANCEL_CONFIRMATION'))){
                                $('.reservation-block-'+currentReservationID).removeClass('pending').removeClass('approved').removeClass('rejected').removeClass('expired').addClass('canceled');
                                Reservations[currentReservation]['status'] = 'canceled';
                                $('#DOPBookingSystemPROReservations_Info'+ID).removeClass('is-editable');
                                methods.hideInfo();

                                DOPBSPReservations.toggleMessages('show', DOPBSP.text('SAVE'));

                                $.post(ajaxurl, {action:'dopbsp_cancel_reservation', calendar_id:ID, reservation_id:currentReservationID}, function(data){
                                    if ($('#calendar_refresh').val() !== undefined){
                                        $('#calendar_refresh').val('true');
                                    }
                                    DOPBSPReservations.toggleMessages('hide', DOPBSP.text('RESERVATIONS_CANCEL_SUCCESS'));
                                });
                            }
                        });
                    },
                    initDeleteReservation:function(){
                        var i;
                        
                        $('#DOPBookingSystemPROReservations_ReservationDelete'+ID).unbind('click');
                        $('#DOPBookingSystemPROReservations_ReservationDelete'+ID).bind('click', function(){
                            if (confirm(DOPBSP.text('RESERVATIONS_DELETE_CONFIRMATION'))){
                                $('.reservation-block-'+currentReservationID).removeClass('pending').removeClass('approved').removeClass('rejected').removeClass('expired').removeClass('canceled').addClass('deleted');
                                Reservations.splice(currentReservation, 1);
                                
                                for (i=0; i<Reservations.length; i++){
                                    Reservations[i]['level'] = 0;
                                }
                                $('#DOPBookingSystemPROReservations_Info'+ID).removeClass('is-editable');
                                methods.hideInfo();

                                DOPBSPReservations.toggleMessages('show', DOPBSP.text('SAVE'));

                                $.post(ajaxurl, {action: 'dopbsp_delete_reservation',
                                                 reservation_id: currentReservationID}, function(data){
                                    DOPBSPReservations.toggleMessages('hide', DOPBSP.text('RESERVATIONS_DELETE_SUCCESS'));
                                });
                            }
                        });
                    }
                  };

        return methods.init.apply(this);
    };
})(jQuery);