<?php
$naslov = "Moj prvi PHP dokument";
$autor  = "Denis Hernaut";
$link   = "https://www.nati-tisak.hr/";
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($naslov); ?></title>
  <meta name="description" content="Prvi PHP dokument s osnovnim CSS stilom.">

  <style>

    :root {
      --bg: #0f172a;
      --card: #ffffff;
      --text: #111827;
      --muted: #6b7280;
      --accent: #2563eb;
    }

    * { box-sizing: border-box; }
    body {
      margin: 0;
      background: var(--bg);
      color: var(--text);
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
      line-height: 1.6;
    }

    .wrap {
      max-width: 720px;
      margin: 48px auto;
      background: var(--card);
      padding: 32px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,.08);
    }

    h1 {
      margin: 0 0 14px;
      font-size: 2rem;
    }
    p { margin: 0 0 14px; }

    footer {
      margin-top: 20px;
      font-size: .9rem;
      color: var(--muted);
    }

    a {
      color: inherit;
      text-decoration: none;
      transition: background-color .18s, color .18s, border-color .18s, opacity .18s;
    }
    a:hover { text-decoration: underline; }

    .btn {
      display: inline-block;
      padding: 10px 16px;
      border: 1px solid var(--accent);
      border-radius: 10px;
      text-decoration: none;
    }
    .btn:hover { background: var(--accent); color: #fff; text-decoration: none; }
    .btn:focus-visible { outline: 3px solid var(--accent); outline-offset: 2px; }
    .btn:active { opacity: .9; }

    @media (prefers-reduced-motion: reduce) {
      .btn { transition: none; }
    }
  </style>
</head>

<body>
  <main class="wrap">
    <h1><?php echo htmlspecialchars($naslov); ?></h1>
    <p>Ovu stranicu izradio je <strong><?php echo htmlspecialchars($autor); ?></strong>.</p>
    <p><a class="btn" href="<?php echo htmlspecialchars($link); ?>" target="_blank" rel="noopener">Posjeti NATI-TISAK.HR</a></p>
    <footer>&copy; <?php echo date('Y'); ?> — Vježba 1b</footer>
  </main>
</body>
</html>
<!-- vjezba-1b.php -->