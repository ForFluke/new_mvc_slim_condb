
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
               window.location.href = "other/menu_controller";
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
function edit_content(id){
    window.location.href = "edit_content/"+id;
}
function update_menu_detail(){
        //มาอัปเดท
    var part_action = '';
    var part_end = '';

    var menu_name = document.getElementById("menu_name").value;
    var part_menu = document.getElementById("part_menu").value;
    var status = document.getElementById("status").value;
    var id = document.getElementById("menu_id").value;
        if(id == ''){
            part_action = 'edit_menu/add_menu_confirm';
            part_end = "main_page";
            var data_from = {menu_name: menu_name, part_menu: part_menu, status: status};

        }else{
            part_action = 'edit_menu_confirm';
            part_end ="../main_page";
            var data_from = {menu_name: menu_name, part_menu: part_menu, status: status, id: id};

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
function update_content_detail(){
    //มาอัปเดท
var part_action = '';
var part_end = '';
var title = document.getElementById("title").value;
var detail = document.getElementById("detail").value;
var id = document.getElementById("id").value;
var data_from = {title: title, detail: detail,};
    if(id == ''){
        part_action = 'managent_content/add_content_confirm';
        part_end = "main_content";
        var data_from = {title: title, detail: detail,};

    }else{
        part_action = 'edit_content_confirm';
        part_end ="../main_content";
        var data_from = {title: title, detail: detail, id: id};

    }
$.ajax({
    type: "POST",
    url: part_action,
    data: { data_from:data_from},
    success: function(html){
        var Obj = JSON.parse(html);
        // console.log(data_from);
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
function del_content(id){
    var result = confirm("Want to delete?");
    if (result) {
        $.ajax({
            type: "POST",
            url: "del_content",
            data: { del_id:id},
            success: function(html){
                var Obj = JSON.parse(html);
                location.reload();
            }
        });
    }
}
function import_img(){
    document.getElementById('img').click();
}
function insert_img(){
    var img = document.getElementById("img").value;
    var username = document.getElementById("username").value;
    var imtellg = document.getElementById("tell").value;
    var email = document.getElementById("email").value;

    var data_from = {img: img, username: username, imtellg: imtellg, email: email};
    document.getElementById("edit_profile").submit();

    console.log(data_from);
}
function show_edit_profile(id){
    if(document.getElementById(id).style.display == 'block'){
        document.getElementById(id).style.display = "none";
    }else{
        document.getElementById(id).style.display = "block";

    }
}