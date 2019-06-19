
function check_login() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
  
    $.ajax({
        type: "POST",
        url: "ckeck_login",
        data: { username: username, password: password},
        success: function(html){
            var Obj = JSON.parse(html);
            if(Obj == false){
                alert('UserName OR Password Not Correct');
                window.location.href = "?"
            }else{
               window.location.href = "other/profile";
            }
        }
    });
}

function next_page(url){
    window.location.href = url;
}

function edit_menu(id){
    window.location.href = "other/edit_menu/"+id;
}
function update_menu_detail(){
    //มาอัปเดท
}