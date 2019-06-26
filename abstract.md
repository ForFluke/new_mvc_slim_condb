# สรุปผล การศึกษา slim , twig , Handlebars templates , AdminBSBMaterialDesign , JSON Web Tokens 
# สการทำงานหลักคือจะใช้ slim โดยจะใช้ การสร้างแบบ mvc  

# การทำงานหลักคือจะใช้ slim โดยจะใช้ การสร้างแบบ mvc 
   # backend
#   --- ส่วนของ controller and Models ---

        ใช้ twig เป็นส่วนของการแสดงผล ( view ) และการทำงาน (controller) จะใช้ slim 
        เริ่มจากการกำหนด เส้นทางของการทำงานว่าแต่ละเส้นทางมีการทำงานอย่างไร เช่น ถ้าเราชี้ url ไปที่ /login เราจะใช้ ตัวกำหนดเส้นทางคือ file router.php เป็นตัวกำหนด ว่าเส้นทางนี้จะเรียกใช้ function ใด ใน controller อย่างในกรณีนี้ โดยการเช็คเส้นทางตอนนี้จะมีใช้อยู่ 2 อย่างคือ post และ get โดยที่ขึ้นอยู่กับการส่งข้อมูลมา เริ่มจาก

            (  จริงๆมีมากกว่า 2 คือ get (การเรียกหน้าธรรมดา) , 
            post (การกดปุ่ม บันทึก) , 
            put (การกดบันทึกจากหน้าแก้ไขข้อมูล) , 
            DELETE (การลบผ่านการใช้งาน webservice) ,
            OPTIONS (ใช้เรียกคำอธิบายว่า เราสามารถทำอะไรกับ ส่วนนี้ได้บ้าง) ,
            PATCH (เหมือนกับ Put) ,
            Any (ใช้รองรับคำร้องขอในเแบบไม่จำกัด เมทอด),
            map (เหมือนกับ any แต่แทนที่จะรับทั้งหมดเรารับแค่บางตัวพอ), 
            group (รวมการทำงานของ router ไว้ด้วยกัน)  )

#   ***group*** 
            เช่นถ้ามีเส้นทางที่เหมือนกันอย่าง   /other/... หลายๆอัน เราสามารถ group routes นั้นๆรวมกันได้ 

#   ***get*** 

         EX  1
            $app->get('/login', ['\App\Controllers\HomeController', 'index']);
            หมายความว่า ถ้ามี url ที่มี part login จะเรียกใช้ฟังชัน index ในไฟล์ AuthController และทำงานต่อไป  เช่น 
    *** ( function index ใน HomeController) 
    public function index(Request $request, Response $response, View $view) {
        $session = new Session();
        return $view->render($response, 'login.twig' ,['data' => $data ]);
    }
    จาก function ด้านบน การทำงานคือ  function นี้จะทำการ render ไฟล์ที่ชื่อ login.twig ขึ้นมา ตาม part เริ่มต้นที่เรากำหนดไว้ในไฟล์ app.php ผ่านตัวแปร view โดย การ return ค่า return $view->render($response, 'login.twig' ,['data' => $data ]); จะมีผลเท่ากับ จะ render ไฟล์ที่ชื่อ login.twig ใน part /src/templates/login.twig
    โดยในกรณีนี้ จะสามารถส่งค่า array ไปที่ไฟล์นั้นได้ด้วย เช่น จากตัวอย่างเราจะส่งตัวแปร array ชื่อ data เข้าไป
    หรือถ้าต้องการจะส่งข้อมูลมาเป็นค่า get สามารถทำได้ โดยกำหนด เส้นทางแบบนี้

    $app->get('/other/edit_content/{id}', ['\App\Controllers\HomeController', 'edit_content']);
    จากด้านบนจะเห็นได้ว่า ใน part เราจะมีการกำหนด {id} หมายความว่าเราจะส่งค่าตัวแปรไปโดยใช้ชื่อว่า id 
    และการรับค่าใน controller จะรับโดยใช้ code  $id = $request->getAttribute('route')->getArgument('id');
 
#    ***POSt*** 

    การกำหนดเป็น post จะทำงานคล้าย get ต่างกันที่ข้อมูลที่ส่งมาา เช่นในกรณีนี้เราส่งข้อมูลมาจาก from เพื่อนำทำงาน 
    
    EX   2
    public function check_login(Request $request, Response $response, View $view, Main_function $Main_function) {
        $params =  $request->getParams();
        $home_data = $Main_function->check_login($params['username'],$params['password']);
        echo json_encode($home_data);
    }
    
    ในตัวอย่าง ถ้าเราส่งข้อมูลมาหลายตัว โดยส่งเป็น method post จะรับค่าโดยใช้ $request->getParams(); นั้นหมายความว่าเราจะเรียกเอา paramister ทุกตัวที่ส่งมา มาใช้งาน 
    แต่ถ้าเราต้องการจะเรียก ข้อมูลที่อยู่ใน header จะใช้ $request->getHeaders(); เลือกการอัปโหลดไฟล์ใช้  $request->getUploadedFiles();  หรือจะเรียกข้อมูลใน body ก็จะใช้  $request->getBody(); ขึ้นอยู่กับการใช้งานของเรา ในกรณีนี้เราจะใช้  $request->getParams();
    และเอาค่าที่เรารับมานั้น ใส่ที่ตัวแปรชื่อ $param ตามตัวอย่างด้านบน  

    ถ้าในกรณีที่เราต้องการจะทำงานเพิ่มเติม ที่เกี่ยวข้องกับการคำนวน ประมวลผล หรือการเชื่อมต่อ db เราจะทำการเรียกฟังชันใน model แทนที่จะทำในหน้านี้ เช่น จากตัววอย่างที่ 2 เราจะมีคำสั่ง $Main_function->check_login($params['username'],$params['password']); หมายความว่า เราจะเรียกใช้ฟังชันชื่อ  check_login ในไฟล์ Main_function ( การจะใช้งาน Main_function นั้นต้องประกาศการรับค่าไว้ก่อนดังนี้ 
    use App\Models\Main_function as Main_function; หมายความว่าจะเรียกใช้ไฟล์ Main_function ในชื่อตัวแปร Main_function) ซึ่งฟังชัน check_login ใน  Main_function เป็นดังนี้ โดยจะรับค่า มา 2 ค่าคือ email แะ password 

    public function check_login($email,$password) {
    	$stmt = $this->db->prepare("SELECT id,username,nickname,email,tell,img_part from mvc_member WHERE email = :email AND password = :password  ");
		$stmt->execute(array(':password' => $password,':email' => $email));
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    ในฟังชันนี้จะมีการเชื่อมต่อฐานข้อมูลอยู่และจะทำงานโดยการ คิวรี่ใน ฐานข้อมูลในตารางที่ชื่อ mvc_member โดย email และ password จะต้องเท่ากับค่าที่ส่งมาผ่านทางฟังชัน  และในฟังชัน check_login นี้จะทำการ return ค่ากับไปที่ไฟล์ HomeController เป็น array  เพื่อนำไปใช้งานต่อ  ตามตัวอย่างที่ 2 โดยจะส่งไปหน้า view เป็น  ค่า json เพื่อเรียกใช้ต่อไป 

#   --- ส่วนของ view --- 

    จะใช้ twig ใช้การใช้งาน โดยหลักเริ่มต้นคือสร้างไฟล์ master ที่จะเรียกใช้ footer และ header และแสดงผล ไฟล์ content โดยใช้รูปแบบนี้ โดยในไฟล์ lauou จะมีกาาร include ไฟล์ header แะ footer ไว้  โดยการทำงานเงื่อนในต่างๆในส่วนของ view นั้นจะใช้ javascript เป็นตัวดำเนินการ ทั้งการ call ข้อมูลใน api 
    และการแสดงผลข้อมูลในส่วนของ view นั้น อ้างอิงจากด้านบนส่วนของ controller and Models ที่ได้พูดไว้ จะทำการแสดงผผลข้อมูลดังนี้ {{ data.member.username }} คือหมายความว่า แสดงผลข้อมูล array ชื่อ 
    $data['member']['username'] 

    หรือถ้าเราต้องการจะใช้ loop เพื่อแสดงผลข้อมูลทั้งหมด ก็จะใช้ 
    {% for data_profile in data.data_profile  %}
            ... 
    {% endfor %}
    หมายความว่าจะ loop ตัวแปร $data['data_profile'] โดยจะใช้ชื่อ data_profile แทนที่จะทำในหน้านี้
    ถ้าต้องกรใช้ if 
      {% if data_menu.status == 1 %} .1.. {% else %} .2.. {% endif %}
    หมายความว่า ถ้า data_menu.status == 1 จะแสดงผล .1.. ถ้าไม่ใช่ .2..

    โดยข้อมูลในไฟล์ .twig นั้นจะอยู่ใน tag {% block content %} {% endblock %} และจะทำการเรียกไฟล์ 
    {% extends "layout.twig" %} มาใช้ เพื่อจะใช้งาน templates header และ footer โดยไม่ต้องประกาศไว้ทุกหน้า 
        ฟังชันอื่นๆ อยู่ที่ไฟล์ http://localhost/mvc_slim/public/other/show_profile ซึ่งสรุปไว้หมดแล้ว

#        ***รูปแบบ และ templates การแสดงผลต่างๆนั้น เอามาจาก AdminBSBMaterialDesign 

    --------------------------------------------------------------------------------------------------

#  ส่วนของ frontend 
    ส่วนนี้จะใช้   Handlebars templates ในการทำงาน โดยจะต่างจากส่วนของ     backend ตรงที่ ส่วนนี้จะทำงานโดยใช้ javascript เป็นหลัก ในการดึงข้อมูลมาแสดงผล เช่นถ้าเราต้องการข้อมูลหน้า profile โดยจะแสดงผลข้อมูลส่วนตัว 
    ถ้าเป็นใน backend จะทำการสร้าง เส้นทาง และเรียกใช้ฟังชันต่างๆใน Controller แล้วส่งค่ามาที่หน้าแสดงผล แต่ใน Handlebars นั้นเราจะทำการยิง api ไปเพื่อเรียกข้อมูล ( ในที่นี้ใช้ ajax ) และเมื่อได้ข้อมูลกลับมานั้นจะเรียกใช้ฟังชัน ดังนี้
---------------------------------------------------------------
ex 3
    function show_profile_detail(data_json){
      var theTemplateScript_profile = $("#profie_detail_usejwt").html(); /// อ้างอิงว่าจะชี้ไปที่ script ตัวไหนในหน้า html
      var theTemplate_profile = Handlebars.compile(theTemplateScript_profile); 
      var theCompiledHtml_profile = theTemplate_profile(data_json);
      $('.show_profile_detail').append(theCompiledHtml_profile);  // อ้างอิงว่าจะสร้าง append ที่ใด id หรือ class ชื่ออะไร
    } และอ้างอิงไปที่ไฟล์ .twig ที่เราสร้างไว้  ดังนี้
---------------------------------------------------------------
ex 4

<section class="content">
    <div class="row clearfix show_profile_detail" >
    </div>
</section>
-----------------------------------------------------------------
ex 5

{% raw %}
    <script id="profie_detail_usejwt" type="text/x-handlebars-template">
        <div class="card profile-card" style="margin: 0 200px;">
            <div class="profile-header">&nbsp;</div>
                <div class="profile-body">
                    <div class="image-area">
                        <img src="/mvc_slim/src/templates/img/{{img_part}}" alt="AdminBSB - Profile Image" style="max-width: 160px;max-height: 160px;">
                    </div>
                    <div class="content-area">
                        <h3>{{username}}</h3>
                        <p>{{nickname}}</p>
                        <p>{{email}}</p>
                        <p>{{tell}}</p>
                    </div>
                </div>
                <div class="profile-footer">
                </div>
        </div>
    </script>
{% endraw %}
---------------------------------------------------------------

กรณีที่ไฟล์ที่ใช้เป็น .twig นั้น การจะประกาศ script ของ handlebars-template จะต้องอยู่ใน tag {% raw %} {% endraw %}

จาก ex 3  หมายความว่า เราจะนำข้อมูลที่รับมาในฟังชันนั้น ไปทำงงานใน script ชื่อ profie_detail_usejwt  ในตัวอย่างที่ 5 และ จะนำไปแสดงผล ที่ id show_profile_detail ตามตัวอย่างที่ 4  โดยการแสดงผล หรือเงื่อนไขต่างๆนั้น เราจะทำในส่วนของตัวอย่างที่ 5 เช่น กรณี การตัดคำ เราจะสร้างฟังชัน 

Handlebars.registerHelper('trimString', function(passedString) {
    var theString = passedString.substring(0,150);
    return new Handlebars.SafeString(theString)
}); 

  ไว้ใน script และในตัวอย่างที่ 5 เราก็จะเพิ่ม  {{{trimString data}}} เข้าไป  โดยจะหมายความว่า ส่งตัวแปร data ไปที่ฟังชัน  trimString และในฟังชันนั้น  ตัวแปรที่ชื่อ data จะถูกตัด string ตั้งแต่ตัวที่ 0 - 150 ก่อนจะแสดงผล 
  ในกรณีของ if else ก็จะทำงานเช่นเดียวกัน 


  หรือถ้าตัวแปลที่ได้รับมาจากตัวอย่างที่ 3 เป็น array และต้องการ loop เพื่อแสดงผล ก็จะใช้  
   {{#each content}} ... {{/each}} หมายความว่าจะ loop ตัวแปรชื่อ content


   -----------------------------------------------------------------------------------------------------------
  #   JWT ( JSON Web Tokens ) 
        ส่วนของ jwt นั้นจะใช้ตั้งแต่ตอน login โดยเมื่อ login เข้าสู่ระบบแล้ว ระบบจะทำการสร้าง token โดยมีรุปแบบการสร้างดังนี้  
        

        HEADER.PAYLOAD.SIGNATURE  โดย  
        ---HEADER คือส่วนที่จะระบุ ALGORITHM & TOKEN TYPE ว่าใช้แบบใด
        ---PAYLOAD คือส่วนของข้อมูลี่เราส่งเข้าไป (ห้ามส่งข้อมูลที่เป็นความลับ เช่นรหัสผ่าน)
        ---SIGNATURE จะเป็นเหมือนการยืนยันตัวตน 
                
        โดยเมื่อได้ token มาแล้วก็จะทำกาารเก็บ token นั้นไว้ใน cookie เพื่อเรียกใช้งาน ข้อมูลที่เราเก็บไว้ใน token ได้ แต่ในที่นี้ เราต้องการให้สามารถ login 2 user ได้โดยข้อมูลของ 2 user นั้นจะไม่ทับกัน เช่นเราเปิด tap login ของนาย a และเปิดอีก tap เพื่อ login  ของนาย b  เราต้องสามารถใช้ของทั้ง 2 คนนั้นได้ใน เบราเซอร์เดียวกัน ซึ่งปกติจะทำไม่ได้ เพราะข้อมูลที่ดึงมานั้น จะดึงจาก cookie ซึ่งเมื่อเรา login ของคนใหม่ไปแล้ว  cookie ก็จะเปลี่ยนไป เราจึงใช้ localstorage และ sessionstorage มาใช้ โดยเมื่อ login ของแต่ละเพจแล้ว จะทำการสร้างทั้ง cookie และ storage และต่อให้ login ใหม่ ถึง cookie จะเปลี่ยนไปแต่ storage จะยังอยู่ เราจะนำ storage ที่เก็บไว้ มาแทนที่ cookie แทนเพื่อให้มัแสดงผลคนเดิม
        โดยใช้ฟังชัน  $(window).on('focus',function() เพือเช็คว่ามีการเปลี่ยนหน้า สลับ tap หรืป่าว ถ้ามีก็ให้เรียกฟังชันกา การเอา sessionstorage มาแทน cookie 
    ***แปลงค่า token https://jwt.io/  
-----------------------------------------------------------------------------------------------------------
#   googel recaptcha       
        ในส่วนของการ login project นี้จะมีการเช็ค google recaptcha โดยทาง การทำงานจะแบ่งเป็น 2 ส่วนคือส่วนของ frontend และ backend โดยจะมี api key อยู่  2 ตัว ตัวแรกเอาไว้สร้าง token อยู่ที่ frontend และอีกตัวหนึงจะอยู่ใน backend โดยให้ส่งส่วนที่ 1 เมื่อได้ token มาแแล้วจะทำการส่ง token ตัวนี้ไปที่ backend และเอา api key ที่ส่งมาจาก fromtend นั้นมาตรวจสอบ ส่งค่าไปยัง api ของ google ทาง google จะทำการส่งข้อมูลกลับมาพร้อมสถานะกับคะแนน มาให้ โดยระดับคะแนน นั้นจะขึนอยู่กับทาง google มีคะแนนช่วง 0.1 - 0.9 โดยถ้าคะแนนน้อยนั้นหมายความว่า อาจจะเป็น robot ได้ 