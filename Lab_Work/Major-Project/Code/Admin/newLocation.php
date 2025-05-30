<html>
    <head>
        <link rel="stylesheet" href="../Stylesheet.css">
    </head>
    <a href="../index.php" class="button">back</a><br><br>
    <div class="form">
        <h1>Create a new Location</h1>
        <form method="POST">
            Description: <input type="text" name="description"><br><br>
            Charging stations: <input type="number" name="stations"><br><br>
            Cost per hour: $<input type="text" name="costs"><br><br>
            <input type="submit" name="addLocation" value="Add location">
        </form>

        <?php
        include("../functions/database.php"); // Include the database functions
        
        //add location button function
        if (isset($_POST['addLocation'])) addLocation($_POST["description"], $_POST["stations"], $_POST["costs"]);
        ?>
    </div>
</html>

