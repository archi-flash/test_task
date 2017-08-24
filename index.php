<?php

define('MODE', 'production');
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'project1'); 
define('DB_PASSWORD', 'zewGM8XytZU5U4bw');
define('DB_DATABASE', 'project1');  
define('USER_PICTURES_DIR', './user_images/');  

if(MODE=="production"){
    ini_set('display_errors', 0);error_reporting(0);
}else{
    ini_set('display_errors', true);error_reporting(E_ALL ^ E_NOTICE);
}

require_once 'inc/db.class.php';
require_once 'inc/userImage.class.php';
require_once 'inc/dictionary.class.php';
require_once 'inc/errorHandler.php';

set_error_handler('errorHandler', E_ALL);

session_start();

$gIsRegistration = false;
$gErrorMessage = "";
$gUserData = [];

if(isset($_POST["locale"])){
  $_SESSION["locale"] = $_POST["locale"];
}

Dictionary::create(isset($_SESSION["locale"]) ? $_SESSION["locale"] : "EN");

if(isset($_SERVER['QUERY_STRING'])){

    if("registration" == $_SERVER['QUERY_STRING']){
        $gIsRegistration = true;
    }

    if("logout" == $_SERVER['QUERY_STRING']){
        session_unset();
        session_destroy();
        header("Location: ./");
        exit;
    }
}

// start registration
if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["fullname"]) && isset($_POST["password_confirm"])){

    DB::connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    if(DB::ifUserExists("SELECT id FROM users WHERE email=?",[$_POST["email"]])){

        $gErrorMessage = Dictionary::getText("user_exists");
 
    }else{
        $user_image_result = UserImage::checkImage(USER_PICTURES_DIR,50000);
        if($user_image_result["status"]){
    
            $hashToStoreInDb = password_hash($_POST["password"], PASSWORD_BCRYPT);
            $args = [];
            $args[] = $_POST["email"];
            $args[] = $hashToStoreInDb;
            $args1 = [];
            $args1[] = 0;
            $args1[] = $_POST["fullname"];
            $args1[] = $user_image_result["file"];
            
        
            $args1[0] = DB::register("INSERT INTO users(email,password) VALUES (?,?)",$args);
            if($args1[0]){
               $gIsRegistration = false;
               $result = DB::insertuserdata("INSERT INTO users_data(id,fullname,picture) VALUES (?,?,?)",$args1);
            }
        
        }else{
            $gErrorMessage = Dictionary::getText($user_image_result["error"]);
        }
    }

    DB::close();
}
// end registration

// start login
if(!$gIsRegistration && isset($_POST["email"]) && isset($_POST["password"])){

    DB::connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $args = [$_POST["email"]];
    $stored_data = DB::login("SELECT id,password FROM users WHERE email=?",$args);

    if(!$stored_data){
        $gErrorMessage = Dictionary::getText("no_such_user");
    }else{
        if(password_verify($_POST["password"], $stored_data[1])){
            $_SESSION["user_id"] = $stored_data[0];
        }else{
            $gErrorMessage = Dictionary::getText("wrong_password");
        }
    }

    DB::close();
}
// end login


// if user loggedin
if(isset($_SESSION["user_id"])){

    DB::connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $args = [$_SESSION["user_id"]];
    $gUserData = DB::getuser("SELECT fullname,picture FROM users_data WHERE id=?",$args);    
    
    DB::close();
}


//main 
include("html/header.html.php");

include("inc/jsVariables.php");

if(isset($_SESSION["user_id"])){

    include("html/welcome.html.php");

}else{

    include("html/form.html.php");

}

include("html/footer.html.php");
