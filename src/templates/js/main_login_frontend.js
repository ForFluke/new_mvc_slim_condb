
function check_login() {
    // ฟังก์ชันของการ login มี 3 ตัวคือ check_login  , gen_token_recap , sent_check_login_to_api เรียงตามลำดับนี้
      gen_token_recap();
      console.log('123');
  }
  
  function gen_token_recap(){
    //สร้าง token ของ recap 
        grecaptcha.ready(function() {
        grecaptcha.execute('6LcDTKoUAAAAAARTjiGhrp8zrhIVWNDyqYy_ahVE', {action: 'login'}).then(function(token) {
            // ค่า token ที่ถูกส่งกลับมา จะถูกนำไปใช้ส่งไปตรวจสอบกับ api อีกครั้ง
            // เราเอาค่า token ไปไว้ใน input hidden ชื่อg-recaptcha-response
              document.getElementById('g-recaptcha-response').value = token;
            sent_check_login_to_api();
        });
      });
  }
  function sent_check_login_to_api(){
    // ส่ง ข้อมูลไปเช็คที่ api ของการ login โดยจะส่งไป 3 ค่า คือ username pasword และ รหัส token ของรหัสการ recaptcha
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var g_recaptcha_response = document.getElementById("g-recaptcha-response").value;
  
    $.ajax({
        type: "POST",
        url: "/mvc_slim/public/check_login_client",
        data: { username: username, password: password,g_recaptcha_response: g_recaptcha_response,},
        success: function(html){
        var Obj = JSON.parse(html);
            // console.log(Obj);
            var json_data = Array;
            if(Obj.status_login == false){
              if(Obj.response.score  < 0.1){
                alert('your Robot');
              }else{
                alert('UserName OR Password Not Correct');
              }
                // window.location.href = "?"
            }else{
                json_data = Obj.token;
                document.cookie = "json_data="+json_data;
                // console.log(document.cookie);
                window.location.href = "home";
                set_sesssion_storage("json_data",json_data);
            }
          
        }
    });
  }
  
   function set_sesssion_storage(key,value){
      sessionStorage.setItem(key, value);
   }
    
   function repert_session_cookie(){
    let data_session = sessionStorage.getItem('json_data');
    document.cookie = "json_data="+data_session;
    // console.log(data);
 }
