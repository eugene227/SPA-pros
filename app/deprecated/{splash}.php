<?php
require "app.php";
sentry(__FILE__);

$title = "Splash!";
require "compose/HTML_head.php";
?>

<div class="w3-bar w3-border w3-light-blue">
  <span class="w3-bar-item w3-button w3-hover-blue w3-right"
    <?php onclick("{login}"); ?>
        >Login</span>
</div>


<div class="w3-row w3-blue">
  <div class="w3-col m4 l3 w3-right-align">
    <h1>PRS</h1>
    <h4>David Richards</h4>
    <h4>Wayne Woods</h4>
    <h4>Yevgen Shapovalov</h4>
    <h4>Jacob Ruff</h4>
  </div>
  <div class="w3-col m1 l1 w3-center">
    <h1>|</h1>
    <h4>|</h4>
    <h4>|</h4>
    <h4>|</h4>
    <h4>|</h4>
  </div>
  <div class="w3-col m7 l8">
  <h1>Peer Review System</h1>
    <h4>Lead Developer</h4>
    <h4>Developer / Project Manager</h4>
    <h4>Lead Designer</h4>
    <h4>API Developer</h4>
  </div>
</div>

<?php
require "compose/HTML_foot.php";
