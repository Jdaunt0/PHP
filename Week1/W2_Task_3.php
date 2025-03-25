<! DOCTYPE html>
<html lang="eu">
    <?php
    function FahtoCel($fah) {
        $cel = ($fah -32) * (9/5);
        return $cel;
    }

    function CelToFah($cel) {
        $fah = ($cel * (5/9)) + 32;
        return $fah;
    }

    for ($fah = 0; $fah <= 100; $fah++) {
        $cel = FahtoCel($fah);
        echo "<li>Fahrenheit: $fah",
             ", Celsius: $cel </li>";
      }
    ?>


</html>