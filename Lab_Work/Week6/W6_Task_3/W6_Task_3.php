<!DOCTYPE html>
<?php
$dir = "photos";
if (!is_dir($dir)){
    mkdir($dir);
}

if(isset($_POST['submit'])){
    $Name = stripslashes($_POST['name']);
    $Description = stripslashes($_POST['description']);
    $ImgName = stripslashes($_POST['img']);
    
    $FileName = "$dir/$ImgName.txt";
    $FileContent = $Name . "\n" . $Description;
    
    file_put_contents($FileName,$FileContent);
    
    //echo "<p>file name: $FileName <br>file content: $FileContent <br>img name: $ImgName<p>";
}

?>
<html>
    <form action="W6_Task_3.php" method="POST">
        Pets Name: <input type="text" name="name"/> <br>
        Image Description: <br>
        <textarea width="100" height="100" name="description"> </textarea><br>
        Upload Image: <input type="file" name="img"/> <br>
        <input type="submit" name="submit" value="Submit" /><br />
    </form>
</html>