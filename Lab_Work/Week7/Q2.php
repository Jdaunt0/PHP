<?php 
    $dir = "Q2_Storage";
    #if this directiory doesnt exist, make one.
    if(!is_dir($dir)){
        mkdir($dir);
    }
?>

<html>
    <h1>Menu List</h1>
    <p>
        Create a menu and have it save locally to your computer <br>
        view the menu anytime with the click of a button <br>
        sort the menu by name or price <br>
        and search your menu for a particular dish
    </p> <br>
    
    <h3>Create Dish</h3>
    <form method="POST" action="Q2.php">
        Name: <br> <input type="text" name="name" > <br>
        Description: <br> <textarea name="description" width="600" height="300"></textarea> <br>
        Price: <br> <input type="number" name="price"> <br>
        <input type="submit" name="submitDish" value="Submit Dish">
    </form>
    <?php 
    #if the user submits a new dish, save all the inputs as values and store it as a text file
    if(isset($_POST["submitDish"])){
        $name = stripslashes($_POST["name"]);
        $description = stripslashes($_POST["description"]);
        $price = stripslashes($_POST["price"]);
                    
        $FileName = "$dir/$name.txt";
        $FileContent = $name . "\n" . $description . "\n$" . $price;
        if(!file_exists($FileName)){
            file_put_contents($FileName,$FileContent);
            echo "<p>new dish has been saved!</p>";
        }else{
            echo '<p style="color: red;">error: that dish has already been submitted</p>';
        }
    }
    ?><br>

    <form method="POST" action="Q2.php">
        Search Dishes: <input type="text" name="searchDishes">
        Sort By: 
        <select name="sortBy">
            <option>Name</option>
            <option>Price</option>
        </select>
        <button type="submit" name="viewDishes"><b>Search</b></button>
        <pre style="border: 1px solid;"></pre>
    </form>
    <?php 
    #if the user clicks the view dishes button
    if(isset($_POST["viewDishes"])){
        $search = $_POST["searchDishes"];
        $sortBy = strtolower(stripslashes($_POST["sortBy"]));
        
        echo "$search";
        $CommentFiles = scandir($dir, 1); 
        foreach ($CommentFiles as $FileName) {
            if(empty($search) || $FileName == $search . ".txt"){
                echo "<pre style='border: 1px solid; width: 500px;'>\n";
                readfile($dir . "/" . $FileName);
                echo "</pre>\n";
            }
        }
        
    }

    ?>
</html>