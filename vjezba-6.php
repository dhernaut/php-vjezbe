<?php
$rezultat = '';
$porukaGreske = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prvi  = (float)$_POST['prvi_broj'];
    $drugi = (float)$_POST['drugi_broj'];
    $op    = $_POST['op'] ?? '';

    switch ($op) {
        case '+':
            $rezultat = $prvi + $drugi;
            break;
        case '-':
            $rezultat = $prvi - $drugi;
            break;
        case '*':
            $rezultat = $prvi * $drugi;
            break;
        case '/':
            if ($drugi == 0) {
                $porukaGreske = 'Greška: ne može se dijeliti s nulom.';
            } else {
                $rezultat = $prvi / $drugi;
            }
            break;
        default:
            $porukaGreske = 'Odaberite operaciju.';
    }
}
?>
<!doctype html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="number"] {
            padding: 6px;
            font-size: 16px;
            width: 200px;
        }
        button {
            padding: 10px 18px;
            margin: 6px 4px 0 0;
            font-size: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            cursor: pointer;
            background-color: #f5f5f5;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }
        button:hover {
            background-color: #e0e0e0;
            transform: translateY(-1px);
        }
        .rezultat {
            margin-top: 20px;
            font-size: 18px;
        }
        .greska {
            color: red;
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <h1>Kalkulator</h1>

    <form method="post">
        <label>
            Upiši prvi broj *
            <input type="number" step="any" name="prvi_broj" required
                   value="<?= isset($_POST['prvi_broj']) ? htmlspecialchars($_POST['prvi_broj']) : '' ?>">
        </label>

        <label>
            Upiši drugi broj *
            <input type="number" step="any" name="drugi_broj" required
                   value="<?= isset($_POST['drugi_broj']) ? htmlspecialchars($_POST['drugi_broj']) : '' ?>">
        </label>

        <button type="submit" name="op" value="+">+</button>
        <button type="submit" name="op" value="-">-</button>
        <button type="submit" name="op" value="*">*</button>
        <button type="submit" name="op" value="/">/</button>
    </form>

    <?php if ($porukaGreske): ?>
        <div class="greska"><?= $porukaGreske ?></div>
    <?php elseif ($rezultat !== ''): ?>
        <div class="rezultat">Rezultat: <?= $rezultat ?></div>
    <?php endif; ?>
</body>
</html>