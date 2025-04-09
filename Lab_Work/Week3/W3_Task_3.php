<!DOCTYPE html> 
<?php 
    function CheckFormatValid($mortgage = "", $interest = "", $years = ""){
        $FormatChecking = '/^\d+(\.\d+)?$/'; // check if the input is a number with optional decimal points
        if(preg_match($FormatChecking, $mortgage) && preg_match($FormatChecking, $interest) && preg_match($FormatChecking, $years)) {
            return true;
        }else{
            return false;
        }
    }

    function calculateMonthlyPayment($mortgage, $interest, $years){
        $rate = $interest / 100 / 12;
        $paymentsNumber = $years * 12;
        $monthlyPayment = $mortgage * $rate / (1 - (1 / pow(1 + $rate, $paymentsNumber)));
        return number_format($monthlyPayment, 2); // Return the monthly payment to 2 decimal places
    }
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="homepage.css">
    </head>

    <body>
        <header id="header">
            <h1 class="title">Task 3 - Finance Company</h1>
        </header>

        <div class="centered-content">
            <div class="calculator-box">
                <h2>Monthly Payment Calculator</h2>
                <form method="post">
                    <input type="text" name="mortgage" placeholder="Enter Amount of Mortgage">
                    <input type="text" name="interest" placeholder="Enter Interest Rate"> 
                    <input type="text" name="years" placeholder="Enter Number of Years">
                    <button type="submit">Submit</button>
                </form>
                
                <?php 
                    echo"<p>Monthly Payment = ";
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $mortgage = $_POST['mortgage'];
                        $interest = $_POST['interest'];
                        $years = $_POST['years'];
                        
                        if(CheckFormatValid($mortgage, $interest, $years)){
                            $monthlyPayment = calculateMonthlyPayment($mortgage, $interest, $years);
                            echo "$ $monthlyPayment</p>";
                        } else {
                            echo "</p><p>Error: invalid syntax, you may have left empty fields</p>";
                        }
                    }
                ?>
            </div>
            <div class="horizontal-boxes">
                <div class="box">
                    <h2>About Us</h2>
                    <p>We are a leading finance company providing top-notch financial services to our clients.</p>
                </div>
                <div class="box">
                    <h2>Services</h2>
                    <p>We offer a wide range of services including mortgage loans, investment advice, and financial planning.</p>
                </div>
                <div class="box">
                    <h2>Contact</h2>
                    <p>Get in touch with us at contact@fakefinance.com or call us at (123) 456-7890.</p>
                </div>
            </div>
        </div>

        <footer id="footer">
            <h1>Footer Content</h1>
        </footer>
    </body>
</html>