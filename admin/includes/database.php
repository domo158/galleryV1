<?php 

require_once("new_config.php");

class Database {
    public $connection;

    function __construct(){
        $this->open_db_connection();
    }

    public function open_db_connection(){
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); // oop

        if($this->connection->connect_errno){
            die("Database connection failed. " . $this->connection->connect_error);
        } 
    }

    public function query($sql){
        $result = $this->connection->query($sql);

        $this->confirm_query($result);

        return $result;
    }

    protected function confirm_query($result){
        if(!$result){
            die("Query Failed. " . $this->connection->connect_error);
        }
    }

    public function escape_string($string){
      
        return $this->connection->real_escape_string($string);
    }


    public function the_insert_id() {
        return mysqli_insert_id($this->connection);
    }

}

$database = new Database();
