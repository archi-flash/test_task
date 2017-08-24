<?php
class Dictionary
{                  
    public static $dictionary;
    public static $languages = ["RU","EN"];

    public static function getLanguages(){
        return self::$languages;
    }
    public static function create($locale){

        self::$dictionary = [];

        switch($locale){

            case "RU":
               self::$dictionary["sign_in"] = "Вход";
               self::$dictionary["login"] = "Войти";
               self::$dictionary["email"] = "E-mail";
               self::$dictionary["password"] = "Пароль";
               self::$dictionary["or_register"] = "или зарегистрируйтесь";
               self::$dictionary["or_login"] = "или войдите";
               self::$dictionary["registration"] = "Регистрация";
               self::$dictionary["fullname"] = "ФИО";
               self::$dictionary["ok"] = "OK";
               self::$dictionary["email_not_valid"] = "Вы ввели невалидный e-mail!";
               self::$dictionary["password_not_valid"] = "Вы ввели невалидный пароль!<br>Пароль должен содержать хотя бы одну прописную и одну строчную букву, а также цифру. И не менее 6 символов.";
               self::$dictionary["fullname_not_valid"] = "Вы ввели невалидные ФИО!";
               self::$dictionary["passwords_not_match"] = "Пароли не совпадают!";
               self::$dictionary["no_such_user"] = "Пользователь не существует.";
               self::$dictionary["wrong_password"] = "Неверный пароль.";
               self::$dictionary["welcome"] = "Добрый день,<br>";
               self::$dictionary["logout"] = "Выйти";
               self::$dictionary["terms"] = "Отметьте здесь, что Вы прочли и согласны с условиями";
               self::$dictionary["please_check_terms"] = "Пожалуйста, примите условия.";
               self::$dictionary["choose_file"] = "Выбрать файл";
               self::$dictionary["type_not_allowed"] = "Вы загружаете запрещенный тип файла. Допустимые типы JPG, PNG или GIF.";
               self::$dictionary["file_too_big"] = "Слишком большой файл (>50Kb)";
               self::$dictionary["user_exists"] = "Пользователь с таким e-mail уже существует, воспользуйтесь опцией восстановления пароля.";
            break;

            default;
               self::$dictionary["sign_in"] = "Sign in";
               self::$dictionary["login"] = "Login";
               self::$dictionary["email"] = "E-mail";
               self::$dictionary["password"] = "Password";
               self::$dictionary["or_login"] = "or login";
               self::$dictionary["registration"] = "Registration";
               self::$dictionary["or_register"] = "or register";
               self::$dictionary["fullname"] = "Full name";
               self::$dictionary["ok"] = "OK";
               self::$dictionary["email_not_valid"] = "Not a valid email address!";
               self::$dictionary["password_not_valid"] = "Not a valid password!<br>Password must contain at least one number, one lowercase and one uppercase letter. And at least six characters.";
               self::$dictionary["fullname_not_valid"] = "Not a valid fullname!";
               self::$dictionary["passwords_not_match"] = "Password does not match the confirm password!";
               self::$dictionary["no_such_user"] = "User unknown.";
               self::$dictionary["wrong_password"] = "Wrong password.";
               self::$dictionary["welcome"] = "Welcome,<br>You are ";
               self::$dictionary["logout"] = "Logout";
               self::$dictionary["terms"] = "Check here to indicate that you have read and agree to the terms";
               self::$dictionary["please_check_terms"] = "Please, check terms checkbox.";
               self::$dictionary["choose_file"] = "Choose pic";
               self::$dictionary["type_not_allowed"] = "Uploaded file is not a valid image. Only JPG, PNG and GIF files are allowed.";
               self::$dictionary["file_too_big"] = "File too big (>50Kb)";
               self::$dictionary["user_exists"] = "A user with this e-mail address already exists, please try the forgot password option.";
            break;
        }
        return self::$dictionary;
    }

    public static function getText($key){

        if(self::$dictionary[$key]){
            return self::$dictionary[$key];
        }else{
            return "[No translation]";
        }
    }
}
?>