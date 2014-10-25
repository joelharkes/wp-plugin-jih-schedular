/**
 * Created by Joel on 11-Oct-14.
 */
var $ = jQuery;
jQuery(document).ready(function(){
    var $ = jQuery;
    _calenderEl = $('#jih-calendar');

    var modal = $('#jih-plan-hour');

    $('tbody td',_calenderEl).click(function(){
        //alert(getDateFromElement(this));
        Log (getDateFromElement(this));
        $('#jih-date').val($(this).data('date')+ ' ' +$(this).data('time'))
        $('#redirect-url').val(document.URL);
        $(modal).modal('show');
    })

    $('#calendar-header-date').text(_date.format('MMMM'))

});

//Initial values
var _calenderEl = null;
var _date = moment().startOf('day');
var CurDate = function(){
    return _date.clone();
};
var _dateFormat = 'YYYY-MM-DD';

//END Initial values

function gotoNextWeek(){
    setcalendarOnDate(CurDate().add(7,'days'));
}

function gotoLastWeek(){
    setcalendarOnDate(CurDate().subtract(7,'days'));
}

function gotoToday(){
    setcalendarOnDate(Today());
}

function getDate(){
    return  $.query.get('date') || moment().format('YYYY-MM-DD');
}

function gotoUrl($url){
    window.location.href = $url;
}

function setcalendarOnDate(date){
    $('thead th',_calenderEl).each(function(i){
        if(i>0){
            $(this).text(CurDate().add(i-1,'days').format(_dateFormat));
        }
    });
    _date = date;
}

function getDateFromElement(el){
    var index = $('td',_calenderEl).index(el);
    var hour = Math.floor(index/7);
    var daysFromDate = index%7;
    return CurDate().add(daysFromDate,'days').add(hour,'hours')
}



//Util Functinos
function Log(input){
    console.log(input);
}

function Today(){
    return moment().startOf('day');
}