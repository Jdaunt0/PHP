<html>
    <head>
        <link rel="stylesheet" href="Stylesheet.css">
    </head>
    <a href="index.php" class="button"> < back</a><br><br>

    <div class="form">
        <h1>Register</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="Username: [5,25]"> <br><br>
            <input type="mobile" name="mobile" placeholder="Phone number: 04XX-XXX-XXX"> <br><br>
            <input type="text" name="email" placeholder="Email: name@host.com"> <br><br>
            <label for="accType">Account Type:</label>
            <select id="accType" name="accType">
                <option value="user">user</option>
                <option value="admin">admin</option>
            </select><br><br>
            <input type="text" name="password" placeholder="Password"> <br><br>
            <input type="text" name="confirm_password" placeholder="Confirm Password"> <br><br>
            <input type="submit" name="register" value="Register">
        </form>
        <?php 
        include("functions/accountFunctions.php");
        if(isset($_POST["register"])) register(); // register button function
        ?>
        <br>
        already have an account? <a href="login.php">Login here</a>
    </div>
</html>