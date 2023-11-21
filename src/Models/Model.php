<?php
namespace App\Models;

use Opis\Database\Database;
use Opis\Database\Connection;
use PDO;

abstract class Model
{
    protected $db;
    protected $table;

    public function __construct($conn, $tbName)
    {
        $this->db = $conn;
        $this->table = $tbName;
    }

    function getAll() : array
    {
        $result = $this->db->from($this->table)
            ->select()
            ->fetchAssoc()
            ->all();

        return  $result;

    }

    function getById ($id) : array
    {
        $result = $this->db->from($this->table)
            ->where('Id')->is($id)
            ->select()
            ->fetchAssoc()
            ->first();

        return $result;
    }

    function delete($id){
        $result = $this->db->from($this->table)
            ->where('Id')->is($id)
            ->delete();
    }

}