<?php
// vjezba-1d.php — forma + slika (nadogradnja na vjezba-1c.php)
// Osnovni PHP pojmovi: varijable, $_GET, echo, HTML, jednostavan CSS 

// Polazne vrijednosti (preuzeto iz tvoje 1c strukture)
$naslov      = "Moj prvi PHP dokument — vježba-1d";
$autor       = "Denis Hernaut";
$opis        = "Ova stranica nadograđuje vježbu 1c: biramo temu (dark/light), odabiremo sliku i po želji prikazujemo opis.";
$linkInfo    = "https://nati-tisak.hr/#onama";
$linkNatrag  = "vjezba-1c.php"; // povratak na 1c

// --- Dozvoljene vrijednosti ---
$dozvoljeneTeme  = array("dark", "light");
$dozvoljeneSlike = array(
  "NT_logo"    => "img/NT_logo.png",
  "header-sitotisak-1" => "img/header-sitotisak-1.jpg",
  "header-rototisak"   => "img/header-rototisak.jpg"
);

// --- Ulaz (GET) s default vrijednostima ---
$temaKey     = (isset($_GET["tema"])  && in_array($_GET["tema"], $dozvoljeneTeme, true)) ? $_GET["tema"]  : "dark";
//$slikaKey    = (isset($_GET["slika"]) && isset($dozvoljeneSlike[$_GET["slika"]])) ? $_GET["slika"] : $_GET["slika"];
if (isset($_GET["slika"]) && isset($dozvoljeneSlike[$_GET["slika"]])){
    $slikaKey = $_GET["slika"];
} else {
    $slikaKey = "NT_logo";
}
$prikaziOpis = isset($_GET["opis"]); // checkbox

// --- Izvedene vrijednosti za prikaz ---
$slikaPath = $dozvoljeneSlike[$slikaKey];


// Jednostavna sanitizacija za ispis u HTML
function h($s){ return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); }

// Tema → boje (CSS varijable)
if ($temaKey === "light") {
  $bg = "#f1f5f9";  // svijetla pozadina
  $card = "#ffffff";
  $text = "#0f172a";
  $muted = "#64748b";
  $accent = "#1d4ed8";
} else {
  $bg = "#0f172a";  // tamna pozadina
  $card = "#ffffff";
  $text = "#111827";
  $muted = "#6b7280";
  $accent = "#2563eb";
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Vježba 1d — forma (GET), izbor teme i slike, osnovni CSS.">
  <title><?php echo h($naslov); ?></title>
  <style>
    :root{
      --bg: <?php echo $bg; ?>;
      --card: <?php echo $card; ?>;
      --text: <?php echo $text; ?>;
      --muted: <?php echo $muted; ?>;
      --accent: <?php echo $accent; ?>;
    }
    *{ box-sizing: border-box; }
    body{
      margin:0; background:var(--bg); color:var(--text);
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
      line-height:1.6;
    }
    .wrap{
      max-width: 720px; margin: 48px auto; background: var(--card);
      padding: 32px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,.08);
    }
    h1{ margin:0 0 14px; font-size:2rem; line-height:1.2; }
    p{ margin:0 0 14px; }
    .muted{ color: var(--muted); font-size:.95rem; }

    /* Slika */
    .figure{ margin:10px 0 16px; }
    .figure img{ max-width:100%; height:auto; display:block; border-radius:10px; box-shadow:0 6px 18px rgba(0,0,0,.08); }

    /* Linkovi / gumbi */
    a{ color:inherit; text-decoration:none; transition:background-color .18s, color .18s, border-color .18s, opacity .18s; }
    a:hover{ text-decoration:underline; }

    .btn, .btn:link, .btn:visited{
      display:inline-block; padding:10px 16px; border:1px solid var(--accent);
      border-radius:10px; text-decoration:none; line-height:1; cursor:pointer;
      background:transparent; color:var(--accent);
    }
    .btn:hover{ background:var(--accent); color:#fff; text-decoration:none; }
    .btn:focus-visible{ outline:3px solid var(--accent); outline-offset:2px; }
    .btn:active{ opacity:.9; }

    /* Forma */
    form{ margin-top:8px; }
    fieldset{ border:1px solid #e5e7eb; border-radius:10px; padding:10px 12px; margin:10px 0; }
    legend{ padding:0 6px; color: var(--muted); }
    label{ display:block; margin:6px 0; }
    select, input[type="radio"], input[type="checkbox"]{ margin-right:6px; }
    .row{ display:flex; gap:12px; flex-wrap:wrap; margin-top:10px; }
  </style>
</head>
<body>
  <main class="wrap">
    <h1><?php echo h($naslov); ?></h1>
    <p><?php echo h($opis); ?></p>
    <p>Ovu stranicu izradio je <strong><?php echo h($autor); ?></strong>.</p>

    <!-- Slika po izboru -->
    <div class="figure">
        <img src="<?php echo($slikaPath); ?>" alt="<?php echo($slikaKey); ?>">
    </div>

    <!-- Opcijski opis -->
    <?php if ($prikaziOpis): ?>
      <p class="muted"><?php echo h($opis); ?></p>
    <?php endif; ?>

    <!-- GET forma -->
    <form method="get" action="vjezba-1d.php">
      <fieldset>
        <legend>Odaberi temu</legend>
        <label><input type="radio" name="tema" value="dark"  <?php echo $temaKey==="dark"  ? "checked" : ""; ?>> Dark</label>
        <label><input type="radio" name="tema" value="light" <?php echo $temaKey==="light" ? "checked" : ""; ?>> Light</label>
      </fieldset>

      <fieldset>
        <legend>Odaberi sliku</legend>
        <label for="slika">Slika:</label>
        <select id="slika" name="slika">
          <option value="NT_logo"    <?php echo $slikaKey==="NT_logo"     ? "selected" : ""; ?>>NT_logo </option>
          <option value="header-sitotisak-1" <?php echo $slikaKey==="header-sitotisak-1" ? "selected" : ""; ?>>header-sitotisak-1</option>
          <option value="header-rototisak"   <?php echo $slikaKey==="header-rototisak"   ? "selected" : ""; ?>>header-rototisak</option>
        </select>
      </fieldset>

      <label><input type="checkbox" name="opis" <?php echo $prikaziOpis ? "checked" : ""; ?>> Prikaži opis</label>

      <div class="row">
        <button class="btn" type="submit">Primijeni odabir</button>
        <a class="btn" href="<?php echo h($linkNatrag); ?>">Natrag na vježba 1c</a>
      </div>
    </form>

    <p style="margin-top:16px;"><a class="btn" href="<?php echo h($linkInfo); ?>" target="_blank" rel="noopener">Saznaj više o NATI TISAK</a></p>

    <p class="muted">© <?php echo date("Y"); ?> — Vježba 1d</p>
  </main>
</body>
</html>
<!-- Naziv datoteke: vjezba-1d.php -->
