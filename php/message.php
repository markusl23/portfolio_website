<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    // Validierung: Vorname und E-Mail sind Pflicht
    if (empty($first_name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid input!");
    }

    // Sichere Speicherort für die CSV-Datei
    $file = "/var/www/worldwide-impact.org/private/messages.csv";

    // Prüfen, ob der Ordner existiert, falls nicht: anlegen
    if (!file_exists(dirname($file))) {
        mkdir(dirname($file), 0755, true);
    }

    // Daten speichern (Header hinzufügen, falls Datei neu erstellt wird)
    $is_new_file = !file_exists($file);
    $fileHandle = fopen($file, "a");

    if ($is_new_file) {
        fputcsv($fileHandle, ["First Name", "Last Name", "Phone", "Email", "Message", "Timestamp"]);
    }

    fputcsv($fileHandle, [$first_name, $last_name, $phone, $email, $message, date("Y-m-d H:i:s")]);
    fclose($fileHandle);

    echo '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="img/M_L_logo.ico">
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link rel="stylesheet" type="text/css" href="css/normalize.css">
  <title>M.L.: Message received</title>
</head>
<body>
  <header>
    <nav>
      <img id="logo" src="img/M_L_logo.png" alt="M L logo">
      <ul role="menubar">
        <li role="presentation"><a role="menuitem" href="contact.html" target="_self">Contact</a></li>
        <li role="presentation"><a role="menuitem" href="work.html" target="_self">Work</a></li>
        <li role="presentation"><a role="menuitem" href="index.html" target="_self">Home</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <p>Thank you for your message, you will receive a reply shortly!</p>
  </main>
  <footer>
    <div class="footer">
      <a href="imprint.html">Imprint</a>
      <a href="gdpr.html">GDPR</a>
      <p>©2025</p>
    </div>
  </footer>
</body>
</html>';
} else {
    die('<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="img/M_L_logo.ico">
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link rel="stylesheet" type="text/css" href="css/normalize.css">
  <title>M.L.: Message error</title>
</head>
<body>
  <header>
    <nav>
      <img id="logo" src="img/M_L_logo.png" alt="M L logo">
      <ul role="menubar">
        <li role="presentation"><a role="menuitem" href="contact.html" target="_self">Contact</a></li>
        <li role="presentation"><a role="menuitem" href="work.html" target="_self">Work</a></li>
        <li role="presentation"><a role="menuitem" href="index.html" target="_self">Home</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <p>Warning: An error occured, please check your form inputs.</p>
  </main>
  <footer>
    <div class="footer">
      <a href="imprint.html">Imprint</a>
      <a href="gdpr.html">GDPR</a>
      <p>©2025</p>
    </div>
  </footer>
</body>
</html>');
}
?>