<!DOCTYPE html>
<html>
    <?php 
            function func($num = '')  {
                // Regular expression to match the ISBN format
                $pattern = '/^ISBN \d{3}-\d-\d{2}-\d{6}-\d$/';

                if (preg_match($pattern, $num)) {
                    return "is a valid ISBN";
                }else{
                    return "is not a valid ISBN";
                }
            }
    ?>
    <header>
        <h1>Task 1 - Function that checks the formatting of strings</h1>
    </header>
    
    <body>
        <h1>Hello World</h1>
        <?php 
            $BookISBN = [
                "ISBN 123-4-56-789012-3",
                "ISBN 123-4-56-789012-4",
                "ISBN 123-4-56-789012-5",
                "ISBN 123-4-56-789012-6",
                "ISBN 123-4-56-789012-7",
                "ISBN 123-4-56-789012-89", // Invalid
                "ISBN 123-4-56-789012",    // Invalid
                "ISBN 123-4-56-789012-12", // Invalid
                "ISBN 123-4-56-789012-XYZ",// Invalid
                "ISBN 123-4-56-789012-!"   // Invalid
            ];

            $inputLength = count($BookISBN);

            for ($i = 0; $i < $inputLength; $i++) {
                $output = func($BookISBN[$i]);
                echo "<p> Input: $BookISBN[$i]",
                 ", Output: $output </p>";
            }
        ?>

    </body>
</html>


