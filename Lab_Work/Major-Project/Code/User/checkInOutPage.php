<html>
    <head>
        <link rel="stylesheet" href="../Stylesheet.css">
    </head>
    <a href="../index.php" class="button">back</a><br><br>

    <div class="form">
        <?php 
        include("../functions/database.php");
        session_start();

        $locationID = intval($_GET['locationID']); // Retrieve the locationID from the query string
        $locationData = getLocations($locationID)[0]; //get location data from locationID

        $time = date("H:i:s m-d");
        
        $visits = getVisits($_SESSION["userID"], $locationID);
        $isCheckedIn = !empty($visits); // If there are active visits, the user is checked in
        
        echo "<h1>Check " . ($isCheckedIn ? 'Out: ' : 'In: ') . "</h1>";
        echo "<table>"
        .       "<tr>"
        .           "<td> ID: </td>"
        .           "<td>" .$locationData["locationID"]."</td>"
        .       "</tr>"
        .       "<tr>"
        .           "<td>Description: </td>" 
        .           "<td>" . $locationData["description"]."</td>"
        .       "</tr>"
        .       "<tr>"
        .           "<td>Stations: </td>" 
        .           "<td>".$locationData["stations"]."</td>"
        .       "</tr>"
        .       "<tr>"
        .           "<td>Stations Available: </td>" 
        .           "<td>".$locationData["stations_available"]."</td>"
        .       "</tr>"
        .       "<tr>"
        .           "<td>Cost (per hour): </td>"
        .           "<td>".$locationData["costs"]."<td>"
        .       "</tr>"
        .       "<tr>"
        .           "<td>Current Time: </td>"
        .           "<td>$time<td>"
        .       "</tr>"
        .   "</table><br><br>";

        if ($isCheckedIn){
            echo '<form method="post">
                    <input type="submit" name="checkOut" value="Check Out">
                </form>';

            $visitID = $visits[0]['visitID']; // Get the active visit ID
            if (isset($_POST['checkOut'])) checkOut($visitID);
        }else{
            echo '<form method="post">
                    <input type="submit" name="checkIn" value="Check In">
                </form>';
            
            if (isset($_POST['checkIn'])) checkIn($_SESSION["userID"], $locationID);
        }
        ?>
    </div>
</html>