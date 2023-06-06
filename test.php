<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php
  if (preg_match('/^assets\/profilepicture\/.*\.png$/', "assets/profilepicture/!!!!!!.png")) {
    echo "oui";
  } else {
    echo "non";
  }

  ?>
</body>

</html>