<?php
class UserImage
{                  

    public static function checkImage($dir,$size){
        
        if($_FILES['userfile']['size']>$size){

               return ["status"=>0,"error"=>"file_too_big"];

        }
        if($_FILES['userfile']['size']>0){

            $imageinfo = getimagesize($_FILES['userfile']['tmp_name']);

            if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png') {

               return ["status"=>0,"error"=>"type_not_allowed"];

            }

            $name = time().".".self::getExt($imageinfo['mime']);

            if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $dir.$name)){

               return ["status"=>1,"file"=>$name];

            }else{

               return ["status"=>0,"error"=>"type_not_allowed"];

            }

        }else{

               return ["status"=>1,"file"=>""];

        }  
    }     
    private static function getExt($val){

        switch($val){

            case "image/gif":
                return "gif";
            break;

            case "image/png":
                return "png";
            break;

            default:
                return "jpg";
            break;
        }
    }

}
?>