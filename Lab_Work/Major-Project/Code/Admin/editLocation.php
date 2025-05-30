<html>
    <head>
        <link rel="stylesheet" href="../Stylesheet.css">
    </head>
    <a href="../index.php" class="button">back</a><br><br>
    
    
    <?php
    include("../functions/database.php"); // Include the database functions
    session_start();

    $locationID = intval($_GET['locationID']); // Retrieve the locationID from the query string
    
    //edit location button function
    if (isset($_POST['editLocation'])) {
        $msg = editLocation($locationID, $_POST["description"], $_POST["stations"], $_POST["costs"]);
    }
    
    $locationData = getLocations($locationID)[0]; //get location data from locationID
    ?>
    <div class="form">
        <h1>Edit Location :</h1>
        <form method="post">
            Description: <input type="text" name="description" value="<?=$locationData["description"]?>"><br><br>
            Charging stations: <input type="number" name="stations" value="<?=$locationData["stations"]?>"><br><br>
            Cost per hour: $<input type="text" name="costs" value ="<?=$locationData["costs"]?>"><br><br>
            <input type="submit" name="editLocation" value="Edit location">
        </form>
        
        <?php
        if (isset($_POST['editLocation'])) {
            echo $msg;
        }
        ?>
    </div>
</html>

<?php

?>