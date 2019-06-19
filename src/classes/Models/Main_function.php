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
    
    public function check_login($email,$password) {
    	$stmt = $this->db->prepare("SELECT * from mvc_member WHERE email = :email AND password = :password  ");
		$stmt->execute(array(':password' => $password,':email' => $email));
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
        
    public function insert_member($menu_name,$part_menu) {
        $sth = $this->db->prepare('INSERT into mvc_menu (menu_name, part_menu,status) values (:menu_name, :part_menu ,1)');
        $this->db->beginTransaction(); 
        $sth->execute(array(':menu_name' => $menu_name,':part_menu' => $part_menu)); 

        $this->db->commit(); 
    }

    public function update_member($menu_name,$part_menu) {

        $sth = $this->db->prepare('UPDATE mvc_menu SET menu_name=:menu_name , part_menu=:part_menu WHERE id=:id');
        $this->db->beginTransaction(); 
        $sth->execute(array(':menu_name' => $menu_name,':part_menu' => $part_menu ,':id' => '2')); 
        $this->db->commit(); 
    }

    public function get_data_in_db($table) {
        return $this->db->query("SELECT * from {$table} ")->fetchAll(\PDO::FETCH_OBJ);
    }
    public function edit_function($id) {
        $stmt = $this->db->prepare("SELECT * from mvc_menu WHERE id = :id ");
		$stmt->execute(array(':id' => $id));
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
}