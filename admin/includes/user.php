<?php
class User
{
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;

    public static function find_all_users()
    {
        return self::find_this_query("SELECT * FROM users");
    }

    public static function find_user_by_id($user_id)
    {
        global $database;
        $the_result_array = self::find_this_query("SELECT * FROM users WHERE id = $user_id LIMIT 1");
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

    public static function find_this_query($query)
    {
        global $database;
        $result_set = $database->query($query);

        $the_object_array = array();

        while($row = mysqli_fetch_array($result_set))
        {
            $the_object_array[] = self::instantiation($row);
        }

        return $the_object_array;
    }

    public static function verify_user($username, $password)
    {
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM users WHERE ";
        $sql .= "username = '{$username}' ";
        $sql .= "AND password ='{$password}' ";
        $sql .= "LIMIT 1";

        $the_result_array = self::find_this_query($sql);
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public static function instantiation($user_record)
    {
        $the_user_object = new self;

//        $the_user_object->id            = $found_user['id'];
//        $the_user_object->username      = $found_user['username'];
//        $the_user_object->password      = $found_user['password'];
//        $the_user_object->first_name    = $found_user['first_name'];
//        $the_user_object->last_name     = $found_user['last_name'];

        foreach($user_record as $key => $value)
        {
            if($the_user_object->has_the_attribute($key))
            {
                $the_user_object->$key = $value;
            }
        }
        return $the_user_object;

    }

    //CRUD Methods
    public function create()
    {
        global $database;

        $sql = "INSERT INTO users (username, password, first_name, last_name) ";
        $sql .= "VALUES ('";
        $sql .= $database->escape_string($this->username) . "', '";
        $sql .= $database->escape_string($this->password) . "', '";
        $sql .= $database->escape_string($this->first_name) . "', '";
        $sql .= $database->escape_string($this->last_name) . "')";

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

        $sql = "UPDATE users SET ";
        $sql .= "username= '" . $database->escape_string($this->username) . "', ";
        $sql .= "password= '" . $database->escape_string($this->password) . "', ";
        $sql .= "first_name= '" . $database->escape_string($this->first_name) . "', ";
        $sql .= "last_name= '" . $database->escape_string($this->last_name) . "'";
        $sql .= " WHERE id= " . $database->escape_string($this->id);

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;

    }
    //End of CRUD Methods

    private function has_the_attribute($attribute)
    {
        $user_properties = get_object_vars($this);

        return array_key_exists($attribute, $user_properties);
    }
}//End of User Class
?>

