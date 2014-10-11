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
