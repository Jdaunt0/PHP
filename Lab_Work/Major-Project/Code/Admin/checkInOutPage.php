<html>
    <head>
        <link rel="stylesheet" href="../Stylesheet.css">
    </head>
    <a href="../index.php" class="button">back</a><br><br>
   
    <div class="centercontainer">
        <div class="mainPage">
            <?php 
            include("../functions/database.php"); // Include the database functions

            $userID = intval($_GET['userID']);
            $userDetails = getUserDetails(null, $userID)[0];
            $visits = getVisits($userID, false , true);


            echo "<h1>Check " . $userDetails['name'] . " out of:</h1>";
            echo "<table>
                    <tr>
                        <th>Location: </th>
                        <th>Check In Time: </th>
                        <th>visitID: </th>
                        <th>Stations: </th>
                        <th>Costs: </th>
                        <th>Check Out: </th>
                    </tr>
                    ";
            foreach ($visits as $visit){
                $locationData = getLocations($visit["locationID"])[0];
                echo "<tr>"
                    .   "<td>" . $locationData["description"] . "</td>"
                    .   "<td>" . $visit["checkin_time"] . "</td>"
                    .   "<td>" . $visit["visitID"] . "</td>"
                    .   "<td>" . $locationData["stations"] . "</td>"
                    .   "<td>" . $locationData["costs"] . "</td>"
                    .   "<td> 
                            <form method='post' style='display:inline;'>
                                <input type='hidden' name='visitID' value='" . $visit['visitID'] . "'>
                                <input type='submit' value='check out' name='checkout'>
                            </form> 
                        </td>
                     </tr> ";
            }
            echo "</table>";
            //checkout user button function
            if (isset($_POST['checkout']) && isset($_POST['visitID'])){
                checkout($_POST['visitID']);
                header("Refresh:0");
                exit();
            }
            ?>
        </div>

        <div class="mainPage">
            <?php 
                echo "<h1>Check  " . $userDetails['name'] . " into:</h1>";
                $locations = getLocations();
                
                echo "<table>
                        <tr>
                            <th>ID:</th>
                            <th>Description:</th> 
                            <th>Stations:</th>
                            <th>Stations Available:</th>
                            <th>Costs:</th>
                            <th>Check In/Out:</th>
                        </tr>";
                foreach ($locations as $location){
                    $visits = getVisits($userID, $location['locationID']);
                    $isCheckedIn = !empty($visits); // If there are active visits, the user is checked in
                    if(!$isCheckedIn){
                        echo "<tr>"
                                . "<td>" . $location['locationID'] . "</td>"
                                . "<td>" . $location['description'] . "</td>"
                                . "<td>" . $location['stations'] . "</td>"
                                . "<td>" . $location['stations_available'] . "</td>"
                                . "<td>" . $location['costs'] . "</td>"
                                . "<td>"
                                .   '<form method="post" style="display:inline;">'
                                .       '<input type="hidden" name="locationID" value="' . $location['locationID'] . '">'
                                .       '<input type="submit" name="checkIn" value="Check In">'
                                .   '</form>'
                                . "<td>"
                            . "</tr>";
                    }
                }
            echo "</table>";

            if (isset($_POST['checkIn'])){
                    checkIn($userID, $_POST['locationID']);
                    header("Refresh:0");
                    exit();
            }
            ?>
        </div>
    </div>
</html>
