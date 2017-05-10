<?php
require "app.php";
sentry(__FILE__);
$title = "DEVELOPMENT Home";
require "compose/HTML_head.php";
?>

<div class="w3-bar w3-border w3-light-blue w3-xlarge">
  <span class="w3-bar-item">[Home]</span>
  <span class="w3-bar-item"><?php echo "({$_SESSION["user"]})"; ?></span>
  <span class="w3-bar-item w3-button w3-hover-blue w3-right"
    <?php onclick("{exec-logout}");?>
        >Logout</span>
</div>

<?php
require "compose/HTML_foot.php";
