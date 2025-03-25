<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Tutorial 1 - Task 1</title>
    <meta charset="utf-8" />
</head>
<body>
  <h1> lab 2 – week 2 </h1>

<?php
  for ($i = 0; $i <= 100; $i++) {
    $x = ($i -32) * (9/5);
    echo "<li>Fahrenheit: $i",
         ", Celsius: $x </li>";
  }
?>
</body>
</html>
