<?php

class User extends Db_object {
    // abstracting the class
    protected static $db_table = "users";
    protected static $db_table_fields = ["id", "username", "password", "first_name", "last_name", "user_image"];
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $user_image;
    public $upload_directory = "images";
    public $image_placeholder = "http://placehold.it/400x400&text=image";
    public $errors = array();
    public $upload_errors_array = array(
        UPLOAD_ERR_OK => "There is no error",
        UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize dir",
        UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the MAX_FILE_SIE directive",
        UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded.",
        UPLOAD_ERR_NO_FILE => "No file was uploaded.",
        UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload."
    );
    // LONG WAY TO INSTANTIATE
    public static function instantiation($found_user){
        $object = new self;

        $object->id = $found_user["id"];
        $object->username = $found_user["username"];
        $object->password = $found_user["password"];
        $object->first_name = $found_user["first_name"];
        $object->last_name = $found_user["last_name"];

        return $object;
    }
    
    public static function auto_instantiation($record){
        $object = new self;

        foreach($record as $column => $column_value){
            if($object->has_the_attribute($column)){
                $object->$column = $column_value;
            }
        }

        return $object;
    }

    public function image_path_and_placeholder() {
        return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory . DS . $this->user_image;
    }

    public function set_file($file) {
        if(empty($file) || !$file || !is_array($file)){
            $this->errors[] = "There was no file uploaded here.";
            return false;
        } elseif($file["error"] != 0) {
            $this->errors[] = $this->upload_errors_array[$file["error"]];
            return false;
        } else {
            $this->user_image = basename($file["name"]); // basename => escape string kind of
            $this->tmp_path = $file["tmp_name"];
            $this->type = $file["type"];
            $this->size = $file["size"];
        }
    }

    public function upload_photo() {
        if(!empty($this->errors)) {
            return false;
        }

        if(empty($this->user_image) || empty($this->tmp_path)){
            $this->errors[] = "The file was not available";
            return false;
        }

        $target_path = SITE_ROOT . DS . "admin" . DS . $this->upload_directory . DS . $this->user_image;

        if(file_exists($target_path)){
            $this->errors[] = "The file {$this->user_image} already exists!";
            return false;
        }
        if(move_uploaded_file($this->tmp_path, $target_path)) {
            unset($this->tmp_path);
            return true;
        } else {
            $this->errors[] = "The file directory probably does not have permission!";
            return false;
        } 
    }
    public function save_user_and_image() {
        
        if($this->id) {
            $this->save();
        } else {
            if(!empty($this->errors)) {
                return false;
            }

            if(empty($this->user_image) || empty($this->tmp_path)){
                $this->errors[] = "The file was not available";
                return false;
            }

            $target_path = SITE_ROOT . DS . "admin" . DS . $this->upload_directory . DS . $this->user_image;

            if(file_exists($target_path)){
                $this->errors[] = "The file {$this->user_image} already exists!";
                return false;
            }
            if(move_uploaded_file($this->tmp_path, $target_path)) {
                if($this->create()) {
                    unset($this->tmp_path);
                    return true;
                }
            } else {
                $this->errors[] = "The file directory probably does not have permission!";
                return false;
            } 
        }
    }

    private function has_the_attribute($the_attribute){
        $object_properties = get_object_vars($this); 
        return array_key_exists($the_attribute, $object_properties); 
    }

    public function find_all_users(){
        global $database;

        return $database->query("SELECT * FROM users");
    }

    static public function static_find_all_users(){
        global $database;

        return $database->query("SELECT * FROM users");
    }

    static public function find_all(){
        return self::find_this_query("SELECT * FROM " . self::$db_table . "");

    }

    public function find_user_by_id($id){
        global $database;
        $result = $database->query("SELECT * FROM users WHERE id=$id");
        $database->confirm_query($result);
        $found_user = mysqli_fetch_array($result);
        return $found_user;
    }

    static public function static_find_user_by_id($id){
        global $database;
        $result_array = self::find_this_query("SELECT * FROM users WHERE id=$id");
        
        return !empty($result_array) ? array_shift($result_array) : false;
        
    }  

    static public function find_by_id($id){
        global $database;
        $result_array = self::find_this_query("SELECT * FROM " . self::$db_table . " WHERE id=$id");

        return !empty($result_array) ? array_shift($result_array) : false;
        
    } 

    public static function verify_user($username, $password) {
        global $database;

        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM users WHERE username='{$username}' AND password='{$password}' LIMIT 1";

        $the_result_array = self::find_this_query($sql);

        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public function ajax_save_user_image($user_image, $user_id) {
        global $database;

        $user_image = $database->escape_string($user_image);
        $user_id = $database->escape_string($user_id);

        $this->user_image = $user_image;
        $this->user_id = $user_id;

        $sql = "UPDATE " . self::$db_table . " SET user_image ='{$this->user_image}' WHERE id={$this->user_id}";
        $update_image = $database->query($sql);

        echo $this->image_path_and_placeholder();
    }

    public function delete_photo() {
        if($this->delete) {
            $target_path = SITE_ROOT . DS . "admin" . DS . $this->upload_directory . DS . $this->user_image;
            return unlink($target_path) ? true : false;
        } else {
            return false;
        }
    }
}

$user = new User();