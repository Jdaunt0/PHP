<?php 
include("functions/accountFunctions.php"); //include the account functions
session_start(); //start the session

//Make sure DB and tables Exist
createDB(); 
createTableUsers();
createTableLocations();
createTableVisits();

$isLoggedIn = isset($_SESSION["userID"]); //if UserID in session, the user is logged in
?>

<html>
    <head>
        <link rel="stylesheet" href="Stylesheet.css">
    </head>

    <header>
        <h1 id="header">Easy Ev Charging</h1>
    
        <?php 
        if (!$isLoggedIn) { //if user is logged in
            echo '<p class="userMenu"> You are not logged in. '
                . '<a href="login.php">Login</a>'
                . '</p>';
        } else { //if user is logged in
            echo '<form method="post" class="userMenu">'
                .      "Welcome: ". $_SESSION["name"] . "&nbsp" // Username
                .      '<input type="submit" name="logout" value="Logout"> <br>' //logout button
                . '</form>'; 
                
            if (isset($_POST['logout'])) logout(); //logout button function
        }
        ?>
    </header>

    <body>
        <div class="centercontainer">
            <?php
            
            if ($isLoggedIn) { //if user is logged in
                if($_SESSION["type"] == 1){ // 1 = user
                    include("User/userPage.php");
                }else if($_SESSION["type"] == 0){ // 0 = admin
                    include("Admin/adminPage.php");
                }
            }else{ //if user is logged in
                echo "<div class='mainPage'>"
                    .   "<div style='text-align:center;'>"
                    .       "<h3>Welcome to Easy Ev Charging!</h3> <br>"
                    .       "<p>Please <a href='login.php'>login</a> or <a href='register.php'>register</a> to use the system.<p>"
                    .   "</div>"
                    . "</div>";
            }
            ?>
        </div>
    </body>
</html>