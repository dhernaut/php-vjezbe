<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <title>Vježba 4 – izračun c</title>
</head>
<body>

<form method="POST" action="">
  <label>Vrijednost a:
    <input type="number" name="vrijednost-a" step="any"
           value="<?php echo isset($_POST['vrijednost-a']) ? htmlspecialchars($_POST['vrijednost-a']) : ''; ?>" required>
  </label><br>
  <label>Vrijednost b:
    <input type="number" name="vrijednost-b" step="any"
           value="<?php echo isset($_POST['vrijednost-b']) ? htmlspecialchars($_POST['vrijednost-b']) : ''; ?>" required>
  </label><br>
  <button type="submit">Pošalji</button>
</form>

<?php
if (isset($_POST['vrijednost-a'], $_POST['vrijednost-b'])) {
    $a = (float) $_POST['vrijednost-a'];
    $b = (float) $_POST['vrijednost-b'];
    $c = (3*$a - $b) / 2;

    echo '
      <div class="odlomak">
        <p>Predana vrijednost za a: ' . $a . '</p>
        <p>Predana vrijednost za b: ' . $b . '</p>
        <p>Dobiveno rješenje nakon prolaska kroz formulu c = (3*' . $a . ' - ' . $b . ') / 2 = ' . $c . '</p>
      </div>';
}
?>
</body>
</html>