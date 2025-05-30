<?php
// ini_set('display_errors', 0);
// ini_set('display_startup_errors', 0);
// error_reporting();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

//connects to the database

function connectDB(){
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "mysql";
    $db_name = "majordb";
    try {
        $conn = new mysqli( $db_server, 
                            $db_user, 
                            $db_pass, 
                            $db_name);
        return $conn;
    }catch(mysqli_sql_exception $e){
        die("Error connecting to database: " . $e->getMessage());
    }
}

//creates the database if it doesnt exist alreedy
function createDB(){
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "mysql";

    try {
        $conn = new mysqli( $db_server, 
                            $db_user, 
                            $db_pass);
        // Create the database
        $query = "CREATE DATABASE IF NOT EXISTS `majordb`";
        $conn->query($query);
        
    }catch(mysqli_sql_exception $e){
        die("Error creating database: " . $e->getMessage());
    }

    $conn->close();
}

//creates the user table if it doesnt exist already
function createTableUsers(){
    try{
        $conn = connectDB(); //Connect to Database

        // Create the table
        $query = "CREATE TABLE IF NOT EXISTS `majordb`.`users` (
                 `userID` INT NOT NULL AUTO_INCREMENT , 
                 `name` VARCHAR(25) NOT NULL , 
                 `phone` CHAR(10) NOT NULL , 
                 `email` VARCHAR(100) NOT NULL , 
                 `type` TINYINT(1) NOT NULL , 
                 `password` VARCHAR(255) NOT NULL , 
                 PRIMARY KEY (`userID`), 
                 UNIQUE (`name`));";

        $conn->query($query);
        $conn->close();

    } catch (mysqli_sql_exception $e) {
        die("Error creating user table: " . $e->getMessage());
    }
}

//creates the locations table if it doesnt exist already
function createTableLocations(){
    try{
        $conn = connectDB(); //Connect to Database

        // Create the table
        $query = "CREATE TABLE IF NOT EXISTS `majordb`.`locations` (
                 `locationID` INT NOT NULL AUTO_INCREMENT , 
                 `description` VARCHAR(100) NOT NULL ,
                 `stations` INT NOT NULL ,
                 `stations_available` INT NOT NULL ,
                 `costs` FLOAT NOT NULL ,
                 PRIMARY KEY (`locationID`));";

        $conn->query($query);
        $conn->close();
        
    } catch (mysqli_sql_exception $e) {
        die("Error creating locations table: " . $e->getMessage());
    }
}

//creates the relational table between locations and users
//stores times users have visited locations
function createTableVisits(){
    try{
        $conn = connectDB(); //Connect to Database

        // Create the table
        $query = "CREATE TABLE IF NOT EXISTS `majordb`.`visits` (
                 `visitID` INT NOT NULL AUTO_INCREMENT , 
                 `userID` INT NOT NULL , `locationID` INT NOT NULL , 
                 `checkin_time` DATETIME NOT NULL , 
                 `checkout_time` DATETIME NULL DEFAULT NULL , 
                 `totalCost` FLOAT NULL DEFAULT NULL , 
                 PRIMARY KEY (`visitID`));";

        $conn->query($query);
        $conn->close();
        
    } catch (mysqli_sql_exception $e) {
        die("Error creating visits table: " . $e->getMessage());
    }
}

//Add a new Account to the database
function addAccToDB($name, $phone, $email, $type, $password){
    try{
        $conn = connectDB(); //Connect to Database

        $stmt = $conn->prepare( "INSERT INTO users (name, phone, email, type, password) 
                                        VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $name, $phone, $email, $type, $password);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "User successfully added.";
        } else {
            echo "Failed to insert user.";
        }
        
        $stmt->close();
        $conn->close();
    }catch (mysqli_sql_exception $e) {
        die("Error adding account to database: " . $e->getMessage());
    }
}

//SQL Query to find a row from the database from a name
function getUserDetails($name = null, $userID = null){
    try{
        $conn = connectDB(); //Connect to Database
        
        $query = "SELECT * FROM users";
        if($userID !== null){ //search user by UserID
            $query .= " WHERE userID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $userID);
        }else if($name !== null){ //for login ONLY
            $query .= " WHERE name = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $name);
        }else{
            $stmt = $conn->prepare($query);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch all rows into an array
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        $stmt->close();
        $conn->close();
        return $rows; // Return all rows as an array
    }catch (mysqli_sql_exception $e) {
        die("Error adding account to database: " . $e->getMessage());
    }
    
}

//Returns the locations table
//if you provide a locationID it will return a specific location
//else it will return all of the locations

function getLocations($locationID = null){
    try{
        $conn = connectDB(); //Connect to Database

        $query = "SELECT * FROM `locations`";
    
        if($locationID !== null){
            $query .= " WHERE `locationID` = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $locationID);
        }else{
            $stmt = $conn->prepare($query);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row; // Add each row to the array
        }

        $stmt->close();
        $conn->close();

        return $rows;
    }catch (mysqli_sql_exception $e) {
        die("Error getting location(s): " . $e->getMessage());
    }
}

// check into location
// check if there is a station avalible to charge 
// take avalible station
// add a new row to visits table

function checkIn($userID, $locationID){
    try{
        $conn = connectDB(); //Connect to Database

        //get current avalible amount of stations for charging
        $query = "SELECT stations_available FROM locations WHERE locationID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $locationID);
        $stmt->execute();
        $result = $stmt->get_result();
         
        //set stations value to query result
        $stations = 0;
        if ($result->num_rows > 0) {
            $stations = $result->fetch_assoc()['stations_available'];
        }

        //if there is a station avalible
        if ($stations > 0){

            //set station to -1
            $stations -=1;
            $query = "UPDATE locations SET stations_available = ? WHERE locationID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $stations, $locationID);
            $stmt->execute();
            
            //new entry into visits table
            $now = date('Y-m-d H:i:s');
           
            $query = "INSERT INTO visits (userID, locationID, checkin_time) VALUES (?, ?, ?)";
            
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iis", $userID, $locationID, $now);
            $stmt->execute();

            echo "Checked in successfully.";
        }else{
            echo "no avalible stations to charge.";
        }
    
        $stmt->close();
        $conn->close();
    }catch (mysqli_sql_exception $e) {
        die("Error checking in: " . $e->getMessage());
    }        
}


function checkOut($visitID) {
    try {
        $conn = connectDB();

        //get the checkin time and locationID of the visit
        $query = "SELECT checkin_time, locationID FROM visits WHERE visitID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $visitID);
        $stmt->execute();
        $result = $stmt->get_result();

        //if the visit exists
        if ($result->num_rows > 0) {
            //save checkin and locationID
            $visit = $result->fetch_assoc();
            $checkinTime = $visit['checkin_time'];
            $locationID = $visit['locationID'];

            // get the cost ph and stations avalible at the location
            $query = "SELECT costs, stations_available FROM locations WHERE locationID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $locationID);
            $stmt->execute();
            $result = $stmt->get_result();

            //if location exists
            if ($result->num_rows > 0) {
                //save cost ph
                $location = $result->fetch_assoc();
                $costPerHour = $location['costs'];
                
                //update station, add +1 to make it avalible again
                $stations = $location['stations_available'];
                $stations +=1;

                //set station to +1
                $query = "UPDATE locations SET stations_available = ? WHERE locationID = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ii", $stations, $locationID);
                $stmt->execute();

                // Calculate the duration in hours
                $now = date('Y-m-d H:i:s'); // Get the current timestamp
                $checkinTimestamp = strtotime($checkinTime);
                $checkoutTimestamp = strtotime($now);
                $durationInHours = ($checkoutTimestamp - $checkinTimestamp) / 3600;

                // Calculate the total cost
                $totalCost = $durationInHours * $costPerHour;

                // Update the visit with the checkout time and total cost
                $query = "UPDATE visits SET checkout_time = ?, totalCost = ? WHERE visitID = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sdi", $now, $totalCost, $visitID);
                $stmt->execute();

                echo "Checked out successfully. Total cost: $" . number_format($totalCost, 2);
            } else {
                echo "Error: Location not found.";
            }
        } else {
            echo "Error: Visit not found.";
        }

        $stmt->close();
        $conn->close();
    } catch (mysqli_sql_exception $e) {
        die("Error checking out: " . $e->getMessage());
    }
}

//this function returns data from the visits table
//more specifically: returns currently using locations for specific user
//Required: UserID
//optional: locationID, selectAll
//
// If select all is true it returns all from rows where the userID matches
// If locationID is NOT given it returns locationID from rows where the userID matches
// If locationID is given then it returns visitID from rows where the userID and locationID matches

function getVisits($userID, $locationID = null, $selectAll = false, $previous = false){
    try{
        $conn = connectDB(); //Connect to Database

        $checkoutCondition = $previous ? "NOT NULL" : "NULL";
        $fromVisits = "FROM visits WHERE userID = ? AND checkout_time IS $checkoutCondition";

        if($selectAll){
            $query = "SELECT * " . $fromVisits; //Select ALL, Used In: checkOutUser.php
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i",$userID);
        }else if($locationID === null){
            $query = "SELECT locationID " . $fromVisits;; //Select locationID, Used in: listUsers(), searchLocation()
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i",$userID);
        }else{
            $query = "SELECT visitID " . $fromVisits . " AND locationID = ?"; //Select visitID , Used In: checkIn.php
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii",$userID, $locationID);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row; //add each row to the array
        }
    
        $stmt->close();
        $conn->close();
    
        return $rows;
    }catch (mysqli_sql_exception $e) {
        die("Error getting visit(s): " . $e->getMessage());
    }
}

//Add a new location to the database
function addLocation($description, $stations, $costs){
    try{
        $conn = connectDB(); //Connect to Database

        $stmt = $conn->prepare( "INSERT INTO locations (description, stations, stations_available, costs) 
                                        VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siid", $description, $stations, $stations, $costs);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "location successfully added.";
        } else {
            echo "Failed to insert location.";
        }
        
        $stmt->close();
        $conn->close();
    }catch (mysqli_sql_exception $e) {
        die("Error adding location to database: " . $e->getMessage());
    }
}

//edit existing location in the database
function editLocation($locationID, $description, $stations_newTotal, $cost){
    try{
        $conn = connectDB(); //Connect to Database
        
        $stmt = $conn->prepare("SELECT stations, stations_available FROM locations WHERE locationID=?");
        $stmt->bind_param("i", $locationID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stationsAvalible_newTotal = $stations_newTotal - ($row['stations'] - $row['stations_available']);
        $stmt = $conn->prepare( "UPDATE locations SET description=? ,stations=?, stations_available=?, costs=? WHERE locationID=?");
        $stmt->bind_param("siidi", $description,$stations_newTotal, $stationsAvalible_newTotal,$cost,$locationID);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $result = "location successfully changed.";
        } else {
            $result = "Failed to edit location.";
        }
        
        $stmt->close();
        $conn->close();
        return $result;
    }catch (mysqli_sql_exception $e) {
        die("Error editing location in database: " . $e->getMessage());
    }
}


?>