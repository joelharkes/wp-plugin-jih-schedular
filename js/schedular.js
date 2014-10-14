/**
 * Created by Joel on 11-Oct-14.
 */
var $ = jQuery;
jQuery(document).ready(function(){
    var $ = jQuery;

    var modal = $('#jih-plan-hour');

    $('#jih-calendar-week tbody td').click(function(){
        $('#jih-date').val($(this).data('date')+ ' ' +$(this).data('time'))
        $(modal).modal('show');
    })


});


function gotoNextWeek(){
    var $date = $.query.get('date') || moment().format('YYYY-MM-DD');
    $date = moment($date).add(7,'days').format('YYYY-MM-DD');
    gotoUrl($.query.set('date',$date).toString());
}

function gotoLastWeek(){
    var $date = $.query.get('date') || moment().format('YYYY-MM-DD');
    $date = moment($date).add(7,'days').format('YYYY-MM-DD');
    gotoUrl($.query.set('date',$date).toString());
}

function gotoToday(){
    gotoUrl($.query.remove('date').toString());
}

function getDate(){
    return  $.query.get('date') || moment().format('YYYY-MM-DD');
}

function gotoUrl($url){
    window.location.href = $url;
}