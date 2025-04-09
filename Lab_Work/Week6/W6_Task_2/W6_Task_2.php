<?php 
$Dir = "menu";
if (is_dir($Dir)) { //chechs if the directory "menu" exists
    if (isset($_POST['save'])) { //on press save
        //set the variables
        $Name = stripslashes($_POST['name']);
        $Description = stripslashes($_POST['description']);
        $Price = stripslashes($_POST['price']);

        $SaveString = $Name . "\n" . $Description . "\n$" . $Price;
        $FileName = "$Dir/$Name.txt";
        
        if (!file_exists($FileName)) { // Use file_exists() to check if the file already existsame))
            if (file_put_contents($FileName, $SaveString) > 0)
                echo "File \"" . htmlentities($FileName) . "\" successfully saved.<br />\n";
            else
                echo "There was an error writing \"" . htmlentities($FileName) . "\".<br />\n";
        } else {
            echo "Dish already exists.<br />\n";
        }
    }
}
?>

<html>
    <body>
        <h1>Menu List</h1>
        <form action="W6_Task_2.php" method="POST">
            name: <input type="text" name="name" /><br />
            description:<br />
            <textarea name="description" rows="6" cols="100"></textarea><br />
            price: <input type="number" name="price" /><br />
            <input type="submit" name="save" value="Submit dish" /><br />
            <br />
            <input type="submit" name="menu" value="Print Menu" /><br />
        </form>
        <?php 
        if (is_dir($Dir))
            if (isset($_POST["menu"])) {
                $CommentFiles = scandir($Dir, 1);
                foreach ($CommentFiles as $FileName) {
                    if (($FileName != ".") && ($FileName != "..")) {
                        echo "From <strong>$FileName</strong><br />";
                        echo "<pre>\n";
                        readfile($Dir . "/" . $FileName);
                        echo "</pre>\n";
                        echo "<hr />\n";
                    }
                }
            }
        ?>
    </body>
</html>