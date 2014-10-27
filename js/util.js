/**
 * Created by joel on 27/10/2014.
 */

var Log = function(data){
    console.log(data);
};


var GotoLoginPage = function(){
  alert('GotoLoginPage not implement yet');
};

function IsDefined(item){
    return typeof item !== "undefined";
};

function IsEmpty(item){
    return IsDefined(item) && (!item || 0 === item.length);
};