<?php
$title = "Da Vincijev kod";
$text  = $title . " je kriminalistički triler američkog pisca Dana Browna.";
$link  = "https://hr.wikipedia.org/Da_Vincijev_kod"; // točan URL sa slajda
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Informacije o romanu Da Vincijev kod.">
  <meta name="keywords" content="Da Vincijev kod, Dan Brown, roman, triler">
  <title><?php echo $title; ?></title>
</head>
<body>
  <h1><?php echo $title; ?></h1>
  <p><?php echo $text; ?></p>
  <a href="<?php echo $link; ?>" target="_blank" rel="noopener">Poveznica</a>

  <!-- vjezba-1.php -->
</body>
</html>

