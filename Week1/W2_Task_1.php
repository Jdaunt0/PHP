<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Tutorial 1 - Task 1</title>
    <meta charset="utf-8" />
</head>
<body>
  <h1> my first php task </h1>
labs – week 2
<?php
  $SingleFamilyHome = 399500;
  $SingleFamilyHome_Display = number_format($SingleFamilyHome, 2);
  echo "<p>The current median price",
     " of a single-family home in Australia",
     " is $$SingleFamilyHome_Display.</p>";
?>
</body>
</html>