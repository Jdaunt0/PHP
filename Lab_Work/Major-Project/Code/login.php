<html>
    <head>
        <link rel="stylesheet" href="Stylesheet.css">
    </head>
    <a href="index.php" class="button"> < back</a><br><br>

    <div class="form">
        <h1>Login</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="Username"> <br><br>
            <input type="text" name="password" placeholder="Password"> <br><br>
            <input type="submit" name="login" value="Login">
        </form>
        <?php  
        include("functions/accountFunctions.php");
        if(isset($_POST["login"])) login(); // login button function
        ?>
        <br>
        <p>dont have an account? <a href="register.php">Register here</a> </p> 
    </div>

</html>