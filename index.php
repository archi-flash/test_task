<?php

define('MODE', 'production');
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'project1'); 
define('DB_PASSWORD', 'zewGM8XytZU5U4bw');
define('DB_DATABASE', 'project1');  
define('USER_PICTURES_DIR', './user_images/');  

if (MODE=="production") {
    ini_set('display_errors', 0);error_reporting(0);
} else {
    ini_set('display_errors', true);error_reporting(E_ALL ^ E_NOTICE);
}

spl_autoload_register(function ($class_name) {
    include 'classes/'.$class_name . '.class.php';
});

require_once 'utils/errorHandler.php';

set_error_handler('errorHandler', E_ALL);


session_start();

$gIsRegistration = false;

$gErrorMessage = "";

$gUserData = [];

if (isset($_POST["locale"])) {

  $_SESSION["locale"] = $_POST["locale"];

}

$database = new DB();

$dictionary = new Dictionary(isset($_SESSION["locale"]) ? $_SESSION["locale"] : "EN");

$userImage = new UserImage();

$dictionary->create();

if (isset($_SERVER['QUERY_STRING'])) {

    if ("registration" == $_SERVER['QUERY_STRING']) {

        $gIsRegistration = true;

    }

    if ("logout" == $_SERVER['QUERY_STRING']) {

        session_unset();
        session_destroy();
        header("Location: ./");
        exit;

    }
}

// start registration
if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["fullname"]) && isset($_POST["password_confirm"])) {

    if ($database->ifUserExists("SELECT id FROM users WHERE email=?",[$_POST["email"]])){

        $gErrorMessage = $dictionary->getText("user_exists");
 
    } else {

        $user_image_result = $userImage->checkImage(USER_PICTURES_DIR,50000);

        if ($user_image_result["status"]) {
    
            $hashToStoreInDb = password_hash($_POST["password"], PASSWORD_BCRYPT);
            $args = [];
            $args[] = $_POST["email"];
            $args[] = $hashToStoreInDb;
            $args1 = [];
            $args1[] = 0;
            $args1[] = $_POST["fullname"];
            $args1[] = $user_image_result["file"];
            
        
            $args1[0] = $database->register("INSERT INTO users(email,password) VALUES (?,?)",$args);

            if ($args1[0]) {
               $gIsRegistration = false;
               $result = $database->insertuserdata("INSERT INTO users_data(id,fullname,picture) VALUES (?,?,?)",$args1);
            }
        
        } else {
            $gErrorMessage = $dictionary->getText($user_image_result["error"]);
        }

    }

}
// end registration

// start login
if (!$gIsRegistration && isset($_POST["email"]) && isset($_POST["password"])) {


    $args = [$_POST["email"]];
    $stored_data = $database->login("SELECT id,password FROM users WHERE email=?",$args);

    if (!$stored_data) {
        $gErrorMessage = $dictionary->getText("no_such_user");
    } else {
        if (password_verify($_POST["password"], $stored_data[1])) {
            $_SESSION["user_id"] = $stored_data[0];
        } else {
            $gErrorMessage = $dictionary->getText("wrong_password");
        }
    }

}
// end login


// if user loggedin
if (isset($_SESSION["user_id"])) {

    $gUserData = $database->getuser("SELECT fullname,picture FROM users_data WHERE id=?",[$_SESSION["user_id"]]);    
    
}


//main 
include("html/header.html.php");

include("utils/jsVariables.php");

if (isset($_SESSION["user_id"])) {

    include("html/welcome.html.php");

} else {

    include("html/form.html.php");

}

include("html/footer.html.php");
  
?>