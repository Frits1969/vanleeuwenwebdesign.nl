<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/phpmailer/src/PHPMailer.php';
require __DIR__ . '/phpmailer/src/SMTP.php';
require __DIR__ . '/phpmailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Formulier niet correct verzonden.");
}

// Laad environment variabelen handmatig (parse_ini_file kan struikelen over speciale tekens zoals !)
$envFile = __DIR__ . '/.env';
$dotenv = [];
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0)
            continue;
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $dotenv[trim($parts[0])] = trim($parts[1], " \t\n\r\0\x0B\"'");
        }
    }
}

if (!isset($dotenv['MAIL_PASSWORD'])) {
    die("Configuratiefout: Mailgegevens niet gevonden in .env.");
}

$naam = htmlspecialchars($_POST['naam']);
$email = htmlspecialchars($_POST['email']);
$bedrijf = htmlspecialchars($_POST['bedrijf']);
$bericht = htmlspecialchars($_POST['bericht']);

$mail = new PHPMailer(true);

try {
    // SMTP instellingen
    $mail->isSMTP();
    $mail->Host = $dotenv['MAIL_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $dotenv['MAIL_USERNAME'];
    $mail->Password = $dotenv['MAIL_PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = (int) $dotenv['MAIL_PORT'];

    // Afzender
    $mail->setFrom('frits@vanleeuwenwebdesign.nl', 'Van Leeuwen Webdesign');

    // Ontvanger
    $mail->addAddress('frits@vanleeuwenwebdesign.nl');

    // Reply-to
    $mail->addReplyTo($email, $naam);

    // Inhoud
    $mail->isHTML(false);
    $mail->Subject = "Nieuw bericht via het contactformulier van $naam";
    $mail->Body = "
Naam: $naam
E-mail: $email
Bedrijf: $bedrijf

Bericht:
$bericht
";

    $mail->send();
    $sent = true;

} catch (Exception $e) {
    $sent = false;
}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Bericht verzonden | Van Leeuwen Webdesign</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-99REZ2DLYZ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'G-99REZ2DLYZ');
    </script>
</head>

<body>

    <header>
        <div class="container nav">
            <div class="header-logo">
                <a href="index.html" class="logo-link">
                    <img src="images/logo/logo.png" class="logo-img">
                    <div class="logo-text">Van Leeuwen <span>Webdesign</span></div>
                </a>
            </div>
            <nav>
                <a href="diensten.html">Diensten</a>
                <a href="over_mij.html">Over mij</a>
                <a href="contact.html" class="active">Contact</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container hero-inner">
                <div class="p-4 border rounded shadow-sm bg-white" style="width:100%;max-width:700px;margin:auto;">

                    <?php if ($sent): ?>
                        <h1>Bedankt voor je bericht, <?= $naam ?>!</h1>
                        <p>Ik neem zo snel mogelijk contact met je op.</p>
                    <?php else: ?>
                        <h1>Er ging iets mis</h1>
                        <p>Het bericht kon niet worden verzonden. Probeer het later opnieuw.</p>
                    <?php endif; ?>

                    <a href="contact.html" class="btn btn-primary mt-3">Terug naar contactpagina</a>
                </div>
            </div>
        </section>
    </main>

</body>

</html>