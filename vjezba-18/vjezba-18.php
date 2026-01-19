<?php
// vjezba-18.php
$con = mysqli_connect(
  "localhost",
  "root",
  "root",
  "vjezba_18",
  8889,
  "/Applications/MAMP/tmp/mysql/mysql.sock"
);

if (!$con) die("DB error");

$message = "";
$errors = [];

function h($s){ return htmlspecialchars($s ?? "", ENT_QUOTES, "UTF-8"); }

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $user_id = (int)($_POST["user_id"] ?? 0);
  $first_name = trim($_POST["first_name"] ?? "");
  $last_name = trim($_POST["last_name"] ?? "");
  $country_id = (int)($_POST["country_id"] ?? 0);

  if ($user_id <= 0) $errors[] = "Invalid user.";
  if ($first_name === "") $errors[] = "First name is required.";
  if ($last_name === "") $errors[] = "Last name is required.";
  if ($country_id <= 0) $errors[] = "Country is required.";

  if (!$errors) {
    $sql = "UPDATE users SET first_name = ?, last_name = ?, country_id = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssii", $first_name, $last_name, $country_id, $user_id);
    if (mysqli_stmt_execute($stmt)) {
      $message = "Updated.";
    } else {
      $errors[] = "Update error.";
    }
    mysqli_stmt_close($stmt);
  }
}

$countries = [];
$res_c = mysqli_query($con, "SELECT id, name FROM countries ORDER BY name ASC");
while ($row = mysqli_fetch_assoc($res_c)) {
  $countries[] = $row;
}

$users = [];
$sql = "SELECT u.id, u.first_name, u.last_name, u.country_id, c.name AS country
        FROM users u
        JOIN countries c ON c.id = u.country_id
        ORDER BY u.last_name ASC, u.first_name ASC";
$res_u = mysqli_query($con, $sql);
while ($row = mysqli_fetch_assoc($res_u)) {
  $users[] = $row;
}
?>
<!doctype html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <title>Users Edit</title>
  <style>
    body{font-family:Arial,sans-serif;background:#f5f5f5}
    .wrap{max-width:760px;margin:40px auto;background:#fff;padding:24px;border-radius:10px}
    table{width:100%;border-collapse:collapse}
    th,td{border-bottom:1px solid #eee;padding:10px;text-align:left}
    input,select{padding:6px;border:1px solid #ccc;border-radius:4px}
    button{padding:6px 10px;border:0;border-radius:4px;background:#18a84b;color:#fff;font-weight:700}
    .msg{margin:10px 0}
    .err{color:#b00020}
    .ok{color:#0a7a2b}
  </style>
</head>
<body>
  <div class="wrap">
    <h2>Lista korisnika</h2>

    <?php if ($message): ?>
      <div class="msg ok"><?=h($message)?></div>
    <?php endif; ?>
    <?php if ($errors): ?>
      <div class="msg err"><?=h(implode(" ", $errors))?></div>
    <?php endif; ?>

    <table>
      <thead>
        <tr>
          <th>Korisnik</th>
          <th>Drzava</th>
          <th>Akcija</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $u): ?>
          <tr>
            <td>
              <form method="post" action="">
                <input type="hidden" name="user_id" value="<?=h($u["id"])?>">
                <input type="text" name="first_name" value="<?=h($u["first_name"])?>" required>
                <input type="text" name="last_name" value="<?=h($u["last_name"])?>" required>
            </td>
            <td>
                <select name="country_id" required>
                  <option value="">odaberite</option>
                  <?php foreach ($countries as $c): ?>
                    <?php $sel = ((int)$u["country_id"] === (int)$c["id"]) ? "selected" : ""; ?>
                    <option value="<?=h($c["id"])?>" <?=$sel?>><?=h($c["name"])?></option>
                  <?php endforeach; ?>
                </select>
            </td>
            <td>
                <button type="submit">Spremi</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
<?php mysqli_close($con); ?>
