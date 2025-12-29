<?php
session_start();

// Funkcija koja provjerava je li broj prost
function jeProst(int $broj): bool {
    if ($broj <= 1) {
        return false;
    }
    $granica = (int)floor(sqrt($broj));
    for ($i = 2; $i <= $granica; $i++) {
        if ($broj % $i === 0) {
            return false;
        }
    }
    return true;
}

$uneseniBroj = '';
$poruka = null;

// POST spremi poruku u sesiju i kod refresh-a ne ponavlja rezultat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uneseniBroj = trim($_POST['broj'] ?? '');
    if ($uneseniBroj === '' || !is_numeric($uneseniBroj) || (int)$uneseniBroj != $uneseniBroj) {
        $poruka = 'Molimo unesite cijeli broj.';
    } else {
        $uneseniBroj = (int)$uneseniBroj;
        $poruka = jeProst($uneseniBroj)
            ? "Broj $uneseniBroj je prost."
            : "Broj $uneseniBroj nije prost.";
    }

    $_SESSION['flash_poruka'] = $poruka;
    $_SESSION['flash_uneseni'] = $uneseniBroj;
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// GET preuzima poruku ako postoji, pa je uklanja iz sesije
if (isset($_SESSION['flash_poruka'])) {
    $poruka = $_SESSION['flash_poruka'];
    $uneseniBroj = $_SESSION['flash_uneseni'] ?? '';
    unset($_SESSION['flash_poruka'], $_SESSION['flash_uneseni']);
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <title>Vježba 11 - Prosti brojevi</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    h1 { margin-bottom: 10px; }
    form { margin: 20px 0; }
    input[type="number"] { padding: 6px; font-size: 16px; width: 160px; }
    button { padding: 8px 14px; font-size: 16px; cursor: pointer; }
    .rezultat { margin-top: 15px; padding: 12px; border: 1px solid #ddd; background: #f7f7f7; }
  </style>
</head>
<body>
  <h1>Provjera prostih brojeva</h1>
  <p>Funkcija provjerava je li broj prost i ispisuje sve proste brojeve manje od 100.</p>

  <form method="POST">
    <label for="broj">Unesite broj za provjeru:</label><br>
    <input type="number" name="broj" id="broj" value="<?php echo htmlspecialchars($uneseniBroj, ENT_QUOTES, 'UTF-8'); ?>" required>
    <button type="submit">Provjeri</button>
  </form>

  <?php if ($poruka !== null): ?>
    <div class="rezultat"><?php echo htmlspecialchars($poruka, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php
    // Prikazuje proste brojeve samo kad prikazujemo rezultat
    $prostiManjiOdSto = array();
    for ($n = 2; $n < 100; $n++) {
        if (jeProst($n)) {
            $prostiManjiOdSto[] = $n;
        }
    }
    ?>
    <div class="rezultat">
      <strong>Prosti brojevi manji od 100:</strong><br>
      <?php echo implode(', ', $prostiManjiOdSto); ?>
    </div>
  <?php endif; ?>
</body>
</html>
