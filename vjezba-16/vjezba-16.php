<?php
// register.php
$con = mysqli_connect(
  "localhost",
  "root",
  "root",
  "my_db",
  8889,
  "/Applications/MAMP/tmp/mysql/mysql.sock"
);

if (!$con) die("DB error");

$errors = [];
$success = false;

function h($s){ return htmlspecialchars($s ?? "", ENT_QUOTES, "UTF-8"); }

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $first_name = trim($_POST["first_name"] ?? "");
  $last_name  = trim($_POST["last_name"] ?? "");
  $email      = trim($_POST["email"] ?? "");
  $username   = trim($_POST["username"] ?? "");
  $password   = $_POST["password"] ?? "";
  $country    = trim($_POST["country"] ?? "");

  if ($first_name === "") $errors[] = "First name is required.";
  if ($last_name === "")  $errors[] = "Last name is required.";
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
  if (strlen($username) < 5 || strlen($username) > 10) $errors[] = "Username must be 5-10 characters.";
  if (strlen($password) < 4) $errors[] = "Password must be at least 4 characters.";
  if ($country === "") $errors[] = "Country is required.";

  if (!$errors) {
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (first_name,last_name,email,username,password,country)
            VALUES (?,?,?,?,?,?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $first_name, $last_name, $email, $username, $hash, $country);

    if (mysqli_stmt_execute($stmt)) {
      $success = true;
    } else {
      if (mysqli_errno($con) == 1062) $errors[] = "Email or username already exists.";
      else $errors[] = "Insert error.";
    }

    mysqli_stmt_close($stmt);
  }
}

$countries = [
  "molimo odaberite",
  "Croatia","Slovenia","Serbia","Bosnia and Herzegovina","Montenegro","North Macedonia",
  "Austria","Germany","Italy","Hungary","France","Spain","United Kingdom","USA"
];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Registration Form</title>
  <style>
    body{font-family:Arial,sans-serif;background:#f5f5f5}
    .wrap{max-width:520px;margin:40px auto;background:#fff;padding:24px;border-radius:10px}
    label{display:block;margin:14px 0 6px;font-weight:700}
    input,select{width:100%;padding:10px;border:1px solid #ccc;border-radius:4px}
    small{color:#c00;font-weight:700}
    button{margin-top:18px;width:100%;padding:12px;border:0;border-radius:4px;background:#18a84b;color:#fff;font-weight:800}
    .msg{margin-top:14px}
    .err{color:#b00020}
    .ok{color:#0a7a2b}
  </style>
</head>
<body>
  <div class="wrap">
    <h2>Registration Form</h2>

    <?php if ($success): ?>
      <p class="msg ok">Saved successfully.</p>
    <?php endif; ?>

    <?php if ($errors): ?>
      <div class="msg err">
        <ul>
          <?php foreach ($errors as $e) echo "<li>".h($e)."</li>"; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post" action="">
      <label>First Name *</label>
      <input type="text" name="first_name" value="<?=h($_POST["first_name"] ?? "")?>" required>

      <label>Last Name *</label>
      <input type="text" name="last_name" value="<?=h($_POST["last_name"] ?? "")?>" required>

      <label>Your E-mail *</label>
      <input type="email" name="email" value="<?=h($_POST["email"] ?? "")?>" required>

      <label>Username * <small>(min 5 max 10 char)</small></label>
      <input type="text" name="username" minlength="5" maxlength="10" value="<?=h($_POST["username"] ?? "")?>" required>

      <label>Password * <small>(min 4 char)</small></label>
      <input type="password" name="password" minlength="4" required>

      <label>Country:</label>
      <select name="country" required>
        <?php
          $sel = $_POST["country"] ?? "";
          foreach ($countries as $c) {
            if ($c === "molimo odaberite") {
              $selected = ($sel === "" || $sel === $c) ? "selected" : "";
              echo "<option value='' $selected>molimo odaberite</option>";
            } else {
              $selected = ($sel === $c) ? "selected" : "";
              echo "<option value='".h($c)."' $selected>".h($c)."</option>";
            }
          }
        ?>
      </select>

      <button type="submit">Submit</button>
    </form>
  </div>
</body>
</html>
<?php mysqli_close($con); ?>
