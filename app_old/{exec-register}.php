<?php
require "app.php";
sentry(__FILE__);
$title = "DEVELOPMENT Register";
require "compose/HTML_head.php";
// echo dump($_REQUEST); // DEBUG
$validation = (array_key_exists("*VALID*", $_REQUEST));
$first_name = ($validation) ? $_REQUEST["first_name"] : "";
$last_name  = ($validation) ? $_REQUEST["last_name"] : "";
$email      = ($validation) ? $_REQUEST["email"] : "";
$password   = ($validation) ? $_REQUEST["password"] : "";
if ($validation) {
    echo "<div class=\"w3-container w3-red\">";
    foreach ($_REQUEST["*VALID*"] as $input => $valid) {
        if ($valid) {continue;}
        echo "<h4>";
        echo $_REQUEST["*EMPTY_MSG*"][$input];
        echo "</h4>";
    }
    echo "</div>";
}
?>


<div class="w3-row">    <!--Register screen-->  
    
      <div class="w3-col w3-container w3-hide-small" style="width:20%"></div>
      
      <div class="w3-col w3-container w3-mobile" style="width:60%">
                      
            <header class="w3-blue w3-card-4">

                <h3 class="w3-xlarge w3-padding">Create New Account</h3>

            </header>
      
          <form class="w3-container w3-card-4" method="post" action="event.php">

             
            <p class="w3-large">First Name:</p>
            <input class="w3-input w3-animate-input" autofocus type="text" style="width:60%" tabindex="1" required name="first_name" value="<?php echo htmlentities($first_name); ?>">

            <p class="w3-large">Last Name:</p>
            <input class="w3-input w3-animate-input" required type="text" style="width:60%" tabindex="2" name="last_name" value="<?php echo htmlentities($last_name); ?>">

            <p class="w3-large">Email</p>
            <input class="w3-input w3-animate-input" type="email" style="width:60%" tabindex="3" name="email" required autocomplete="on" value="<?php echo htmlentities($email); ?>">

            <p class="w3-large">Create a Password</p>
            <input class="w3-input w3-animate-input" type="password"style="width:60%" tabindex="4" required name="password" value="<?php echo htmlentities($password); ?>">

            <p class="w3-large">Retype Password</p>
            <input class="w3-input w3-margin-bottom w3-animate-input" type="password" required tabindex="5" style="width:60%">
            
            <button type="submit" class="w3-btn w3-right w3-padding w3-margin w3-green" tabindex="6" name="{exec-register}">Sign Up</button>
            
        
         </form><!--end of card container-->
      
      
      </div>
      
      <div class="w3-col w3-container w3-hide-small" style="width:20%"></div>
      
</div><!--END Register screen-->

<?php
require "compose/HTML_foot.php";
