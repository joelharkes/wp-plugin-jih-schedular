/**
 * Created by joel on 27/10/2014.
 */
var api = {};
(function($) {
    var _datetimeFormat = 'YYYY-MM-DD HH:mm:ss';

    api.EventById = function(id,onSuccess,onError, sync){
        return post('EventById',{id : id},onSuccess,onError, sync)
    };

    api.EventsForWeek = function(calendarId, date,onSuccess,onError, sync){
        return post('EventsForWeek',{calendarId : calendarId, date : date.format(_datetimeFormat)},onSuccess,onError, sync)
    };

    api.SaveEvent = function(data,onSuccess,onError, sync){
        return post('SaveEvent',data,onSuccess,onError, sync)
    };

    api.DeleteEvent = function(id,onSuccess,onError, sync){
        return post('DeleteEvent',{id : id},onSuccess,onError, sync)
    };

    //Data: Id and Pin
    api.DeleteEventByPin = function(data,onSuccess,onError, sync){
        return post('DeleteEventByPin',data,onSuccess,onError, sync)
    };

    api.SaveCalendar = function(data,onSuccess,onError, sync){
        return post('SaveCalendar',data,onSuccess,onError, sync)
    };

    api.DeleteCalendar = function(id,onSuccess,onError, sync){
        return post('DeleteCalendar',{id : id},onSuccess,onError, sync)
    };


    var post = function(action,input,onSuccess, onError, sync, options){
        var data = {
            action : action,
            dataType : 'json',
            input : input
        };
        var successHandle = !onSuccess ? Log : onSuccess;
        var errorHandle = !onError ? DefaultOnErrorHandling : onError;
        var CheckPostSuccess = function(result,textStatus,thrownError){
            if(result['result']==200){
                successHandle(result['response'],textStatus,thrownError);
            } else {
                errorHandle(result['response'],textStatus,thrownError);
            }
        };

        var defaults = {
            type : "POST",
            url : document.location.pathname + location.search,
            data : data,
            dataType : 'json',
            success : CheckPostSuccess,
            error : errorHandle,
            statusCode: {
                404: function() {
                    alert( "page not found" );
                },
                401: GotoLoginPage
            },
            async: !sync
        };
        if(!IsEmpty(options)){
            defaults = $.extend(true, defaults, options);
        }
        return $.ajax(defaults);
    };

    var DefaultOnErrorHandling = function(result,textStatus,thrownError){
        Log(result);
        alert("Request failed with: "+textStatus.ucFirst()+": "+thrownError+"\nMessage: "+result.responseJSON+"\nSee log for detailed error.");
    }

})(jQuery);