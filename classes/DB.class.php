<?php

class DB
{                  
    public static $conn;

    public function __construct()
    {

        self::connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    }
    public function __destruct()
    {

        self::close();

    }
    public function connect($host, $user, $pass, $name)
    {
        try{

            self::$conn = new mysqli($host, $user, $pass, $name);

        } catch (Exception $e) {

            trigger_error("USER ERROR : ".$e->getMessage(), E_USER_ERROR);

        }

        if (self::$conn->connect_errno) {

            trigger_error("USER ERROR : (" . self::$conn->errno . ") " . self::$conn->error, E_USER_ERROR);

        }		

        return self::$conn;
    }

    public function register($sql,$args)
    {
        
        if ($stmt = self::$conn->prepare($sql)) {
            
	    $stmt->bind_param('ss', $args[0], $args[1]);

	    if (!$stmt->execute()) {
                trigger_error("USER ERROR : (" . $stmt->errno . ") " . $stmt->error, E_USER_ERROR);
            }

	    $stmt->close();
	    
	    return self::$conn->insert_id;

        }else{

            trigger_error("USER ERROR : (" . self::$conn->errno . ") " . self::$conn->error, E_USER_ERROR);

	}
    }

    public function ifUserExists($sql,$args)
    {
        
        if ($stmt = self::$conn->prepare($sql)){
            
	    $stmt->bind_param('s', $args[0]);

	    if (!$stmt->execute()) {
                trigger_error("USER ERROR : (" . $stmt->errno . ") " . $stmt->error, E_USER_ERROR);
            }

            $stmt->store_result();

            $rows = $stmt->num_rows;

	    $stmt->close();
	    
	    return $rows>0;

        } else {

            trigger_error("USER ERROR : (" . self::$conn->errno . ") " . self::$conn->error, E_USER_ERROR);

	}
    }

	
    public function insertuserdata($sql,$args)
    {
        
        if ($stmt = self::$conn->prepare($sql)){
            
	    $stmt->bind_param('iss', $args[0], $args[1], $args[2]);

	    if (!$stmt->execute()) {
                trigger_error("USER ERROR : (" . $stmt->errno . ") " . $stmt->error, E_USER_ERROR);
            }
	
	    $stmt->close();
	    
	    return self::$conn->insert_id;

        } else {

            trigger_error("USER ERROR : (" . self::$conn->errno . ") " . self::$conn->error, E_USER_ERROR);

	}
    }	

    public function login($sql,$args)
    {
        
        if ($stmt = self::$conn->prepare($sql)){
             
	    $stmt->bind_param('s', $args[0]);

	    if (!$stmt->execute()) {
                trigger_error("USER ERROR : (" . $stmt->errno . ") " . $stmt->error, E_USER_ERROR);
            }

            $result = $stmt->get_result();

            $row = $result->fetch_row();
	    
	    $stmt->close();
	    
	    return is_null($row) ? false : $row;

        } else {

            trigger_error("USER ERROR : (" . self::$conn->errno . ") " . self::$conn->error, E_USER_ERROR);	    

        }	

    }

    public function getuser($sql,$args)
    {
        
        if ($stmt = self::$conn->prepare($sql)){
             
	    $stmt->bind_param('s', $args[0]);

	    if (!$stmt->execute()){

                trigger_error("USER ERROR : (" . $stmt->errno . ") " . $stmt->error, E_USER_ERROR);

            }

            $result = $stmt->get_result();

            $row = $result->fetch_assoc();
	    
	    $stmt->close();
	    
	    return is_null($row) ? false : $row;

        }else{

            trigger_error("USER ERROR : (" . self::$conn->errno . ") " . self::$conn->error, E_USER_ERROR);	    

        }	

    }

    public function close()
    {

        return mysqli_close(self::$conn);

    }

}
?>