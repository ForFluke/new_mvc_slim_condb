
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
    window.location.href = "edit_menu/"+id;
}
function update_menu_detail(){
        //มาอัปเดท
    var part_action = '';
    var part_end = '';

    var menu_name = document.getElementById("menu_name").value;
    var part_menu = document.getElementById("part_menu").value;
    var status = document.getElementById("status").value;
    var data_from = {menu_name: menu_name, part_menu: part_menu , status: status};
    var menu_id = document.getElementById("menu_id").value;
        if(menu_id == ''){
            part_action = 'edit_menu/add_menu_confirm';
            part_end = "main_page";

        }else{
            part_action = 'edit_menu_confirm';
            part_end ="../main_page";
        }
   
    $.ajax({
        type: "POST",
        url: part_action,
        data: { data_from:data_from},
        success: function(html){
            var Obj = JSON.parse(html);
            window.location.href = part_end;
        }
    });
}
function del_menu(id){
    var result = confirm("Want to delete?");
    if (result) {
        $.ajax({
            type: "POST",
            url: "del_menu",
            data: { del_id:id},
            success: function(html){
                var Obj = JSON.parse(html);
                location.reload();
            }
        });
    }
}