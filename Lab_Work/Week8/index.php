<!doctype HTML>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
    </head>
    
    <header>
        <h1 id="heading">Handyman Needed</h1>
        <div id="nav"> 
            <h3 id="about">about us</h3>
            <a href="booking.php" class="button"><h3>Book Now</h3></a>
            <a href="handyman.php" class="button"><h3>View Listings</h3></a>
        </div>    
    </header>

    <body>
        <h3>Need a handyman?</h3>
        <a href="booking.php" class="button"><h2>Book Now</h2></a>

        <h3>Wanna work as a handyman?</h3>
        <a href="handyman.php" class="button"><h2>View Listings</h2></a>

        <div id="about-box">
            <h3>about us</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod eos nesciunt eveniet illo ea iste ad? Consectetur, sit? Quos hic repellendus sunt temporibus atque eius provident suscipit dolorum accusantium vel! lorem</p>
        </div>
    </body>

    <footer>
        <?php 
        $time = date("Y-m-d H:i:s");
        echo"$time";
        ?>
    </footer>
</html>