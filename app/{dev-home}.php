<?php
require "app.php";
sentry(__FILE__);
$title = "DEVELOPMENT Login";
require "compose/HTML_head.php";
?>

<div class="w3-bar w3-border w3-light-blue w3-xlarge">
    <span class="w3-bar-item w3-left">
        <?php echo basename(__FILE__); ?>
    </span>
    <span class="w3-bar-item"><?php echo "[{$_SESSION["user"]}]"; ?></span>
    <span class="w3-bar-item w3-button w3-hover-blue w3-right"
        <?php onclick("{exec-logout}");?> >
        Logout
    </span>
</div>

<div class="w3-container w3-teal">
    <h3>Home</h3>
</div>

<div class="w3-bar w3-border w3-light-blue w3-xlarge">
  <span class="w3-bar-item">[Home]</span>
</div>

<?php
require "compose/HTML_foot.php";
