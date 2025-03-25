<!DOCTYPE html>
<html>
    <?php
        function validSerialNums($serialNumber = ""){
            $containsNum = '/(?=.*[0-9])/';
            $containsLower = '/(?=.*[a-z])/';
            $containsUpper = '/(?=.*[A-Z])/';
            $containsSpecialChar = '/(?=.*[^a-zA-Z0-9])/';
            $CharacterRequrement = '/^.{6}/';
            $containsSpaces = '/\s/';
            if(!preg_match($containsNum, $serialNumber)){
                return "INVALID: Serial number needs atleast 1 number";
            }else if (!preg_match($containsLower, $serialNumber)){
                return "INVALID: Serial number needs atleast 1 lowercase letter";
            }else if(!preg_match($containsUpper, $serialNumber)){
                return "INVALID: Serial number needs atleast 1 uppercase letter";
            }else if(!preg_match($containsSpecialChar, $serialNumber)){
                return "INVALID: Serial number needs atleast 1 special character";
            }else if(!preg_match($CharacterRequrement, $serialNumber)){
                return "INVALID: Serial number needs to be atleast 6 characters long";
            }else if(preg_match($containsSpaces,$serialNumber)){
                return "INVALID: Contains spaces";
            }else {
                return "valid";
            }
                
        }
    ?>

    <header>
        <h1>Task 2 - Regular expression that check for valid Serial Numbers </h1>
    </header>

    <body>
        <?php 
        $serialNumbers = [
            "A1b@cD", // Valid
            "1aB#2c", // Valid
            "mN4%oP", // Valid
            "Q5r^sT", // Valid
            "Ab@cDE", // Invalid: does not have 1 number
            "A1B@CD", // Invalid: does not have 1 lowercase
            "a1b@cd", // Invalid: does not have 1 uppercase
            "A1b2cD", // Invalid: does not have 1 special character
            "A1b@c",  // Invalid: not 6 characters long
            "A1b @cD" // Invalid: contains spaces
        ];
        foreach ($serialNumbers as $serialNumber) {
            $output = validSerialNums($serialNumber);
            echo "<p>Serial Number: $serialNumber - $output</p>";
        }

        ?>
    </body>
</html>