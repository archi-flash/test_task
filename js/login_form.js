$(document).ready(function()
{
    $("body").mouseup(function(){ 
        $("#alert").hide();
    });

    $('input[type=file]').bind('change', function() {
        var str = "";
        str = $(this).val();
        console.log(str);
        $("#filename").text(str.split("\\").slice(-1)[0]);
    }).change();

});



function doLogin(){
    if(formIsValid("login")){
        $("#login_form").submit();
    }
}
function doRegister(){
    if(formIsValid("register")){
        $("#login_form").submit();
    }
}
function formIsValid(mode){    
    var email = $("#email").val();
    var password = $("#password").val();
    var confirmation_password = "";
    var fullname = "";

    if (!validateEmail(email)){
        showError(jsVarEmail);
        return false;
    }
    if (!validatePassword(password)){
        showError(jsVarPassword);
        return false;
    }
    if(mode=="register"){

        confirmation_password = $("#password_confirm").val();
        fullname = $("#fullname").val();

        if(!matchPasswords(password,confirmation_password)){
            showError(jsVarPasswordsNotMatch);
            return false;
        }
        if (!validateFullname(fullname)){
            showError(jsVarFullname);
            return false;
        }
        if(!$("#terms").is(':checked')){
            showError(jsVarTerms);
            return false;
        }
    }

    $("#alert").hide();
    return true;
}
function showError(val){
    $("#alert").show();
    $("#alert_message").html(val);
}
function validateEmail(val){
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(val);
}
function validatePassword(val){
    // at least one number, one lowercase and one uppercase letter
    // at least six characters
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
    return re.test(val);
}
function matchPasswords(val1,val2){
   return val1===val2;
}
function validateFullname(val){
    reg =  /^[а-яА-ЯёЁa-zA-Z- ]*$/;
    return reg.test(val);
}
function switchLanguage(locale){
    var form = $(document.createElement('form'));
    $(form).attr("action", "");
    $(form).attr("method", "POST");

    var input = $("<input>")    
    .attr("type", "hidden")
    .attr("name", "locale")
    .val(locale);

    $(form).append($(input));
    form.appendTo( document.body);
    $(form).submit();
}