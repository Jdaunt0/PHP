<!DOCTYPE html>

<?php 
    function func($num = 0)  {
        $numStr = strval($num); //Converts the number to a string
        $length = strlen($numStr); // gets the length of the new string converstion
        $output  = ""; // initialises the output

        for ($i=$length; $i>=0; $i--) {
            $newStr .= $numStr[$i];
        }
        return intval($newStr) * 5;
    } 
?>

<html>
    <header>

    </header>
    
    
    <body>
        <?php
        $input = [123,4251,9999,49,2];
        $inputLength = count($input);

        for($i=0; $i< $inputLength; $i++){
            $output = func($input[$i]);
            echo "<p> Input: $input[$i]",
             ", Output: $output </p>";
        }
        ?>

    </body>
</html>