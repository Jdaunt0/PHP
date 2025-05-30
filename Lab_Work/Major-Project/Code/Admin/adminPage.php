<html>
    <div class="mainPage">
        <h1>User List</h1>
        <?php
            $searchUsers = isset($_POST['submitUser']) ? $_POST['searchUsers'] : '';
            $checkedIn = isset($_POST['submitUser']) ? isset($_POST['checkedIn']) : false;
        ?>
        <form method="post">
            Search <input type="text" name="searchUsers" value="<?= $searchUsers ?>">
            | All users checked in: <input type="checkbox" name="checkedIn" <?= $checkedIn ? 'checked' : ''; ?>>
            | <input type="submit" name="submitUser" value="search">
        </form>

        <?= listUsers($searchUsers, $checkedIn); ?>
    </div>

    <div class="mainPage">
        <br><h1>Locations</h1><br>
        <?php 
            $searchLocations = isset($_POST['submitLocation']) ? $_POST['searchLocations'] : '';
            $available = isset($_POST['submitLocation']) ? isset($_POST['available']) : false;
            $full = isset($_POST['submitLocation']) ? isset($_POST['full']) : false;
        ?>

        <form method="post">
            Search <input type="text" name="searchLocations" value="<?= $searchLocations ?>">
            | Only Locations Available: <input type="checkbox" name="available" <?= $available ? 'checked' : ''; ?>>
            | Only Locations Full: <input type="checkbox" name="full" <?= $full ? 'checked' : ''; ?>>
            | <input type="submit" name="submitLocation" value="search">
        </form> <br>

        <?= searchLocations($searchLocations, $available, false ,false, false, $full);?>

        <br><a href="Admin/newLocation.php">Create new charging location</a><br>
    </div>
</html>