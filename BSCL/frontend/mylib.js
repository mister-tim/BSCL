/*
*****************************************************************
*                                                               *
*       A collection of pre-defined reusable functions.         *
*                                                               *
*****************************************************************
*/
/*****              Fun with cookies!                       *****/
export function makeCookie(cname, cvalue){
  var name = cname + "=";
  if(typeof(cvalue) == "object"){
      document.cookie = name + JSON.stringify(cvalue);
  } else if(typeof(cvalue) == "string"){
      document.cookie = name + cvalue;
  } else{
    console.log("Unexpected type error while creating cookies.");
  }
}
export function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }
  export function deleteCookies(){
    for(let i=0;i<arguments.length;i++){
      let name = arguments[i] + "=";
      document.cookie = name+"; expires=Fri, 13 Dec 1991 3:57:00 UTC;";
    }
  }