<!doctype HTML>
<?php 
    //this function saves the booking by apending it to the text file RepairTasks.txt
    function saveBooking($data){
        //convert the raw data into variables
        $name = $data['name'];
        $mobile = $data['mobile'];
        $email = $data['email'];
        $rtask = $data['rtask'];
        $description = $data['description'];
        $priority = $data['priority'];
        $area = $data['area'];
        $comments = $data['comments'];

        $FileName = "RepairTasks.txt";

        //format the variables for the file
        $FileContent = "Basic Info:\n" . $rtask ."\n" . $description ."\n\nMore Info:\n" . $name . "\n" . $mobile . "\n" . $email . "\n" . $priority . "\n" . $area . "\n" . $comments . "\n*^*^*^*^*^\n\n";

        //append the new booking to the text file
        file_put_contents($FileName,$FileContent,  FILE_APPEND);
        
        //error check
        if(!file_exists($FileName)){
            return "<p style='color: red'>ERROR: Booking has NOT been saved, Check the read and write permissions</p>";
        }else{
            return "<p>Booking has been saved!</p>";
        }
        
    }

    //Regular Expressions to check if the values submitted on the form meet the requirements
    function validateBooking($data){
        $errorMsg = ''; // an empty string to assign the error messages
        $validated = true; // boolean to check if all tests passed
        $mobileFormat = '/^04\d{8}$/'; //begins with 04 followed by any 8 digits
        $emailFormat = '/^.+[@].+[.com]$/'; //any characters, followed by and @ symbol, then any character followed by .com
        $rtaskFormat = '/^\w{3}-\d{3}$/';

        if($data['mobile'] == ''){ //check that mobile number is not blank
            $errorMsg .= 'Mobile number cannot be blank <br>';
            $validated = false;
        }else if(!preg_match($mobileFormat, $data['mobile'])){
            $errorMsg .= 'Invalid mobile number <br>';
            $validated = false;
        }

        if($data['email'] == ''){ //check that email is not blank
            $errorMsg .= 'Email cannot be blank <br>';
            $validated = false;
        }else if(!preg_match($emailFormat, $data['email'])){
            $errorMsg .= 'Invalid email <br>';
            $validated = false;
        } 

        if($data['rtask'] == ''){
            $errorMsg .= 'Repair Task cannot be blank <br>';
            $validated = false;
        }else if(!preg_match($rtaskFormat, $data['rtask'])){
            $errorMsg .= 'Invalid repair task format. <br>';
            $validated = false;
        } 
        
        if ($validated == true){
            $saveResult = saveBooking($data);
            return "<p style='color: green'>$saveResult</p>";
        }else {
            return "<p style='color: red'>$errorMsg</p>";
        }
    }

?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
    </head>
    
    <header>
        <a href = "index.php" id="heading">Handyman Needed</a>
        <div id="nav"> 
            <h3 id="about">about us</h3>
            <a class="button"><h3>Book Now</h3></a>
            <a href="handyman.php" class="button"><h3>View Listings</h3></a>
        </div>   
    </header>

    <body>
        <hr><h1>Create Booking</h1>
        <form method="post">
            <label for="name">First and last name:</label><br>
            <input type="text" id="name" name="name" placeholder="e.g. John Smith"><br>

            <label for="mobile">Mobile Number:</label><br>
            <input type="text" id="mobile" name="mobile" placeholder="e.g. 04********"><br>
            
            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email" placeholder="e.g. email@host.com"><br>

            <label for="rtask">Repair task:</label><br>
            <input type="text" id="rtask" name="rtask" placeholder="e.g. aaa-000"><br>

            <label for="description">Description:</label><br>
            <input type="text" id="description" name="description"><br>

            <label for="priority">Priority:</label><br>
            <select id="priority" name="priority">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
                <option value="urgent">Urgent</option>
            </select><br>

            <label for="area">Area/Suburb:</label><br>
            <input type="text" id="area" name="area"><br>

            <label for="comments">Comments:</label><br>
            <textarea id="comments" name="comments" rows="5" cols="18" style="resize: none;"></textarea><br>

            <input type="submit" value="Register">
        </form>
        
        <?php 
        // Check if form data is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo validateBooking($_POST);
        }
        ?>

    </body>

    <footer>
        <?php 
        $time = date("Y-m-d H:i:s");
        echo"$time";
        ?>
    </footer>
</html>