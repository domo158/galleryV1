<?php 

class Db_object {

    protected static $db_table;
    protected static $db_table_fields;

    static public function find_all(){
        return static::find_this_query("SELECT * FROM " . static::$db_table . "");

    }

    static public function find_by_id($id){
        global $database;

        // $db_table_singular = substr(static::$db_table, 0, -1);

        $result_array = static::find_this_query("SELECT * FROM " . static::$db_table . " WHERE id=$id");

        return !empty($result_array) ? array_shift($result_array) : false;
        
    }  

    static public function find_this_query($sql){
        global $database;
        $result = $database->query($sql);
        $object_array = [];

        while($row = mysqli_fetch_array($result)){
            $object_array[] = static::auto_instantiation($row);
        }
        return $object_array;
    }

    public static function auto_instantiation($record){
        $calling_class = get_called_class();
        $object = new $calling_class;

        foreach($record as $column => $column_value){
            if($object->has_the_attribute($column)){
                $object->$column = $column_value;
            }
        }

        return $object;
    }

    private function has_the_attribute($the_attribute){
        $object_properties = get_object_vars($this); 
        return array_key_exists($the_attribute, $object_properties); 
    }

    protected function properties() {
        $properties = [];
        
        foreach(static::$db_table_fields as $db_field) {
            if(property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }
        
        return $properties;
    }

    protected function clean_properties() {
        global $database;

        $clean_properties = [];

        foreach($this->properties() as $key => $value) {
            $clean_properties[$key] = $database->escape_string($value);
        }

        return $clean_properties;
    }


    public function save() {
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function create() {
        global $database;

        $properties = $this->clean_properties();

        $sql = "INSERT INTO " . static::$db_table . " (" . implode(",", array_keys($properties)) . ") 
                VALUES('" . implode("','", array_values($properties)) . "')";

        if($database->query($sql)){
            $this->id = $database->the_insert_id();
            
            return true;
        } else {
            return false;
        }
    }

    public function update() {
        global $database;

        $properties = $this->clean_properties();

        $properties_pairs = [];

        foreach($properties as $key => $value) {
            $properties_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . static::$db_table . " SET " . implode(",", $properties_pairs) . 
                                " WHERE id=" . $database->escape_string($this->id);

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false; 
                                 
    }

    public function delete() {
        global $database;

        $sql = "DELETE FROM " . static::$db_table . " WHERE id=" . $database->escape_string($this->id);
        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public static function count_all() {
        global $database;
        $sql = "SELECT COUNT(*) FROM " . static::$db_table;
        $result_set = $database->query($sql);

        $row = mysqli_fetch_array($result_set);

        return array_shift($row);
    }

}

?>