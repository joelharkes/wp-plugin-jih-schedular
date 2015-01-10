/**
 * Created by Joel on 11-Oct-14.
 */

var $ = jQuery;
moment.locale('nl');

jQuery(document).ready(function(){
    var $ = jQuery;
    _calendarEl = $('#jih-calendar');
    $eventModal = $('#jih-plan-hour');
    $infoModal = $('#jih-info-modal');
    _calendarId = $.query.get('calendarId') || $.cookie('calendarId') || _calendarId;
    $('#jih-calendar-choice').val(_calendarId);
    $('.setCalendarName').text($("option:selected",'#jih-calendar-choice').text());
    $('tbody td',_calendarEl).click(function(){
        var $this = $(this);
        if($this.hasClass('is-filled')){
            $infoModal.modal('show');
            var event = $this.data('event');
            $.each(event,function(attr,value){
                $infoModal.find('div.data-'+attr).text(value);
                $infoModal.find('input.data-'+attr).val(value);
                $infoModal.find('input')
            });

        } else {
            $('#jih-date').val(getDateFromElement(this).format(_datetimeFormat));
            $('#redirect-url').val(document.URL);
            $($eventModal).modal('show');
        }

    });



    var $eventForm = $('#schedular-event-form');
    $eventForm.submit(function(e){
        e.preventDefault();
        var data = $eventForm.serializeObject();
        data.calendarId = _calendarId;
        api.SaveEvent(data,onSuccesEventSave);
    });

    var $deleteForm = $('#delete-event-form');
    $deleteForm.submit(function(e){
        e.preventDefault();
        var data = $deleteForm.serializeObject();
        api.DeleteEventByPin(data,function(){
            $infoModal.modal('hide');
            reloadCalendar();
        },function(){
            alert('Event not deleted, wrong pincode. (Events without pin cannot be deleted by users)')
        })
    });

    setCalendarOnDate(_date);
});

var onSuccesEventSave = function(){
    $eventModal.modal('hide');
    reloadCalendar();
};

var $infoModal;
var $eventModal;
//Initial values
var _calendarSize = 7;
var _calendarId = 1;
var _calendarEl = null;
var _date = ThisWeek();
var CurDate = function(){
    return _date.clone();
};
var _dateFormat = 'YYYY-MM-DD';
var _datetimeFormat = 'YYYY-MM-DD HH:mm:ss';

//END Initial values

function gotoWeekAfter(){
    setCalendarOnDate(CurDate().add(7,'days'));
}

function gotoWeekBefore(){
    setCalendarOnDate(CurDate().subtract(7,'days'));
}
function gotoDayBefore(){
    setCalendarOnDate(CurDate().subtract(1,'days'));
}
function gotoDayAfter(){
    setCalendarOnDate(CurDate().add(1,'days'));
}
function gotoToday(){
    setCalendarOnDate(ThisWeek());
}

function getDate(){
    return  $.query.get('date') || moment().format('YYYY-MM-DD');
}

function ChangeCalendarId($id){
    _calendarId = $id;
    reloadCalendar();
    $.cookie('calendarId',$id);
    $('.setCalendarName').text($("option:selected",'#jih-calendar-choice').text());
}

function setCalendarOnDate(date){
    _date = date;
    $('thead th',_calendarEl).each(function(i){
        if(i>0){
            $(this).html(CurDate().add(i-1,'days').format('dddd<br>DD MMM'));
        }
    });
    $('#calendar-header-date').html(_date.format('MMMM YYYY'));
    loadCalendarEvents(date);

    //Add in the past class
    var hourDiff = moment.duration(moment().diff(_date)).asHours();
    var cells = $('td',_calendarEl).removeClass('inThePast');
    var $i = 0;
    while (hourDiff > $i && $i <= 24*7){
        cells.eq(Math.floor($i/24)+$i%24*7).addClass('inThePast')
        $i++;
    }
    //$('td',_calendarEl).removeClass('inThePast').slice(0,hourDiff).addClass('inThePast');
}

function getDateFromElement(el){
    var index = $('td',_calendarEl).index(el);
    var hour = Math.floor(index/7);
    var daysFromDate = index%7;
    return CurDate().add(daysFromDate,'days').add(hour,'hours')
}

function getElementFromDate(date){
    var days = date.diff(_date,'days');
    var hours = date.hours();
    var index = (hours * _calendarSize) + days;
    return $('td',_calendarEl).eq(index);
}

function reloadCalendar(){
    setCalendarOnDate(_date);
    //loadCalendarEvents(_date);
}

function loadCalendarEvents(date){
    emptyCalendar();
    api.EventsForWeek(_calendarId,date,saturateCalendar);
}


var filledClass = 'is-filled';

function saturateCalendar(events){
    $.each( events, function( index, event ) {
        $dateEl = getElementFromDate(moment(event.datetime));
        $dateEl.addClass(filledClass).text(event.name);
        $dateEl.data('event',event);
    });
}

function emptyCalendar(){
    $('.'+filledClass,_calendarEl).removeClass(filledClass).text('');
}

//HOTKEYS

$(document).keyup(function(e){
    if(e.which==37){
        if(e.ctrlKey)
            gotoWeekBefore();
        else
            gotoDayBefore();
    }
    if(e.which==39){
        if(e.ctrlKey)
            gotoWeekAfter();
        else
            gotoDayAfter();
    }
})