/**
 * Created by Joel on 11-Oct-14.
 */
var $ = jQuery;
jQuery(document).ready(function(){
    var $ = jQuery;
    _calendarEl = $('#jih-calendar');
    $eventModal = $('#jih-plan-hour');
    $infoModal = $('#jih-info-modal');
    _calendarId = $.query.get('calendarId') || _calendarId;
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

    $('#calendar-header-date').text(_date.format('MMMM'));

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
var _date = moment().startOf('day');
var CurDate = function(){
    return _date.clone();
};
var _dateFormat = 'YYYY-MM-DD';
var _datetimeFormat = 'YYYY-MM-DD HH:mm:ss';

//END Initial values

function gotoNextWeek(){
    setCalendarOnDate(CurDate().add(7,'days'));
}

function gotoLastWeek(){
    setCalendarOnDate(CurDate().subtract(7,'days'));
}

function gotoToday(){
    setCalendarOnDate(Today());
}

function getDate(){
    return  $.query.get('date') || moment().format('YYYY-MM-DD');
}

function ChangeCalendarId($id){
    _calendarId = $id;
    reloadCalendar();
}

function setCalendarOnDate(date){
    $('thead th',_calendarEl).each(function(i){
        if(i>0){
            $(this).text(CurDate().add(i-1,'days').format(_dateFormat));
        }
    });
    _date = date;
    loadCalendarEvents(date);
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
    loadCalendarEvents(_date);
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