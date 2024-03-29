<?php

namespace App\Models;

use App\Database\DatabaseInterface as DB;

class Main_function {
    protected $db;

    public function __construct(DB $db) {
         $this->db = $db;
    }

    public function getDataAll() {
        return $this->db->query("SELECT * from mvc_member")->fetchAll(\PDO::FETCH_OBJ);
    }
    public function show_profile($data) {
        //echo '<pre>';print_r($data);echo '</pre>';
        $stmt = $this->db->prepare("SELECT * from mvc_member WHERE email = :email AND id = :id ");
		$stmt->execute(array(':id' => $data['id'],':email' => $data['email']));
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function check_login($email,$password) {
    	$stmt = $this->db->prepare("SELECT id,username,nickname,email,tell,img_part from mvc_member WHERE email = :email AND password = :password  ");
		$stmt->execute(array(':password' => $password,':email' => $email));
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function check_admin_login($email,$password) {
    	$stmt = $this->db->prepare("SELECT id,username,nickname,email,tell,img_part from mvc_admin WHERE email = :email AND password = :password  ");
		$stmt->execute(array(':password' => $password,':email' => $email));
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
         
    public function insert_member($menu_name,$part_menu) {
        $sth = $this->db->prepare('INSERT into mvc_menu (menu_name, part_menu,status,create_time) values (:menu_name, :part_menu ,1,NOW())');
        $this->db->beginTransaction(); 
        $sth->execute(array(':menu_name' => $menu_name,':part_menu' => $part_menu)); 

        $this->db->commit(); 
    }

    public function update_member($menu_name,$part_menu) {

        $sth = $this->db->prepare('UPDATE mvc_menu SET menu_name=:menu_name 
        , part_menu = :part_menu,update_time= NOW() WHERE id=:id');
        $this->db->beginTransaction(); 
        $sth->execute(array(':menu_name' => $menu_name,':part_menu' => $part_menu ,':id' => '2')); 
        $this->db->commit(); 
    }

    public function get_data_in_db($table) {
        return $this->db->query("SELECT * from {$table} ")->fetchAll(\PDO::FETCH_OBJ);
    }
    
    public function request_content_api($table) {
        return $this->db->query("SELECT title,detail,SUBSTRING(detail, 1, 200) AS detail_st,create_time,id from mvc_content ")->fetchAll(\PDO::FETCH_OBJ);
    }
    public function mvc_menu_data_in_db($table) {
        // return $this->db->query("SELECT id,menu_name,part_menu,create_time, IF(status=1,true,'') as status from {$table} ")->fetchAll(\PDO::FETCH_OBJ);
        return $this->db->query("SELECT id,menu_name,part_menu,create_time, status from {$table} ")->fetchAll(\PDO::FETCH_OBJ);

    }
    
    public function edit_function($id) {
        $stmt = $this->db->prepare("SELECT * from mvc_menu WHERE id = :id ");
		$stmt->execute(array(':id' => $id));
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function edit_content_function($id) {
        $stmt = $this->db->prepare("SELECT * from mvc_content WHERE id = :id ");
		$stmt->execute(array(':id' => $id));
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function del_menu($id) {
        $sth = $this->db->prepare('DELETE FROM  mvc_menu WHERE id = :id');
        $this->db->beginTransaction(); 
        $sth->execute(array(':id' => $id )); 
        $this->db->commit(); 
    
    }
    public function del_content($id) {
        $sth = $this->db->prepare('DELETE FROM  mvc_content WHERE id = :id');
        $this->db->beginTransaction(); 
        $sth->execute(array(':id' => $id )); 
        $this->db->commit(); 
    
    }
    public function edit_menu_confirm($menu_name,$part_menu,$status,$id) {

        $sth = $this->db->prepare('UPDATE mvc_menu SET menu_name=:menu_name 
        , part_menu = :part_menu, status = :status,update_time= NOW() WHERE id=:id');
        $this->db->beginTransaction(); 
        $sth->execute(array(':menu_name' => $menu_name,':part_menu' => $part_menu ,':id' => $id ,'status' => $status)); 
        $this->db->commit(); 
    }
    public function add_menu_confirm($menu_name,$part_menu,$status) {

        $sth = $this->db->prepare('INSERT into mvc_menu (menu_name, part_menu,status,create_time) values (:menu_name, :part_menu ,:status,NOW())');
        $this->db->beginTransaction(); 
        $sth->execute(array(':menu_name' => $menu_name,':part_menu' => $part_menu,':status' => $status)); 

        $this->db->commit(); 
    }
    public function edit_content_confirm($title,$detail,$id) {

        $sth = $this->db->prepare('UPDATE  mvc_content SET title=:title 
        , detail = :detail,update_time= NOW() WHERE id=:id');
        $this->db->beginTransaction(); 
        $sth->execute(array(':title' => $title,':detail' => $detail ,':id' => $id )); 
        $this->db->commit(); 
    }
    public function add_content_confirm($title,$detail) {

        $sth = $this->db->prepare('INSERT into  mvc_content (title, detail,create_time) values (:title, :detail ,NOW())');
        $this->db->beginTransaction(); 
        $sth->execute(array(':title' => $title,':detail' => $detail)); 
        $this->db->commit(); 
    }
    public function edit_profile_detail($data) {
        
        $data['main_function'] = 'main_function';
        $sth = $this->db->prepare('UPDATE  mvc_member SET username=:username 
        ,tell=:tell,img_part=:img_part,nickname=:nickname WHERE email=:email');
        $this->db->beginTransaction(); 
        $sth->execute(array(':username' => $data['username'],':tell' => $data['tell'] ,':img_part' =>  $data['img'],':email' =>  $data['email'],':nickname' =>  $data['nickname'])); 
        $this->db->commit(); 
        // echo '<pre>';print_r($data);echo '</pre>';
    }
    public function check_recaptcha($data) {
    // เช็ค google recaptha 
        $recaptcha_secret = "6LcDTKoUAAAAAEkiizw3FRgewiZ4s5iPn0hlSsXD"; //รหัส secret ที่ได้รับมาตอนขอ api
        $recaptcha_response = trim($data);  //token ที่ได้รับมาตอนส่งค่าหน้าบ้าน
        $recaptcha_remote_ip = '';  //url 
    
        $recaptcha_api = "https://www.google.com/recaptcha/api/siteverify?".
            http_build_query(array(
                'secret'=>$recaptcha_secret,
                'response'=>$recaptcha_response,
                'remoteip'=>$recaptcha_remote_ip
            )
        );  // ส่งค่า รหัส url ที่ทำงาน และ token ที่ได้รับมาจากหน้าเว็บไปตรวจสอบ ใน api 
        $response = json_decode(file_get_contents($recaptcha_api), true);     
        return $response;
    // เช็ค google recaptha 
    }
    public function call_member_by_id($id) {
        $stmt = $this->db->prepare("SELECT * from mvc_member WHERE id = :id ");
		$stmt->execute(array(':id' => $id));
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}