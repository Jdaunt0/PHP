 <?php 
include("functions/database.php"); //Database Functions

//Register Func: Regular expressions to validate password
function checkPassword($password, &$errorMsg){
    $rules = [
        '/^.+$/' => '- cannot be blank <br>', //checks if there is at least one character
        '/^(?=.*\d).*$/' => '- must contain a number<br>', //checks if there is a digit 
        '/^(?=.*[a-z]).*$/' => '- must contain a lowercase letter<br>', //checks if there is a lowercase letter
        '/^(?=.*[A-Z]).*$/' => '- must contain an uppercase letter<br>', //checks if there is a uppercase letter
        '/^(?=.*[!@#$%^&*]).*$/' => '- must contain a special character<br>', //checks if there is a special character
        '/^.{8,16}$/' => '- must be between 8 and 16 characters<br>', //checks if the password is between 8-16 characters
    ];

    $validated = true; // boolean to check if all tests passed
    $pasErrMsg = "Invalid Password: <br> <i>";
    foreach ($rules as $regex => $message) {
        if (!preg_match($regex, $password)) {
            $pasErrMsg .= " " . $message;
            $validated = false;
        }
    }
    $errorMsg .= $pasErrMsg . '</i>';
    return $validated;
}

//Register Func: Regular expressions to validate username, mobile and email
function checkDetails($username, $mobile, $email, &$errorMsg){
    //regex
    $rules = [
        '/^.{5,25}$/' => [
            'subject' => $username, // Username must be between 5 and 25 characters
            'message' => 'Invalid username: <i>must be between 5 and 25 characters</i> <br>'
        ],
        '/^04\d{8}$/' => [
            'subject' => $mobile, // Mobile must start with 04 and have 10 digits
            'message' => 'Invalid mobile number: <i>must start with 04 and have 10 digits</i> <br>'
        ],
        '/^.+[@].+[.com]$/' => [
            'subject' => $email, // Email must follow the format __@__.com
            'message' => 'Invalid email: <i>must follow the format __@__.com</i> <br>'
        ]
    ];

    $validated = true; // boolean to check if all tests passed
    foreach ($rules as $regex => $data) {
        if (!preg_match($regex, $data['subject'])) {
            $errorMsg .= $data['message'];
            $validated = false;
        }
    }
    return $validated;
}

//Save login data to session
function saveSessionDetails($username){
    $result = getUserDetails($username);
    if (count($result) > 0) {
        $RowDetails = $result[0]; // Get the first row
        session_start(); // Start the session
        // Store user information in the session
        $_SESSION["userID"] = $RowDetails["userID"];
        $_SESSION["name"] = $RowDetails['name'];
        $_SESSION["type"] = $RowDetails['type'];
        // Redirect to the homepage
        header("Location: index.php");
        exit(); // Ensure no further code is executed
    } else {
        die("Error: User not found.");
    }
}

function register(){
    $validated = true; // boolean to check if all tests passed
    $errorMsg = ''; // an empty string to assign the error messages

    //Register Info (filter for SQL Injections)
    $username = filter_input(INPUT_POST,"username", FILTER_SANITIZE_SPECIAL_CHARS); 
    $mobile = filter_input(INPUT_POST,"mobile", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST,"email", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST,"password", FILTER_SANITIZE_SPECIAL_CHARS); 
    $confirmPassword = $_POST["confirm_password"]; 

    if(!checkDetails($username, $mobile, $email, $errorMsg)){
        $validated = false;
    }

    if($password !== $confirmPassword){
        $errorMsg .= "Passowrds do not match <br>";
    }else if(!checkPassword($password,$errorMsg)){
        $validated = false;
    }else{
        //Encrypt Password
        $password = password_hash($password, PASSWORD_DEFAULT); 
    }

    if ($validated == true){
        //convert Type: str to bool
        $accountType = $_POST["accType"];
        $isAdmin = ($accountType === "admin") ? 0 : 1; 

        addAccToDB($username,$mobile,$email,$isAdmin,$password);
        SaveSessionDetails($username);
    }else {
        echo "<p style='color: red'>$errorMsg</p>";
    }
    return $validated;
}

function login(){
    // Login Info
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS); 
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS); 
    
    // Retrieve user info from DB
    $result = getUserDetails($username); 
    if (count($result) > 0) {
        $RowDetails = $result[0]; // Get the first row
        // Verify the entered password with the hashed password in the database
        if (password_verify($password, $RowDetails["password"])) {
            saveSessionDetails($username);
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}


function searchLocations($search = '', $appliedAvailable = false, $appliedPrevious = false, $appliedUsing = false, $user = false, $appliedFull=false){
    $userID = $_SESSION["userID"]; //get userID from session login

    $locations = getLocations(); //get * from Locations
    
    $visits = getVisits($userID); //SELECT LocationID from visits Where userID = ? AND checkout_time IS NULL
    $usingLocationIDs = array_column($visits, 'locationID'); //strip data to [visitID] => [locationID]

    $previouslyUsed = getVisits($userID, null, false, true); //SELECT LocationID from visits Where userID = ? AND checkout_time IS NOT NULL
    $previouslyUsedLocationIDs = array_column($previouslyUsed, 'locationID');

    echo "<table>
            <tr>
                <th>ID:</th>
                <th>Description:</th> 
                <th>Stations:</th>
                <th>Stations Available:</th>
                <th>Costs:</th>
                <th>" . ($user ? 'Check In/Out:' : 'Edit:') . "</th>
            </tr>";

    foreach ($locations as $location) {
        //returns true if: search is in the location description or search matches the locationID
        $SearchFilter = (stripos($location['description'], $search) !== false || (is_numeric($search) && $location['locationID'] == $search));

        //returns true if: filter applied and stations are avalible
        $availableFilter = (!$appliedAvailable || $location['stations_available'] > 0);
        
        $fullFilter = (!$appliedFull || $location['stations_available'] == 0);

        //returns true if: user is checked into location
        $isUsing = (in_array($location['locationID'], $usingLocationIDs));
        
        //returns true if: user has checked into and out of a location
        $hasUsedPreviously = (in_array($location['locationID'], $previouslyUsedLocationIDs));

        //returns true if: location has no stations available
        $previousFilter = (!$appliedPrevious || $hasUsedPreviously);

        //returns true if: filter applied and user is checked into location
        $usingFilter = (!$appliedUsing || $isUsing);

        //Output Locations
        if ($SearchFilter && $availableFilter && $usingFilter && $previousFilter && $fullFilter) {
            echo "<tr>"
                    . "<td>" . $location['locationID'] . "</td>"
                    . "<td>" . $location['description'] . "</td>"
                    . "<td>" . $location['stations'] . "</td>"
                    . "<td>" . $location['stations_available'] . "</td>"
                    . "<td>" . $location['costs'] . "</td>";

            //Button: check in(user), edit location (admin)
            if($user){ //userpage
                $buttonValue = $isUsing ? "Check Out" : "Check In";

                echo '<td>
                        <form method="get" action="User/checkInOutPage.php" style="display:inline;">
                            <input type="hidden" name="locationID" value="' . $location['locationID'] . '">
                            <input type="submit" value="'. $buttonValue .'">
                        </form>
                     <td>';
            }else{ //admin page
                echo '<td>
                        <form method="get" action="Admin/editLocation.php" style="display:inline;">
                            <input type="hidden" name="locationID" value="' . $location['locationID'] . '">
                            <input type="submit" value="EditLocation">
                        </form>
                     <td>';
            }
            echo '</tr>';
        }
    }
    echo "</table>";
}

function listUsers($search = '', $appliedCheckin = false) {
    $users = getUserDetails(); //get all user details

    echo "<table>
            <tr>
                <th>ID: </th>
                <th>Name: </th> 
                <th>Phone: </th>
                <th>Email: </th>
                <th>Type: </th>
                <th>Check In/Out: </th>
            </tr>";
    foreach ($users as $user) {
        $visits = getVisits($user['userID']); //SELECT LocationID from visits Where userID = ? AND checkout_time IS NULL
        
        //returns true if: search is in the username
        $searchFilter = (stripos($user['name'], $search) !== false || (is_numeric($search) && $user['userID'] == $search));
        
        //returns true if: user is checked into 1 or more locations
        $isCheckedIn = count($visits) > 0; 

        //returns true if: filter applied and user is checked into 1 or more locations
        $checkinFilter = !($appliedCheckin && !$isCheckedIn);

        if ($searchFilter && $checkinFilter){
            echo "<tr>"
                    . "<td>" . $user['userID'] . "</td>"
                    . "<td>" . $user['name'] . "</td>"
                    . "<td>" . $user['phone'] . "</td>"
                    . "<td>" . $user['email'] . "</td>"
                    . "<td>" . ($user['type'] ? 'User' : 'Admin'). "</td>";
                    
            if($isCheckedIn){
                echo '<td>
                        <form method="get" action="Admin/checkInOutPage.php" style="display:inline;">
                            <input type="hidden" name="userID" value="' . $user['userID'] . '">
                            <input type="submit" name="checkout" value="Check Out">
                        </form>
                     </td>';
            }else{
                echo '<td>
                        <form method="get" action="Admin/checkInOutPage.php" style="display:inline;">
                            <input type="hidden" name="userID" value="' . $user['userID'] . '">
                            <input type="submit" name="checkin" value="Check in">
                        </form>
                     </td>'; 
            }
            echo '</tr>';
        }
    }
    echo "</table>";
}

//clear Login data from session
function logout(){
    session_start(); // Start the session
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: index.php"); // Redirect to the homepage or login page
    exit();
}

?>