/**
 * Created by joel on 27/10/2014.
 */
var api = {};
(function($) {
    var _datetimeFormat = 'YYYY-MM-DD HH:mm:ss';

    api.EventById = function(id,onSuccess,onError){
        post('EventById',{id : id},onSuccess,onError)
    };

    api.EventsForWeek = function(calendarId, date,onSuccess,onError){
        post('EventsForWeek',{calendarId : calendarId, date : date.format(_datetimeFormat)},onSuccess,onError)
    };

    api.SaveEvent = function(data,onSuccess,onError){
        post('SaveEvent',data,onSuccess,onError)
    };

    api.DeleteEvent = function(id,onSuccess,onError){
        post('DeleteEvent',{id : id},onSuccess,onError)
    };

    //Data: Id and Pin
    api.DeleteEventByPin = function(data,onSuccess,onError){
        post('DeleteEventByPin',data,onSuccess,onError)
    };

    api.SaveCalendar = function(data,onSuccess,onError){
        post('SaveCalendar',data,onSuccess,onError)
    };

    api.DeleteCalendar = function(id,onSuccess,onError){
        post('DeleteCalendar',{id : id},onSuccess,onError)
    };


    var post = function(action,input,onSuccess, onError, options){
        var data = {
            action : action,
            dataType : 'json',
            input : input
        };

        var defaults = {
            type : "POST",
            url : document.location.pathname + location.search,
            data : data,
            dataType : 'json',
            success : IsDefined(onSuccess) ? onSuccess : Log,
            error : IsDefined(onError) ? onError : DefaultOnErrorHandling,
            statusCode: {
                404: function() {
                    alert( "page not found" );
                },
                401: GotoLoginPage
            }
        };
        if(!IsEmpty(options)){
            defaults = $.extend(true, defaults, options);
        }
        $.ajax(defaults);
    };

    var DefaultOnErrorHandling = function(result,textStatus,thrownError){
        Log(result);
        alert("Request failed with: "+textStatus.ucFirst()+": "+thrownError+"\nMessage: "+result.responseJSON+"\nSee log for detailed error.");
    }

})(jQuery);