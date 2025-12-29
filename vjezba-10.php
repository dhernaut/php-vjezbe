<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <title>Vježba 10 - Brojanje riječi</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    label { display: block; margin-bottom: 8px; font-weight: bold; }
    textarea { width: 100%; max-width: 700px; height: 120px; padding: 10px; font-size: 16px; }
    button { margin-top: 10px; padding: 8px 16px; font-size: 16px; cursor: pointer; }
    .rezultat { margin-top: 20px; padding: 12px; border: 1px solid #ddd; background: #f7f7f7; }
  </style>
</head>
<body>
  <h1>Zadatak: str_word_count</h1>
  <p>Unesite rečenicu, a skripta će izbrojati koliko sadrži riječi koristeći PHP funkciju <code>str_word_count</code>.</p>

  <?php
  $recenica = '';
  $brojRijeci = null;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $recenica = $_POST['recenica'] ?? '';
      // Uključi hrvatska slova u brojanje riječi
      $brojRijeci = str_word_count($recenica, 0, 'čćžšđČĆŽŠĐ');
  }
  ?>

  <form method="POST">
    <label for="recenica">Unesite rečenicu:</label>
    <textarea name="recenica" id="recenica" required><?php echo htmlspecialchars($recenica, ENT_QUOTES, 'UTF-8'); ?></textarea>
    <br>
    <button type="submit">Ispiši broj riječi</button>
  </form>

  <?php if ($brojRijeci !== null): ?>
    <div class="rezultat">
      <p>Uneseni tekst: <strong><?php echo htmlspecialchars($recenica, ENT_QUOTES, 'UTF-8'); ?></strong></p>
      <p>Ukupno riječi: <strong><?php echo $brojRijeci; ?></strong></p>
    </div>
  <?php endif; ?>
</body>
</html>
