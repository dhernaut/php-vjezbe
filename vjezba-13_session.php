<?php
session_start();

// test vjerodajnice
$ispravniUser = 'admin';
$ispravniPass = '123';

$poruka = '';

if (isset($_POST['akcija']) && $_POST['akcija'] === 'login') {
    $user = trim($_POST['user'] ?? '');
    $pass = trim($_POST['pass'] ?? '');

    if ($user === $ispravniUser && $pass === $ispravniPass) {
        $_SESSION['login'] = $user;
        $poruka = 'Uspješna prijava!';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $poruka = 'Neispravni podaci, pokušajte ponovno.';
    }
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <title>Vježba 13 - Sesije</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    form { margin: 20px 0; }
    label { display: block; margin: 8px 0 4px; }
    input { padding: 8px; font-size: 16px; width: 240px; }
    button { padding: 8px 14px; font-size: 16px; cursor: pointer; margin-top: 10px; }
    .msg { margin: 10px 0; font-weight: bold; }
    .ok { color: green; }
    .err { color: red; }
  </style>
</head>
<body>
  <h1>Vježba 13 session (login)</h1>

  <?php if (!empty($poruka)): ?>
    <div class="msg <?php echo ($poruka === 'Uspješna prijava!') ? 'ok' : 'err'; ?>">
      <?php echo htmlspecialchars($poruka, ENT_QUOTES, 'UTF-8'); ?>
    </div>
  <?php endif; ?>

  <?php if (!isset($_SESSION['login'])): ?>
    <form method="POST">
      <input type="hidden" name="akcija" value="login">
      <label for="user">Korisnik:</label>
      <input type="text" id="user" name="user" required>

      <label for="pass">Lozinka:</label>
      <input type="password" id="pass" name="pass" required>

      <button type="submit">Prijavi se</button>
    </form>
    <p><strong>HINT:</strong> user: <code>admin</code>, pass: <code>123</code>.</p>
  <?php else: ?>
    <p>Prijavljeni ste kao: <strong><?php echo htmlspecialchars($_SESSION['login'], ENT_QUOTES, 'UTF-8'); ?></strong></p>
    <p><a href="?logout=1">Odjavi se i očisti sesiju</a></p>
  <?php endif; ?>
</body>
</html>
