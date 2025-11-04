<?php
$naslov = "Pogodi broj";
$stil = "";
$poruka = "";    // Pogodak / Krivo (zelena/crvena)
$rezultat = "";  // "Zamišljeni broj je ..."
$zamisljeni = rand(1, 9);

// zapamti zadnji upis
$lastInput = isset($_POST['broj']) ? (int)$_POST['broj'] : '';

if (isset($_POST['broj'])) {
  $unos = (int)$_POST['broj'];

  if ($unos === $zamisljeni) {
    $poruka = "Pogodak, probaj ponovno!";
    $stil   = "ok";
  } else {
    $poruka = "Krivo, probaj ponovno!";
    $stil   = "bad";
  }
  $rezultat = "Zamišljeni broj je $zamisljeni.";
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($naslov) ?></title>
  <style>
    body{
      font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif;
      text-align:center; margin-top:50px
    }
    
    .form-row{
      display:flex; gap:12px; justify-content:center; align-items:stretch;
      margin-top:10px;
    }
    input[type="number"]{
      width:180px;             
      height:32px;              
      font-size:18px;           
      text-align:center;
      padding:0 14px;
      border:1px solid #ccc;
      border-radius: 12px;
      
    }
    button{
      height:32px;              
      padding:0 22px;           
      font-size:18px;           
      border-radius:12px;
      border:2px solid #2563eb;
      background:#2563eb; color:#fff;
      cursor:pointer;
    }
    button:hover{ filter:brightness(1.05); }

    .msg{
      margin-top:32px; padding:14px 16px; border-radius:10px;
      border: 2px solid transparent; display:inline-block
    }
    .ok{ background:#16a34a33; border-color:#16a34a; color:#16a34a }
    .bad{ background:#dc262633; border-color:#dc2626; color:#dc2626 }
    .hint{ margin-top:6px; color:#111827 }
  </style>
</head>
<body>
  <h1><?= htmlspecialchars($naslov) ?></h1>
  <p>Upiši broj od 1 do 9 i pokušaj pogoditi!</p>

  <form method="post" action="">
    <div class="form-row">
      <input type="number" name="broj" min="1" max="9" required
             value="<?= htmlspecialchars($lastInput) ?>" autofocus>
      <button type="submit">Pogodi!</button>
    </div>
  </form>

  <?php if ($poruka): ?>
    <div class="msg <?= $stil ?>"><?= htmlspecialchars($poruka) ?></div>
  <?php endif; ?>

  <?php if ($rezultat): ?>
    <p class="hint"><?= htmlspecialchars($rezultat) ?></p>
  <?php endif; ?>

  <footer>&copy; <?= date('Y') ?> vjezba-5.php</footer>
</body>
</html>


