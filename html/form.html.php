<div id="main">


    <div class="login_form">

    <div id="alert">
       <div class="alert_inner">
           <div class="alert_message" id="alert_message">
           </div>
       </div>
    </div>

    <form action="<?=($gIsRegistration ? "?registration" : "?")?>" id="login_form" method="POST"  enctype="multipart/form-data">
        <div id="language_selector">

<?php 
$langs = Dictionary::getLanguages();
foreach($langs as $lang){
    echo ' <a href="#" class="a13px" onClick="switchLanguage(\''.$lang.'\');return false;">'.$lang.'</a>';
}
?>
        </div>

        <div id="form_title"><?=Dictionary::getText($gIsRegistration ? "registration" : "sign_in")?></div>

        <div class="form_group">
            <div class="form_label">
                E-Mail
            </div>
            <div class="form_input">
                <input type="text" placeholder="@" class="form_control" id="email" name="email" tabindex="1">
            </div>
        </div>

        <div class="form_group">
            <div class="form_label">
                <?=Dictionary::getText("password")?>
            </div>
            <div class="form_input">
                <input type="password" placeholder="*****" class="form_control" id="password" name="password" tabindex="2">
            </div>
        </div>

<?php if($gIsRegistration){ ?>

        <div class="form_group">
            <div class="form_label">
                <?=Dictionary::getText("password")?>
            </div>
            <div class="form_input">
                <input type="password" placeholder="*****" class="form_control" id="password_confirm" name="password_confirm" tabindex="3">
            </div>
        </div>

        <div class="form_group">
            <div class="form_label">
                <?=Dictionary::getText("fullname")?>
            </div>
            <div class="form_input">
                <input type="text" placeholder="<?=Dictionary::getText("fullname")?>" class="form_control" id="fullname" name="fullname" tabindex="4">
            </div>
        </div>
        <div class="form_group">
            <div class="form_file">
                <label for="file-upload" class="custom-file-upload">
                <i class="fa fa-cloud-upload"></i> <?=Dictionary::getText("choose_file")?>
                </label>
                <input type="hidden" name="MAX_FILE_SIZE" value="300000">
                <input id="file-upload" name="userfile" type="file" accept="image/x-png,image/gif,image/jpeg"/><span id="filename"></span>
            </div>
        </div>
        <div class="form_group">
            <div class="terms_checkbox">
                <input type="checkbox" id="terms" name="terms"><?=Dictionary::getText("terms")?>
            </div>
        </div>

<?php }  ?>

        <div class="form_submit">
             <a href="#" onClick="<?=($gIsRegistration ? "doRegister" : "doLogin")?>();return false" class="form_button"><?=Dictionary::getText($gIsRegistration ? "ok" : "login")?></a>&nbsp;&nbsp;&nbsp;&nbsp;
             <a href="<?=($gIsRegistration ? "?" : "?registration")?>"><?=Dictionary::getText($gIsRegistration ? "or_login" : "or_register")?></a>
        </div>
        <div id="error_message"><?=$gErrorMessage?></div>
    </form>
    </div>
</div>