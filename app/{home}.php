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

<div class="w3-bar w3-black">
    <button class="w3-bar-item w3-button tablink w3-teal"
     onclick="openTab(event,'ToDo')">To Do</button>
    <button class="w3-bar-item w3-button tablink"
     onclick="openTab(event,'Assets')">Assets</button>
    <button class="w3-bar-item w3-button tablink"
     onclick="openTab(event,'Oversight')">Oversight</button>
</div>

<div id="ToDo" class="tab">
    <div class="w3-container w3-teal">
        <h3>Evaluations</h3>
        <p>[List of pending evaluations to complete.]</p>
    </div>
</div>

<div id="Assets" class="tab" style="display:none">
    <div class="w3-container w3-teal">
        <h3>Surveys</h3>
        <p>[List of available surveys.]</p>
    </div>
    <div class="w3-container w3-teal">
        <h3>Questions</h3>
        <p>[List of available questions.]</p>
    </div>
    <div class="w3-container w3-teal">
        <h3>Choice Lists</h3>
        <p>[List of available choice lists.]</p>
    </div>
</div>

<div id="Oversight" class="tab" style="display:none">
    <div class="w3-container w3-teal">
        <h3>Surveys</h3>
        <p>[List of surveys overseen by user.]</p>
    </div>
    <div class="w3-container w3-teal">
        <h3>Text Analysis Warnings</h3>
        <p>[List of text analysis warnings.]</p>
    </div>
</div>

<script>

function openTab(evt, tabName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("tab");
  for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" w3-teal", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " w3-teal";
}

</script>

  



<?php
require "compose/HTML_foot.php";
