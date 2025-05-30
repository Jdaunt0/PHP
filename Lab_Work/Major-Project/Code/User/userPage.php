<html>
    <div class="mainPage">
        <h1>Charging Locations: </h1>
        <?php //Filters
            $searchTerm = $_POST['search'];
            $availablity = $_POST['available'];
            $previous = $_POST['previous'];
            $using = $_POST['using'];
        ?>
        <form method="post">
            Search <input type="text" name="search" value="<?= $searchTerm?>">
            | Only available: <input type="checkbox" name="available" <?= $availablity ? 'checked' : ''; ?>>
            | Previously used: <input type="checkbox" name="previous" <?= $previous ? 'checked' : ''; ?>> 
            | Currently using: <input type="checkbox" name="using" <?= $using ? 'checked' : ''; ?>>
            | <input type="submit" name="submit" value="search">
        </form>


        <?=searchLocations($searchTerm, $availablity, $previous, $using, True);?>
    </div>
</html>