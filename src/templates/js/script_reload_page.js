// script นี้เอาไว้ใช้ โหลด function เวลาเปลี่ยนแทบ โดยที่จะมีเงืื่อนไขของ web browser มาเกี่ยวข้อง และจะใช้ on focus มาใช้ว่าถ้าเปลี่ยนแทบก็ให้โหลดฟังชั้นนั้น

var hidden, visibility_change;
var page_visibility_status_before = true;
function handleVisibilityChange() { 
   page_visibility_status_before = document.hidden;
}

if (typeof document.hidden !== "undefined") { // Opera 12.10 and Firefox 18 and later support 
        hidden = "hidden";
        visibility_change = "visibilitychange";
    } else if (typeof document.msHidden !== "undefined") {
        hidden = "msHidden";
        visibility_change = "msvisibilitychange";
    } else if (typeof document.webkitHidden !== "undefined") {
        hidden = "webkitHidden";
        visibility_change = "webkitvisibilitychange";
    }

    if (typeof document.addEventListener !== "undefined" && hidden !== undefined) { 
        document.addEventListener(visibility_change, handleVisibilityChange, false);
    } 
  
    $(window).on('focus',function(){ 
        if (!document.hidden) { 
            if(!page_visibility_status_before){
                page_visibility_status_before = true;
                //update
                // console.log("focus");
                repert_session_cookie();
            }
        }
    });
    $(window).on('blur',function(){
        if (!document[hidden]) { 
            if(!page_visibility_status_before){
                page_visibility_status_before = true;
                //update
                // console.log("blur");
                repert_session_cookie();
            }
        } 
    });
    $(window).on('focusin',function(){
        if (!document[hidden]) { 
            if(!page_visibility_status_before){
                page_visibility_status_before = true;
                //update
                // console.log("focusin");
                repert_session_cookie();
            }
        } 
    });

