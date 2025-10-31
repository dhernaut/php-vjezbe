<?php
mb_internal_encoding('UTF-8');
session_start();

$naslov = "🪨✂️📄 Kamen, škare, papir";
$autor  = "Denis Hernaut";

$opcije = [
  "kamen" => "🪨",
  "skare" => "✂️",
  "papir" => "📄"
];

// inicijalizacija rezultata u sesiji
if (!isset($_SESSION['score'])) {
  $_SESSION['score'] = ['igrac' => 0, 'racunalo' => 0, 'nerijeseno' => 0];
}

// Reset rezultata
if (isset($_POST['reset']) && $_POST['reset'] === '1') {
  $_SESSION['score'] = ['igrac' => 0, 'racunalo' => 0, 'nerijeseno' => 0];
  $_GET['odabir'] = null;
}

function titleHR($s){ return mb_convert_case($s, MB_CASE_TITLE, 'UTF-8'); }
// Igrač bira
$igrac = (isset($_GET['odabir']) && array_key_exists($_GET['odabir'], $opcije)) ? $_GET['odabir'] : null;
// Računalo bira samo kad igrač odabere
$racunalo = $igrac ? array_rand($opcije) : null;

$rezultat = "";
if ($igrac && $racunalo) {
  if ($igrac === $racunalo) {
    $_SESSION['score']['nerijeseno']++;
    $rezultat = "🤝 Neriješeno! Oboje ste izabrali " . titleHR($igrac) . ".";
  } elseif (
    ($igrac === "kamen" && $racunalo === "skare") ||
    ($igrac === "skare" && $racunalo === "papir") ||
    ($igrac === "papir" && $racunalo === "kamen")
  ) {
    $_SESSION['score']['igrac']++;
    $rezultat = "Pobijedio si! " . titleHR($igrac) . " pobjeđuje " . titleHR($racunalo) . ".";
  } else {
    $_SESSION['score']['racunalo']++;
    $rezultat = "Računalo pobjeđuje! " . titleHR($racunalo) . " pobjeđuje " . titleHR($igrac) . ".";
  }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($naslov) ?></title>

  <!-- Inter font (https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap) -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

  <style>
    :root { --bg:#0f172a; --card:#ffffff; --text:#111827; --muted:#6b7280; --accent:#2563eb; }
    *{ box-sizing:border-box; }
    body{
      margin:0; background:var(--bg); color:var(--text);
      font-family:"Inter", system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
      line-height:1.6; text-align:center;
    }
    .wrap{
      max-width:720px; margin:48px auto; background:var(--card);
      padding:32px; border-radius:20px; box-shadow:0 10px 30px rgba(0,0,0,.08);
    }
    h1{ margin-bottom:8px; font-size:2.2rem; }
    .sub{ color:var(--muted); margin-top:0; }
    .choices{ display:flex; justify-content:center; gap:28px; flex-wrap:wrap; margin:26px 0; }
    button.choice{
      border:none; background:transparent; cursor:pointer; font-size:4rem;
      transition:transform .2s, filter .2s;
    }
    button.choice:hover{ transform:scale(1.2); filter:brightness(1.25); }
    .rezultat{ margin-top:18px; font-size:1.2rem; font-weight:600; }
    .score{
      display:flex; justify-content:center; gap:18px; margin-top:18px;
      font-weight:600;
    }
    .badge{
      display:inline-block; padding:6px 10px; border-radius:999px; border:1px solid var(--accent);
    }
    .actions{ margin-top:18px; display:flex; gap:10px; justify-content:center; flex-wrap:wrap; }
    .btn{
      display:inline-block; padding:10px 16px; border:1px solid var(--accent);
      border-radius:10px; text-decoration:none; cursor:pointer; background:transparent; color:var(--accent);
      transition:background-color .18s, color .18s, border-color .18s, opacity .18s;
      font: inherit;
    }
    .btn:hover{ background:var(--accent); color:#fff; }
    .muted{ color:var(--muted); margin-top:26px; }
  </style>
</head>
<body>
  <main class="wrap">
    <h1><?= htmlspecialchars($naslov) ?></h1>
    <p class="sub">Ovu igru izradio je <strong><?= htmlspecialchars($autor) ?></strong>.</p>

    <p>Odaberi svoj potez:</p>
    <!-- Odabir (GET) -->
    <form method="get" action="">
      <div class="choices">
        <?php foreach ($opcije as $naziv => $emoji): ?>
          <button class="choice" type="submit" name="odabir" value="<?= htmlspecialchars($naziv) ?>" aria-label="Odaberi <?= htmlspecialchars($naziv) ?>">
            <?= $emoji ?>
          </button>
        <?php endforeach; ?>
      </div>
    </form>

    <?php if ($igrac && $racunalo): ?>
      <div class="rezultat">
        <p>Tvoj odabir: <strong><?= $opcije[$igrac] ?> <?= titleHR($igrac) ?></strong></p>
        <p>Računalo: <strong><?= $opcije[$racunalo] ?> <?= titleHR($racunalo) ?></strong></p>
        <p><?= htmlspecialchars($rezultat) ?></p>
      </div>
    <?php endif; ?>

    <!-- Scoreboard -->
    <div class="score" aria-label="Rezultati">
      <span class="badge">Ti: <?= (int)$_SESSION['score']['igrac'] ?></span>
      <span class="badge">Računalo: <?= (int)$_SESSION['score']['racunalo'] ?></span>
      <span class="badge">Neriješeno: <?= (int)$_SESSION['score']['nerijeseno'] ?></span>
    </div>

    <!-- Reset rezultata (POST da ne mijenja URL) -->
    <div class="actions">
      <form method="post" action="" style="margin:0;">
        <input type="hidden" name="reset" value="1">
        <button class="btn" type="submit">Resetiraj rezultat</button>
      </form>
    </div>

    <p class="muted">&copy; <?= date("Y") ?> — Igra Kamen, Škare, Papir</p>
  </main>
</body>
</html>

