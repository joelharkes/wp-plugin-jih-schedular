/**
 * Created by joel on 27/10/2014.
 */
var api = {};
(function($) {
    api.EventById = function(id,onSuccess,onError){
        post('EventById',{id : id},onSuccess,onError)
    };


    var post = function(action,input,onSuccess, onError, options){
        var data = {
            action : action,
            input : input
        };

        var defaults = {
            type : "POST",
            url : '/',
            data : data,
            dataType : 'json',
            success : IsDefined(onSuccess) ? onSuccess : Log,
            error : IsDefined(onError) ? onError : OnError,
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

    var OnError = function(result,textStatus,thrownError){
        Log(result);
        alert('Error: '+code+', '+thrownError);
    }

})(jQuery);