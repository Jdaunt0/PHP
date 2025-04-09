<!DOCTYPE html>
<?php
    function checkPassword($password, &$errorMsg){
        //Regular expressions to validate password
        $containsdigit = '/^(?=.*\d).*$/'; //checks if there is a digit 
        $containsLowercase = '/^(?=.*[a-z]).*$/'; //checks if there is a lowercase letter
        $containsUppercase = '/^(?=.*[A-Z]).*$/'; //checks if there is a uppercase letter
        $containsSpecialCharacter = '/^(?=.*[!@#$%^&*]).*$/'; //checks if there is a special character
        $between8and16characters = '/^.{8,16}$/'; //checks if the password is between 8-16 characters
        $passwordFormat = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,16}$/'; //checks all of the RegEx combined

        //if the password is invalid (does not pass the regular expressions)
        if(!preg_match($passwordFormat,$password)){ 
            //individually check each error and provide accurate error messages
            if($password == ''){
                $errorMsg .= 'Password cannot be blank <br>';
            }
            if(!preg_match($containsdigit, $password)){
                $errorMsg .= 'Password Must contain a number <br>';
            }
            if(!preg_match($containsLowercase, $password)){ 
                $errorMsg .= 'Password must contain a lowercase letter <br>';
            }
            if(!preg_match($containsUppercase, $password)){
                $errorMsg .= 'Password must contain a uppercase letter <br>';
            }
            if(!preg_match($containsSpecialCharacter, $password)){
                $errorMsg .= 'Password must contain a special character <br>';
            }
            if(!preg_match($between8and16characters, subject: $password)){
                $errorMsg .= 'Password must be between 8 and 16 characters <br>';
            }
            return false;
        }else{
            return true;
        }
    }
    
    function validateRegistration($data){
        $errorMsg = ''; // an empty string to assign the error messages
        $validated = true; // boolean to check if all tests passed
        $mobileFormat = '/^04\d{8}$/'; //begins with 04 followed by any 8 digits
        $emailFormat = '/^.+[@].+[.com]$/'; //any characters, followed by and @ symbol, then any character followed by .com


        if($data['name'] == ''){ //check that name is not blank
            $errorMsg .= 'Name cannot be blank <br>';
            $validated = false;
        }else if(!is_string($data['name']) || strlen($data['name']) > 50){ //check that name is a string and is less than 50 characters
            $errorMsg .= 'Name cannot be greater than 50 characters <br>';
            $validated = false;
        }
        
        if($data['age'] == ''){ //check that age is not blank
            $errorMsg .= 'Age cannot be blank <br>';
            $validated = false;
        }else if(!is_numeric($data['age'])){ //check if age is an int
            $errorMsg .= 'Age must be a number <br>';
            $validated = false;
        }
        
        if($data['mobile'] == ''){ //check that mobile number is not blank
            $errorMsg .= 'Mobile number cannot be blank <br>';
            $validated = false;
        }else if(!preg_match($mobileFormat, $data['mobile'])){
            $errorMsg .= 'Invalid mobile number <br>';
            $validated = false;
        }
        
        if($data['bio'] == ''){ //check that bio is not blank
            $errorMsg .= 'Bio cannot be blank <br>';
            $validated = false;
        }else if(str_word_count($data['bio']) > 200){
            $errorMsg .= 'Bio must be under 200 characters <br>';
            $validated = false;
        }
        
        if($data['email'] == ''){
            $errorMsg .= 'Email cannot be blank <br>';
            $validated = false;
        }else if(!preg_match($emailFormat, $data['email'])){
            $errorMsg .= 'Invalid email <br>';
            $validated = false;
        } 
        
        if(!checkPassword($data["password"],$errorMsg)){
            $validated = false;
        } 

        if ($validated == true){
            return "<p>Dear {$data['name']} you are registered with your email address {$data['email']}";
        }else {
            return "<p style='color: red'>$errorMsg</p>";
        }
    }

    // Check if form data is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        validateRegistration($_POST);
    }

?>

<html>
    <header>
        <h1>Register Here: </h1>
    </header>

    <body> <!--basic html form that runs validateRegistration() on submit -->
        <form method="post">
            <label for="name">First and last name:</label><br>
            <input type="text" id="name" name="name"><br>
        
            <label for="age">Age:</label><br>
            <input type="text" id="age" name="age"></br>
            
            <label for="mobile">Mobile Number:</label><br>
            <input type="text" id="mobile" name="mobile"><br>
            
            <label for="bio">Short Bio: (up to 200 words)</label><br>
            <textarea id="bio" name="bio" rows="5" cols="18" style="resize: none;"></textarea><br>

            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email"><br>
            
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br>
        
            <input type="submit" value="Register">
            
            <!-- Output for the error messages
            <p style="color: red" id="errormsg"></p> -->
        </form> 
    
        <?php 
            // Check if form data is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo validateRegistration($_POST);
            }
        ?>
    </body>
</html>