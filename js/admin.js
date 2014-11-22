/**
 * Created by Joel on 22-Nov-14.
 */

(function($){
    $(document).ready(function(){
        $('#search-form').submit(function(e){
            GotoUrl(jQuery.query.set('search', jQuery('#plugin-search-input').val()))
            e.preventDefault();
        });
    })

})(jQuery);

function DeleteCalendar($id){
    api.DeleteCalendar($id,function(){
        GotoUrl();
    })
}

function ShowNewCalenderModal(){
    jQuery('#jih-calendar-modal').modal('show')
}