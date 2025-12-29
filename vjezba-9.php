<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <title>Vježba 9 - Dućan</title>
</head>
<body>
  <h1>Status dućana</h1>
  <?php
  // vremenska zona i trenutni datum/vrijeme
  date_default_timezone_set('Europe/Zagreb');
  $sad = new DateTime();
  setlocale(LC_TIME, 'hr_HR.UTF-8', 'hr_HR');

  // Formatiranje naziva dana u tjednu na hrvatski
  $formatDana = new IntlDateFormatter(
      'hr_HR',
      IntlDateFormatter::FULL,
      IntlDateFormatter::NONE,
      $sad->getTimezone()
  );
  $formatDana->setPattern('EEEE');
  $nazivDana = $formatDana->format($sad);

  // (dućan je otvoren ako nije postavljen drugačije)
  function ducan($stanje = "otvoren") {
      echo "Dućan je $stanje.";
  }

  // Popis praznika/blagdana (format m-d)
  $praznici = array('01-01', '01-06', '05-01', '06-22', '08-05', '08-15', '11-01', '12-25', '12-26');

  $danUTjednu = (int)$sad->format('N'); // 1 = ponedjeljak, 7 = nedjelja
  $satMinuta = (int)$sad->format('Hi');  // primjer: 1330
  $datumPraznik = $sad->format('m-d');

  // radni dan 08:00 - 20:00
  $otvara = 800;
  $zatvara = 2000;

  if ($danUTjednu === 6) { // subota
      $otvara = 900;
      $zatvara = 1400;
  } elseif ($danUTjednu === 7) { // nedjelja
      $otvara = null; // zatvoreno
      $zatvara = null;
  }

  // dućan je otvoren/zatvoren
  $stanje = "otvoren";

  if (in_array($datumPraznik, $praznici, true)) {
      $stanje = "zatvoren (praznik/blagdan)";
  } elseif ($danUTjednu === 7) {
      $stanje = "zatvoren (nedjelja)";
  } elseif ($otvara === null || $zatvara === null || $satMinuta < $otvara || $satMinuta >= $zatvara) {
      $stanje = "zatvoren";
  }
  ?>

  <p>Trenutno vrijeme: <?php echo $sad->format('d.m.Y. H:i'); ?></p>
  <p>Danas je: <?php echo $nazivDana; ?></p>
  <p>Radno vrijeme: 
    <?php
    if ($danUTjednu === 7) {
        echo "Zatvoreno (nedjelja)";
    } elseif ($danUTjednu === 6) {
        echo "09:00 - 14:00";
    } else {
        echo "08:00 - 20:00";
    }
    ?>
  </p>
  <p>
    <?php ducan($stanje); ?>
  </p>
</body>
</html>
