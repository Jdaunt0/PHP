<?php
    // Load XML File
    $menu = simplexml_load_file("menu.xml") or die("Error: cannot find xml file");
    
    //get Search Values
    $high = null;
    $low = null;
    if (isset($_POST["submit"])) {
        $high = $_POST["high"];
        $low = $_POST["low"];
    }
?>
<html>
    <form method="POST">
        Filter By Price: <br>
        low $<input type="number" name="low"> high <input type="number" name="high"> <br>
        <input type="submit" name="submit"> <br>
    </form>

    <table>  
        <tr style="text-align: center;">
            <th colspan="2">Name</th>
            <th colspan="2">Price</th>
            <th colspan="2">Description</th>
            <th>Calories</th>
        </tr>
        <?php
        foreach($menu->children() as $food){
            $highBoundary = $high == null || $food->price < $high;
            $lowBoundary = $low == null || $food->price > $low;

            if($highBoundary && $lowBoundary){
                echo "<tr>"
                        . "<td>" . $food->name .        "<td>"
                        . "<td>" . $food->price .       "<td>"
                        . "<td>" . $food->description . "<td>"
                        . "<td>" . $food->calories .    "<td>"
                    . "<tr>";
            }
        }
        ?>
    </table>
</html>