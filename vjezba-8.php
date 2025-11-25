<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <title>Vježba 8 – Vozila</title>
</head>
<body>

<?php
$cars = array("Audi", "BMW", "Renault", "Citroen");
?>

<h2>Lista vozila:</h2>
<ul>
  <?php foreach ($cars as $car): ?>
    <li><?= $car ?></li>
  <?php endforeach; ?>
</ul>

<h2>Označi vozilo:</h2>

<form action="" method="post">
  <?php foreach ($cars as $car): ?>
    <label>
      <input type="radio" name="vozila" value="<?= $car ?>"
        <?= (isset($_POST['vozila']) && $_POST['vozila'] === $car) ? 'checked' : '' ?>>
      <?= $car ?>
    </label><br>
  <?php endforeach; ?>
  <br>
  <input type="submit" value="POŠALJI">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['vozila'])) {
        $odabranoVozilo = htmlspecialchars($_POST['vozila']);
        echo "<p>Odabrali ste vozilo marke: <strong>$odabranoVozilo</strong></p>";
    } else {
        echo "<p>Niste odabrali vozilo.</p>";
    }
}
?>

</body>
</html>
