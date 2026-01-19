<!-- search.php -->
<!doctype html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <title>Tražilica korisnika</title>
</head>
<body>

<form method="post" action="">
  <label>Ime ili prezime:</label>
  <input type="text" name="term" required>
  <button type="submit">Pretraži</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $term = trim($_POST["term"]);

  $con = mysqli_connect("localhost", "root", "123", "my_db");
  if (!$con) die("DB error");

  $sql = "SELECT name, lastname, username, country_code, about, date
          FROM users
          WHERE name LIKE ? OR lastname LIKE ?
          ORDER BY lastname ASC
          LIMIT 50";

  $stmt = mysqli_prepare($con, $sql);
  $like = "%".$term."%";
  mysqli_stmt_bind_param($stmt, "ss", $like, $like);
  mysqli_stmt_execute($stmt);

  $res = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($res) === 0) {
    echo "<p>Nema rezultata.</p>";
  } else {
    echo "<h3>Rezultati:</h3><ul>";
    while ($row = mysqli_fetch_assoc($res)) {
      echo "<li>"
        . htmlspecialchars($row["name"]) . " "
        . htmlspecialchars($row["lastname"])
        . " (" . htmlspecialchars($row["username"]) . ")"
        . "</li>";
    }
    echo "</ul>";
  }

  mysqli_stmt_close($stmt);
  mysqli_close($con);
}
?>

</body>
</html>
