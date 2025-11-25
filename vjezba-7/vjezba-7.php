<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <title>Vježba-7</title>
  <link rel="stylesheet" href="stil.css">
</head>
<body>
  <h1>Izračun ocjene iz kolokvija</h1>
  <p>
    Upišite ocjene iz dva kolokvija (1-5). Ako je jedan od kolokvija negativan (1), konačna ocjena je također 1.
    Inače, konačna ocjena je zaokruženi prosjek ocjena iz kolokvija.
  </p>

  <form action="" method="POST" id="izracun-ocjene">
    <label for="ocjena1">Ocjena I kolokvija:</label>
    <input type="number" name="ocjena1" id="ocjena1" min="1" max="5" required autofocus>
    <br><br>

    <label for="ocjena2">Ocjena II kolokvija:</label>
    <input type="number" name="ocjena2" id="ocjena2" min="1" max="5" required>
    <br><br>

    <input type="submit" value="Izračunaj">
  </form>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $ocjene = array(
          (int)$_POST['ocjena1'],
          (int)$_POST['ocjena2']
      );

      if ($ocjene[0] < 1 || $ocjene[0] > 5 || $ocjene[1] < 1 || $ocjene[1] > 5) {
          echo '<p class="greska">Krivi unos (ocjene moraju biti između 1 i 5).</p>';
      } elseif ($ocjene[0] == 1 || $ocjene[1] == 1) {
          echo '<p class="greska">Jedan od kolokvija je negativan pa je zaključna ocjena 1.</p>';
      } else {
          $prosjek = array_sum($ocjene) / count($ocjene);

          echo '<div class="rezultat">
                  <p>Ocjena I kolokvija: ' . $ocjene[0] . '</p>
                  <p>Ocjena II kolokvija: ' . $ocjene[1] . '</p>
                  <hr>
                  <p>Srednja ocjena iz predmeta: ' . $prosjek . '</p>
                  <p>Konačna ocjena iz predmeta: ' . round($prosjek) . '</p>
                </div>';
      }
  }
  ?>
</body>
</html>
