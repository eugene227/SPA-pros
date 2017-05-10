<?php
require "app.php";
sentry(__FILE__);
$title = "DEVELOPMENT Landing";
require "compose/HTML_head.php";
?>

<div class="w3-bar w3-border w3-light-blue w3-xlarge">
    <span class="w3-bar-item w3-left">
        <?php echo basename(__FILE__); ?>
    </span>
    <span class="w3-bar-item w3-button w3-hover-blue w3-right"
      <?php onclick("{dev-register}");?> >
        Register
    </span>
    <span class="w3-bar-item w3-button w3-hover-blue w3-right"
      <?php onclick("{dev-login}");?>
        >Login
    </span>
</div>

<?php
require "compose/HTML_foot.php";