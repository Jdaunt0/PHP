<!doctype HTML>
<?php
//this function saves the bid to the text file HandymenBids.txt
//works almost identically to saveBooking
function saveBid($data){
    //convert the raw data into variables
    $rtask = $data['rtask'];
    $price = $data['price'];
    $date = $data['date'];
    $time = $data['time'];
    $name = $data['name'];
    $number = $data['mobile'];

    $FileName = "HandymenBids.txt";

    //format the variables for the file
    $FileContent =  $rtask ."\n" . $price ."\n" . $date . "\n" . $time . "\n" . $name . "\n" . $number . "\n*^*^*^*^*^\n\n";
    
    //append the new booking to the text file
    file_put_contents($FileName,$FileContent,  FILE_APPEND);
    
    //error check
    if(!file_exists($FileName)){
        return "<p style='color: red'>ERROR: Booking has NOT been saved, Check the read and write permissions</p>";
    }else{ 
        return "<p>Bid has been saved!</p>";
    }
}


function echoRepairTasks($searchRTask = null){
    $fileName = "RepairTasks.txt";
    
    //check if the file exists
    if (file_exists($fileName)) {
        //read the file content
        $fileContent = file_get_contents($fileName);

        //split the content into tasks using the separator
        $tasks = explode("*^*^*^*^*^", $fileContent);
        
        //div that works as a container / grid to format the tasks
        echo "<div class='task-container'>";

        //loop through each task
        foreach ($tasks as $task) {
            $task = trim($task); //remove extra whitespace
            if (!empty($task)) { //skip empty tasks
                //check if user has searched for a specific task
                if ($searchRTask) {
                    //display only the task that matches the RTask
                    if (strpos($task, $searchRTask) !== false) {
                        echo "<div class='task'>";
                        echo nl2br(htmlspecialchars($task)); //display full task (basic + more info)
                        echo "</div>";
                    }
                } else {
                    //display only the Basic Info section when no search is provided
                    $basicInfo = strstr($task, "More Info:", true); //run until it finds "more info"
                    if ($basicInfo) {
                        echo "<div class='task'>";
                        echo nl2br(htmlspecialchars($basicInfo)); //display basic info only
                        echo "</div>";
                    }
                }
            }
        }
        echo "</div>"; // end the container / grid
    } else { //if does not exist
        echo "<p>No tasks found.</p>";
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
            <a href="booking.php" class="button"><h3>Book Now</h3></a>
            <a class="button"><h3>View Listings</h3></a>
        </div>
    </header>

    <body>
        <h1>Jobs: </h1>
        <form method="post">
            <input type="hidden" name="form_type" value="search"> <!-- Hidden input to identify the search form -->
            <h3><input type="text" name="RTask" placeholder="Enter Repair Task"><input type="submit" value="Search"></h3>
        </form>

        <?php
            //check if a RTask is submitted
            $searchRTask = isset($_POST['RTask']) ? trim($_POST['RTask']) : null;
                
            //print all the listed repair tasks
            echoRepairTasks($searchRTask);
        ?>

        <h1>Bid on a job: </h1>
        <form method="post">
        <input type="hidden" name="form_type" value="bid"> <!-- Hidden input to identify the bid form -->
            <label for="rtask">Repair task:</label><br>
            <input type="text" id="rtask" name="rtask"><br>

            <label for="price">Price:</label><br>
            <input type="number" id="price" name="price"><br>

            <label for="appointment">Appointment:</label><br>
            <input type="date" id="date" name="date">
            <input type="time" id="time" name="time"><br>
            <label for="name">First and last name:</label><br>
            <input type="text" id="name" name="name" placeholder="e.g. John Smith"><br>

            <label for="mobile">Number:</label><br>
            <input type="text" id="mobile" name="mobile" placeholder="e.g. 04********"><br>

            <input type="submit" value="Register">
        </form>
        <?php 
            //check if the bid form is submitted
            if (isset($_POST['form_type']) && $_POST['form_type'] === 'bid') {
                echo saveBid($_POST);
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