



function check_login() {
    // ฟังก์ชันของการ login มี 3 ตัวคือ check_login  , gen_token_recap , sent_check_login_to_api เรียงตามลำดับนี้
      gen_token_recap();
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
        console.log(Obj);
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
                window.location.href = "/frontend/home";
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
    function clear_cookie_all(){
      var cookies = document.cookie.split(";");
  
      for (var i = 0; i < cookies.length; i++) {
          var cookie = cookies[i];
          var eqPos = cookie.indexOf("=");
          var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
          document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
         
      }
    }
  
  function getCookie(cname) {
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
  
  function parseJwt (token) {
    var base64Url = token.split('.')[1];
    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));
  
    return JSON.parse(jsonPayload);
  };
  
  $(function () {
        repert_session_cookie();
        if(getCookie('json_data') == "''" || getCookie('json_data') == '' ){
          document.cookie = "json_data='set'";
          window.location.href = "login.html";
        }else{
          // console.log(document.cookie);
        }
        get_menu();
       
  
        var data_json = parseJwt(document.cookie);
  
        main_call_data_jwt(data_json);
  
        // show_profile_detail(data_json);
  
    });
  
    function get_menu(){
      $.get('/mvc_slim/public/calldata/mvc_menu',function (data){
        var context = {};
        var data_return = JSON.parse(data);
            context.people = data_return;
            menu_callbacks(context);
      });
    }
  
  
    function getcontent(){
        $.get('/mvc_slim/public/calldata/mvc_content',function (data){
          var context = {};
          var data_return = JSON.parse(data);
              context.content = data_return;
              content_callbacks(context);
              content_callbacks_full(context);
        });
    }
  
    function main_call_data_jwt(data_json){
      $(".profile_call_token").empty();
      var theTemplateScript = $("#profile_call_token_sc").html(); /// อ้างอิงว่าจะชี้ไปที่ script ตัวไหนในหน้า html
      var theTemplate = Handlebars.compile(theTemplateScript); 
      var theCompiledHtml = theTemplate(data_json);
      $('.profile_call_token').append(theCompiledHtml);  // อ้างอิงว่าจะสร้าง append ที่ใด id หรือ class ชื่ออะไร
      
    }
  
  
    function menu_callbacks(data){
      $(".menu_callbacks").empty();
      var theTemplateScript = $("#example-template").html(); /// อ้างอิงว่าจะชี้ไปที่ script ตัวไหนในหน้า html
      var theTemplate = Handlebars.compile(theTemplateScript); 
      var theCompiledHtml = theTemplate(data);
      $('.menu_callbacks').append(theCompiledHtml);  // อ้างอิงว่าจะสร้าง append ที่ใด id หรือ class ชื่ออะไร
    }
  
    function content_callbacks(data){
      $(".content_callbacks").empty();
      var theTemplateScript = $("#content_tem").html(); /// อ้างอิงว่าจะชี้ไปที่ script ตัวไหนในหน้า html
      var theTemplate = Handlebars.compile(theTemplateScript); 
      var theCompiledHtml = theTemplate(data);
      $('.content_callbacks').append(theCompiledHtml);  // อ้างอิงว่าจะสร้าง append ที่ใด id หรือ class ชื่ออะไร
    }
  
    function content_callbacks_full(data){
      $(".model_show_detail").empty();
      var theTemplateScript = $("#content_tem_full").html(); /// อ้างอิงว่าจะชี้ไปที่ script ตัวไหนในหน้า html
      var theTemplate = Handlebars.compile(theTemplateScript); 
      var theCompiledHtml = theTemplate(data);
      $('.model_show_detail').append(theCompiledHtml);  // อ้างอิงว่าจะสร้าง append ที่ใด id หรือ class ชื่ออะไร
    }  
  
  
    function show_profile_detail(data_json){
      $(".show_profile_detail").empty();
      var theTemplateScript_profile = $("#profie_detail_usejwt").html(); /// อ้างอิงว่าจะชี้ไปที่ script ตัวไหนในหน้า html
      var theTemplate_profile = Handlebars.compile(theTemplateScript_profile); 
      var theCompiledHtml_profile = theTemplate_profile(data_json);
      $('.show_profile_detail').append(theCompiledHtml_profile);  // อ้างอิงว่าจะสร้าง append ที่ใด id หรือ class ชื่ออะไร
    }
  

    Handlebars.registerHelper('ifCond', function(v1,operator, v2, options) {
      // idCond = ชื่อ function
      // ตอนส่งค่ามาดูจากหน้า html จะเรียงลำดับตามนี้ v1,operator, v2, options และวิธีการใช้คือ 
      // {{#ifCond status '==' 1}}
      // ...                
      // {{/ifCond}}
      // และจะนำเอา operator มาเช็คเป็นอันดับแรกว่าใช้ operator อะไร จากนั้นค่อยเช็คเงื่อนไข ในกรณีนี้จะเทียบว่า ถ้า status = 1 ถึงจะแสดงผล
  
      switch (operator) {
        case '==':
            return (v1 == v2) ? options.fn(this) :  options.inverse(this) ;
        case '===':
            return (v1 === v2) ? options.fn(this) :  options.inverse(this) ;
        case '!==':
            return (v1 !== v2) ? options.fn(this) : options.inverse(this);
        case '<':
            return (v1 < v2) ? options.fn(this) : options.inverse(this);
        case '<=':
            return (v1 <= v2) ? options.fn(this) : options.inverse(this);
        case '>':
            return (v1 > v2) ? options.fn(this) : options.inverse(this);
        case '>=':
            return (v1 >= v2) ? options.fn(this) : options.inverse(this);
        case '&&':
            return (v1 && v2) ? options.fn(this) : options.inverse(this);
        case '||':inverse
            return (v1 || v2) ? options.fn(this) : options.inverse(this);
        default:
            return options.inverse(this);
      }

        //  options.fn(this)  จะเท่ากับฝยลัพที่เราเขีนไว้ใน if เช่น 
        //  {{#ifCond status '==' 1}}
        //       ok
        //  {{else}}
        //       not ok     
        //  {{/ifCond}}
        //  options.fn(this)    ok และค่า options.inverse(this) จะเท่ากับ not ok

    });

    Handlebars.registerHelper('ifCond_content', function(v1,operator, v2, options) {
      switch (operator) {
        case '==':
            return (v1 == v2) ? options.fn(this)   :  options.inverse(this);
        case '===':
            return (v1 === v2) ? options.fn(this)  :  options.inverse(this) ;
        case '!==':
            return (v1 !== v2) ? options.fn(this)  :  options.inverse(this) ;
        case '<':
            return (v1 < v2) ? options.fn(this) : options.inverse(this);
        case '<=':
            return (v1 <= v2) ? options.fn(this) : options.inverse(this);
        case '>':
            return (v1 > v2) ? options.fn(this) : options.inverse(this);
        case '>=':
            return (v1 >= v2) ? options.fn(this) : options.inverse(this);
        case '&&':
            return (v1 && v2) ? options.fn(this) : options.inverse(this);
        case '||':inverse
            return (v1 || v2) ? options.fn(this) : options.inverse(this);
        default:
            return options.inverse(this);
      }
    });
      // function ตัดคำ เช่นมี string ยาว 300 ตัว แต่ต้องการให้แสดงแค่ 150 จะกำหนดได้ที่ฟังชันนี้
    Handlebars.registerHelper('trimString', function(passedString) {
    var theString = passedString.substring(0,150);
    return new Handlebars.SafeString(theString)
  });
  