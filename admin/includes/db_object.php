<?php
class Db_object
{
    public static function find_all()
    {
        return static::find_by_query("SELECT * FROM" . static::$db_table . " ");
    }

    public static function find_by_id($user_id)
    {
        global $database;
        $the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table ." WHERE id = $user_id LIMIT 1");
        if(!empty($the_result_array))
        {
            $first_item = array_shift($the_result_array);//grab first item from array
            return $first_item;
        }
        else
        {
            return false;
        }
    }

    public static function find_by_query($query)
    {
        global $database;
        $result_set = $database->query($query);

        $the_object_array = array();

        while($row = mysqli_fetch_array($result_set))
        {
            $the_object_array[] = static::instantiation($row);
        }

        return $the_object_array;
    }

    public static function instantiation($user_record)
    {
        $calling_class = get_called_class();
        $the_user_object = new $calling_class;

        foreach($user_record as $key => $value)
        {
            if($the_user_object->has_the_attribute($key))
            {
                $the_user_object->$key = $value;
            }
        }
        return $the_user_object;

    }

    public function save()
    {
        return isset($this->id) ? $this->update() : $this->create();
    }

    //CRUD Methods
    public function create()
    {
        global $database;

        $properties = $this->clean_properties();

        $sql = "INSERT INTO " .static::$db_table . "(" . implode(",", array_keys($properties)) . ") ";
        $sql .= "VALUES ('". implode("','", array_values($properties)) ."')";


        if( $database->query($sql))
        {
            $this->id = $database->the_insert_id();
            return true;
        }
        else
        {
            return false;
        }
    }

    public function update()
    {
        global $database;
        $properties = $this->clean_properties();
        $properties_pairs = array();

        foreach($properties as $key => $value)
        {
            $properties_pairs[] = "{$key}='{$value}'";
        }


        $sql = "UPDATE " .static::$db_table . "  SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE id= " . $database->escape_string($this->id);

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public function delete()
    {
        global $database;
        $sql = "DELETE FROM " .static::$db_table . " ";
        $sql .= "WHERE id=" . $database->escape_string($this->id);
        $sql .= " LIMIT 1";

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }
    //End of CRUD Methods

    private function has_the_attribute($attribute)
    {
        $user_properties = get_object_vars($this);

        return array_key_exists($attribute, $user_properties);
    }

    protected function properties()
    {
        $properties = array();
        foreach(static::$db_table_fields as $db_field)
        {
            if(property_exists($this, $db_field))
            {
                $properties[$db_field] = $this->$db_field;
            }
        }

        return $properties;
    }

    protected function clean_properties()
    {
        global $database;
        $clean_properties = array();

        foreach($this->properties() as $key => $value)
        {
            $clean_properties[$key] = $database->escape_string($value);
        }
        return $clean_properties;
    }
}
?>