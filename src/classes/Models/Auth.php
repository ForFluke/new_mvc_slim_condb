<?php
namespace App\Models;

use App\Database\DatabaseInterface as DB;

class Auth
{
    protected $db;

    public function __construct(DB $db) {
         $this->db = $db;
    }


}