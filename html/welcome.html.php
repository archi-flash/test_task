<div class="welcome">
 <?=$dictionary->getText("welcome")?>
 <?=$gUserData["fullname"]?>
 <?php if($gUserData["picture"]!=""){ ?>
 <br><br>
 <img height="100px" src="<?=USER_PICTURES_DIR.$gUserData["picture"]?>">
 <?php } ?>
 <br><br><br>
 <a href="?logout"><?=$dictionary->getText("logout")?></a>
</div>