<?php
// vjezba-17.php
$con = mysqli_connect(
  "localhost",
  "root",
  "root",
  "vjezba_17",
  8889,
  "/Applications/MAMP/tmp/mysql/mysql.sock"
);

if (!$con) die("DB error");

$sql = "SELECT u.first_name, u.last_name, c.name AS country
        FROM users u
        JOIN countries c ON c.id = u.country_id
        ORDER BY u.last_name ASC, u.first_name ASC";

$res = mysqli_query($con, $sql);
?>
<!doctype html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <title>Users and Countries</title>
  <style>
    body{font-family:Arial,sans-serif;background:#f5f5f5}
    .wrap{max-width:640px;margin:40px auto;background:#fff;padding:24px;border-radius:10px}
    ul{list-style:none;padding:0;margin:0}
    li{padding:8px 0;border-bottom:1px solid #eee}
    .name{font-weight:700}
    .country{color:#666}
  </style>
</head>
<body>
  <div class="wrap">
    <h2>Korisnik (država)</h2>

    <?php if ($res && mysqli_num_rows($res) > 0): ?>
      <ul>
        <?php while ($row = mysqli_fetch_assoc($res)): ?>
          <li>
            <?=htmlspecialchars($row["first_name"])?> <?=htmlspecialchars($row["last_name"])?>
            (<?=htmlspecialchars($row["country"])?>)
          </li>
        <?php endwhile; ?>
      </ul>
    <?php else: ?>
      <p>Nema korisnika.</p>
    <?php endif; ?>
  </div>
</body>
</html>
<?php mysqli_close($con); ?>
